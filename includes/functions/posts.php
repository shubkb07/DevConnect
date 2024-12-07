<?php
/**
 * Posts related functions file.
 *
 * @package MyPlugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access not allowed.' );
}

/**
 * Retrieve posts from the database based on the given arguments.
 *
 * @param array $args Arguments for retrieving posts.
 * @return array Returns an array of posts.
 */
function get_posts( $args = array() ) {
	global $db;
	$prefix = $db->prefix();

	$defaults = array(
		'numberposts'      => 10,
		'category'         => 0,
		'include'          => array(),
		'exclude'          => array(),
		'suppress_filters' => true,
	);

	$args = parse_args( $args, $defaults );

	$query    = "SELECT * FROM {$prefix}posts WHERE 1=1";
	$params   = array();
	$types    = '';

	// Handle include.
	if ( ! empty( $args['include'] ) && is_array( $args['include'] ) ) {
		$placeholders = implode( ',', array_fill( 0, count( $args['include'] ), '?' ) );
		$query       .= " AND ID IN ($placeholders)";
		$params       = array_merge( $params, $args['include'] );
		$types       .= str_repeat( 'i', count( $args['include'] ) );
	}

	// Handle exclude.
	if ( ! empty( $args['exclude'] ) && is_array( $args['exclude'] ) ) {
		$placeholders = implode( ',', array_fill( 0, count( $args['exclude'] ), '?' ) );
		$query       .= " AND ID NOT IN ($placeholders)";
		$params       = array_merge( $params, $args['exclude'] );
		$types       .= str_repeat( 'i', count( $args['exclude'] ) );
	}

	// Handle category filter.
	// Assuming category is stored as a taxonomy named 'category' and we have term_relationships table.
	// category arg can be single or comma separated. Let's handle both.
	if ( ! empty( $args['category'] ) ) {
		$category_ids = array();
		if ( is_string( $args['category'] ) ) {
			$category_ids = array_map( 'intval', explode( ',', $args['category'] ) );
		} elseif ( is_int( $args['category'] ) ) {
			$category_ids = array( $args['category'] );
		}

		if ( ! empty( $category_ids ) ) {
			$placeholders  = implode( ',', array_fill( 0, count( $category_ids ), '?' ) );
			$query        .= " AND ID IN (
				SELECT object_id FROM {$prefix}term_relationships tr
				INNER JOIN {$prefix}term_taxonomy tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
				WHERE tt.term_id IN ($placeholders) AND tt.taxonomy='category'
			)";
			$params        = array_merge( $params, $category_ids );
			$types        .= str_repeat( 'i', count( $category_ids ) );
		}
	}

	// Limit.
	if ( isset( $args['numberposts'] ) && -1 !== $args['numberposts'] ) {
		$query .= " LIMIT ?";
		$params[] = (int) $args['numberposts'];
		$types   .= 'i';
	}

	$results = $db->execute_query( $query, $params, $types );
	return $results ? $results->fetch_all( MYSQLI_ASSOC ) : array();
}

/**
 * Retrieve a specific post by ID.
 *
 * @param int $post_id The ID of the post to retrieve.
 * @return array|null Returns post array or null if not found.
 */
function get_post( $post_id ) {
	global $db;
	$prefix = $db->prefix();

	$query  = "SELECT * FROM {$prefix}posts WHERE ID = ? LIMIT 1";
	$result = $db->execute_query( $query, array( $post_id ), 'i' );
	return $result && $result->num_rows > 0 ? $result->fetch_assoc() : null;
}

/**
 * Retrieve a specific field from a post.
 *
 * @param string $field Field name.
 * @param int    $post_id Post ID.
 * @return mixed Returns the field value or null if not found.
 */
function get_post_field( $field, $post_id ) {
	$post = get_post( $post_id );
	return $post && isset( $post[ $field ] ) ? $post[ $field ] : null;
}

/**
 * Retrieve post ID from slug.
 *
 * @param string $slug Post slug.
 * @return int|null Post ID or null if not found.
 */
function get_post_id_from_slug( $slug ) {
	global $db;
	$prefix = $db->prefix();

	$query  = "SELECT ID FROM {$prefix}posts WHERE slug = ? LIMIT 1";
	$result = $db->execute_query( $query, array( $slug ), 's' );
	if ( $result && $result->num_rows > 0 ) {
		$row = $result->fetch_assoc();
		return (int) $row['ID'];
	}
	return null;
}

/**
 * Insert a new post.
 *
 * @param array $postarr Post data (post_title and post_content required).
 * @return int|false Post ID on success or false on failure.
 */
function insert_post( $postarr ) {
	global $db;
	$prefix = $db->prefix();

	if ( empty( $postarr['post_title'] ) || empty( $postarr['post_content'] ) ) {
		return false;
	}

	$post_title   = $postarr['post_title'];
	$post_content = $postarr['post_content'];
	$post_excerpt = isset( $postarr['post_excerpt'] ) ? $postarr['post_excerpt'] : '';
	$post_status  = isset( $postarr['post_status'] ) ? $postarr['post_status'] : 'publish';
	$comment_status = isset( $postarr['comment_status'] ) ? $postarr['comment_status'] : 'open';

	// Generate unique slug.
	$slug = sanitize_title( $post_title );
	$slug = generate_unique_post_slug( $slug, 0 );

	$datetime      = gmdate( 'Y-m-d H:i:s' );
	$post_author   = isset( $postarr['post_author'] ) ? $postarr['post_author'] : 0;

	$query = "INSERT INTO {$prefix}posts (post_author, post_date_gmt, post_content, post_title, post_excerpt, post_status, post_positive, post_negative, comment_status, post_name, post_modified_gmt, slug, comment_count)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	$params = array(
		$post_author,
		$datetime,
		$post_content,
		$post_title,
		$post_excerpt,
		$post_status,
		0,
		0,
		$comment_status,
		$slug,
		$datetime,
		$slug,
		0,
	);
	$types  = 'isssssssssssi';

	$result = $db->execute_query( $query, $params, $types );
    $post_id = $db->get_connection()->insert_id;

    return $post_id ? $post_id : false;
}

/**
 * Update an existing post.
 *
 * @param array $postarr Post data (ID or slug required).
 * @return bool True on success, false on failure.
 */
function update_post( $postarr ) {
	global $db;
	$prefix = $db->prefix();

	// Identify the post.
	$post_id = 0;
	if ( isset( $postarr['ID'] ) ) {
		$post_id = (int) $postarr['ID'];
	} elseif ( isset( $postarr['slug'] ) ) {
		$post_id = get_post_id_from_slug( $postarr['slug'] );
	}

	if ( ! $post_id ) {
		return false;
	}

	$post = get_post( $post_id );
	if ( ! $post ) {
		return false;
	}

	$fields        = array();
	$params        = array();
	$types         = '';

	if ( isset( $postarr['post_title'] ) ) {
		$fields[] = "post_title = ?";
		$params[] = $postarr['post_title'];
		$types   .= 's';
	}
	if ( isset( $postarr['post_content'] ) ) {
		$fields[] = "post_content = ?";
		$params[] = $postarr['post_content'];
		$types   .= 's';
	}
	if ( isset( $postarr['post_excerpt'] ) ) {
		$fields[] = "post_excerpt = ?";
		$params[] = $postarr['post_excerpt'];
		$types   .= 's';
	}
	if ( isset( $postarr['post_status'] ) ) {
		$fields[] = "post_status = ?";
		$params[] = $postarr['post_status'];
		$types   .= 's';
	}
	if ( isset( $postarr['comment_status'] ) ) {
		$fields[] = "comment_status = ?";
		$params[] = $postarr['comment_status'];
		$types   .= 's';
	}

	// If slug provided or title changed, we may need to regenerate slug.
	$new_slug = null;
	if ( isset( $postarr['slug'] ) ) {
		$new_slug = $postarr['slug'];
	} elseif ( isset( $postarr['post_title'] ) ) {
		$new_slug = sanitize_title( $postarr['post_title'] );
	}

	if ( $new_slug ) {
		$new_slug = generate_unique_post_slug( $new_slug, $post_id );
		$fields[] = "slug = ?";
		$params[] = $new_slug;
		$types   .= 's';
	}

	if ( empty( $fields ) ) {
		// Nothing to update.
		return true;
	}

	$fields[] = "post_modified_gmt = ?";
	$params[] = gmdate( 'Y-m-d H:i:s' );
	$types   .= 's';

	$params[] = $post_id;
	$types   .= 'i';

	$query = "UPDATE {$prefix}posts SET " . implode( ', ', $fields ) . " WHERE ID = ?";
	$result = $db->execute_query( $query, $params, $types );

	return (bool) $result;
}

/**
 * Delete a post permanently by post ID or slug.
 *
 * @param int|string $post_identifier Post ID or slug.
 * @return bool True on success, false on failure.
 */
function delete_post( $post_identifier ) {
	global $db;
	$prefix = $db->prefix();

	$post_id = 0;
	if ( is_int( $post_identifier ) ) {
		$post_id = $post_identifier;
	} else {
		$post_id = get_post_id_from_slug( $post_identifier );
	}

	if ( ! $post_id ) {
		return false;
	}

	// Delete postmeta.
	$db->execute_query( "DELETE FROM {$prefix}postmeta WHERE post_id = ?", array( $post_id ), 'i' );

	// Delete term relationships.
	$db->execute_query( "DELETE FROM {$prefix}term_relationships WHERE object_id = ?", array( $post_id ), 'i' );

	// Delete the post.
	$result = $db->execute_query( "DELETE FROM {$prefix}posts WHERE ID = ?", array( $post_id ), 'i' );

	return (bool) $result;
}

/**
 * Move a post to trash.
 *
 * @param int|string $post_identifier Post ID or slug.
 * @return bool True on success, false on failure.
 */
function trash_post( $post_identifier ) {
	return update_post_status( $post_identifier, 'trash' );
}

/**
 * Restore a post from trash.
 *
 * @param int|string $post_identifier Post ID or slug.
 * @return bool True on success, false on failure.
 */
function untrash_post( $post_identifier ) {
	return update_post_status( $post_identifier, 'publish' );
}

/**
 * Add post meta data.
 *
 * @param int    $post_id Post ID.
 * @param string $meta_key Meta key.
 * @param mixed  $meta_value Meta value.
 * @param bool   $unique Whether the meta key should be unique.
 * @return int|false Meta ID on success or false on failure.
 */
function add_post_meta( $post_id, $meta_key, $meta_value, $unique = false ) {
	global $db;
	$prefix = $db->prefix();

	if ( $unique ) {
		$existing = get_post_meta( $post_id, $meta_key, false );
		if ( ! empty( $existing ) ) {
			return false;
		}
	}

	$query = "INSERT INTO {$prefix}postmeta (post_id, meta_key, meta_value) VALUES (?, ?, ?)";
	$result = $db->execute_query( $query, array( $post_id, $meta_key, maybe_serialize( $meta_value ) ), 'iss' );

	if ( $result ) {
		return $db->get_connection()->insert_id;
	}
	return false;
}

/**
 * Get post meta data.
 *
 * @param int    $post_id Post ID.
 * @param string $key Meta key.
 * @param bool   $single Whether to return a single value.
 * @return mixed Single meta value or array of values.
 */
function get_post_meta( $post_id, $key = '', $single = false ) {
	global $db;
	$prefix = $db->prefix();

	$params = array( $post_id );
	$types  = 'i';
	$query  = "SELECT meta_value FROM {$prefix}postmeta WHERE post_id = ?";

	if ( $key !== '' ) {
		$query   .= " AND meta_key = ?";
		$params[] = $key;
		$types   .= 's';
	}

	$result = $db->execute_query( $query, $params, $types );
	if ( ! $result || $result->num_rows === 0 ) {
		return $single ? '' : array();
	}

	$values = array();
	while ( $row = $result->fetch_assoc() ) {
		$values[] = maybe_unserialize( $row['meta_value'] );
	}

	if ( $single ) {
		return $values[0];
	}
	return $values;
}

/**
 * Update post meta data.
 *
 * @param int    $post_id Post ID.
 * @param string $meta_key Meta key.
 * @param mixed  $meta_value Meta value.
 * @param mixed  $prev_value Previous meta value to match for update.
 * @return bool True on success, false on failure.
 */
function update_post_meta( $post_id, $meta_key, $meta_value, $prev_value = '' ) {
	global $db;
	$prefix = $db->prefix();

	// Check if meta exists.
	$query   = "SELECT meta_id, meta_value FROM {$prefix}postmeta WHERE post_id = ? AND meta_key = ?";
	$params  = array( $post_id, $meta_key );
	$types   = 'is';
	$results = $db->execute_query( $query, $params, $types );

	if ( ! $results || $results->num_rows === 0 ) {
		// No meta found, insert new.
		return (bool) add_post_meta( $post_id, $meta_key, $meta_value, false );
	}

	$meta_value_serialized = maybe_serialize( $meta_value );

	// If prev_value specified, update only rows that match it.
	if ( '' !== $prev_value ) {
		$prev_value_serialized = maybe_serialize( $prev_value );
		$query = "UPDATE {$prefix}postmeta SET meta_value = ? WHERE post_id = ? AND meta_key = ? AND meta_value = ?";
		$params = array( $meta_value_serialized, $post_id, $meta_key, $prev_value_serialized );
		$types = 'siss';
	} else {
		$query = "UPDATE {$prefix}postmeta SET meta_value = ? WHERE post_id = ? AND meta_key = ?";
		$params = array( $meta_value_serialized, $post_id, $meta_key );
		$types = 'sis';
	}

	$result = $db->execute_query( $query, $params, $types );

	if ( ! $result || $db->get_connection()->affected_rows === 0 ) {
		// If no rows updated, possibly prev_value didn't match, insert new if prev_value given.
		if ( '' !== $prev_value ) {
			return (bool) add_post_meta( $post_id, $meta_key, $meta_value, false );
		}
	}

	return (bool) $result;
}

/**
 * Delete post meta data.
 *
 * @param int          $post_id Post ID.
 * @param string       $meta_key Meta key.
 * @param string|array $value Meta value(s) to delete. If empty, delete all meta_key entries.
 * @return bool True on success, false on failure.
 */
function delete_post_meta( $post_id, $meta_key, $value = '' ) {
	global $db;
	$prefix = $db->prefix();

	if ( $value === '' ) {
		// Delete all meta with that key.
		$query = "DELETE FROM {$prefix}postmeta WHERE post_id = ? AND meta_key = ?";
		$params = array( $post_id, $meta_key );
		$types = 'is';
	} else {
		// Delete only meta with that value.
		$value_list = (array) $value;
		$placeholders = implode( ',', array_fill( 0, count( $value_list ), '?' ) );
		$query = "DELETE FROM {$prefix}postmeta WHERE post_id = ? AND meta_key = ? AND meta_value IN ($placeholders)";
		$params = array_merge( array( $post_id, $meta_key ), $value_list );
		$types = 'is' . str_repeat( 's', count( $value_list ) );
	}

	$result = $db->execute_query( $query, $params, $types );
	return (bool) $result;
}

/**
 * Retrieve the post status.
 *
 * @param int|string $post_identifier Post ID or slug.
 * @return string|null Post status or null if not found.
 */
function get_post_status( $post_identifier ) {
	$post = get_post_by_identifier( $post_identifier );
	return $post ? $post['post_status'] : null;
}

/**
 * Check if viewing a specific post type archive.
 * This is a placeholder function. For now, let's return false.
 *
 * @param int|string $post_identifier Post ID or slug.
 * @return bool Always false for this example.
 */
function is_post_type_archive( $post_identifier ) {
	// Placeholder: In a real system, we'd check if current query is a post type archive.
	// For now, return false.
	return false;
}

/**
 * Retrieve terms for a post.
 *
 * @param int    $post_id Post ID.
 * @param string $taxonomy Taxonomy name.
 * @return array Array of terms or empty array if none.
 */
function get_the_terms( $post_id, $taxonomy ) {
	global $db;
	$prefix = $db->prefix();

	$query = "SELECT t.* FROM {$prefix}terms t
		INNER JOIN {$prefix}term_taxonomy tt ON t.term_id = tt.term_id
		INNER JOIN {$prefix}term_relationships tr ON tt.term_taxonomy_id = tr.term_taxonomy_id
		WHERE tr.object_id = ? AND tt.taxonomy = ?";

	$result = $db->execute_query( $query, array( $post_id, $taxonomy ), 'is' );
	if ( ! $result || $result->num_rows === 0 ) {
		return array();
	}

	$terms = array();
	while ( $row = $result->fetch_assoc() ) {
		$terms[] = $row;
	}

	return $terms;
}

/**
 * Get a list of terms for a post.
 *
 * @param int    $post_id Post ID.
 * @param string $taxonomy Taxonomy name.
 * @param string $separator Separator for terms, default ','.
 * @return string List of term names separated by the separator.
 */
function get_the_term_list( $post_id, $taxonomy, $separator = ',' ) {
	$terms = get_the_terms( $post_id, $taxonomy );
	if ( empty( $terms ) ) {
		return '';
	}

	$names = list_pluck( $terms, 'name' );
	return implode( $separator, $names );
}

/**
 * Set terms for a post.
 *
 * @param int    $post_id Post ID.
 * @param array  $term_ids Array of term IDs.
 * @param string $taxonomy Taxonomy name.
 * @param bool   $append Whether to append terms or replace them.
 * @return bool True on success, false on failure.
 */
function set_post_terms( $post_id, $term_ids, $taxonomy, $append = false ) {
	global $db;
	$prefix = $db->prefix();

	if ( ! $append ) {
		// Remove existing terms for this taxonomy.
		$query = "DELETE tr FROM {$prefix}term_relationships tr
			INNER JOIN {$prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
			WHERE tr.object_id = ? AND tt.taxonomy = ?";
		$db->execute_query( $query, array( $post_id, $taxonomy ), 'is' );
	}

	// Insert new relationships.
	foreach ( $term_ids as $term_id ) {
		// Get term_taxonomy_id.
		$query = "SELECT term_taxonomy_id FROM {$prefix}term_taxonomy WHERE term_id = ? AND taxonomy = ? LIMIT 1";
		$result = $db->execute_query( $query, array( $term_id, $taxonomy ), 'is' );
		if ( ! $result || $result->num_rows === 0 ) {
			continue;
		}
		$row = $result->fetch_assoc();
		$term_taxonomy_id = $row['term_taxonomy_id'];

		// Insert relationship if not exists.
		$query = "INSERT IGNORE INTO {$prefix}term_relationships (object_id, term_taxonomy_id) VALUES (?, ?)";
		$db->execute_query( $query, array( $post_id, $term_taxonomy_id ), 'ii' );
	}

	return true;
}

/**
 * Remove terms from a post.
 *
 * @param int    $post_id Post ID.
 * @param array  $term_ids Term IDs to remove.
 * @param string $taxonomy Taxonomy name.
 * @return bool True on success, false on failure.
 */
function remove_object_terms( $post_id, $term_ids, $taxonomy ) {
	global $db;
	$prefix = $db->prefix();

	if ( empty( $term_ids ) ) {
		return false;
	}

	$placeholders = implode( ',', array_fill( 0, count( $term_ids ), '?' ) );
	$params = array_merge( array( $taxonomy ), $term_ids );
	$types = 's' . str_repeat( 'i', count( $term_ids ) );

	$query = "DELETE tr FROM {$prefix}term_relationships tr
		INNER JOIN {$prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
		WHERE tr.object_id = $post_id AND tt.taxonomy = ? AND tt.term_id IN ($placeholders)";

	$result = $db->execute_query( $query, $params, $types );
	return (bool) $result;
}

/**
 * Retrieve the post's permalink.
 *
 * @param int    $post_id Post ID.
 * @param string $taxonomy Taxonomy name (not used here, just for compatibility).
 * @return string Permalink URL.
 */
function get_permalink( $post_id, $taxonomy = '' ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		return '';
	}
	$slug = $post['slug'];
	return site_url( '/' . $slug . '/' );
}

/**
 * Get a specific post's permalink (slug).
 *
 * @param int $post_id Post ID.
 * @return string Post permalink.
 */
function get_post_permalink( $post_id ) {
	return get_permalink( $post_id );
}

/**
 * Retrieve author metadata.
 *
 * @param int $author_id Author ID.
 * @return array|null Author row or null if not found.
 */
function get_the_author_meta( $author_id ) {
	global $db;
	$prefix = $db->prefix();

	$query = "SELECT * FROM {$prefix}users WHERE ID = ? LIMIT 1";
	$result = $db->execute_query( $query, array( $author_id ), 'i' );
	return ( $result && $result->num_rows > 0 ) ? $result->fetch_assoc() : null;
}

/**
 * Get a link to the author's posts.
 *
 * @param int $author_id Author ID.
 * @return string Author posts link URL.
 */
function get_the_author_posts_link( $author_id ) {
	$author = get_the_author_meta( $author_id );
	if ( ! $author ) {
		return '';
	}

	$nicename = $author['user_nicename'];
	return site_url( '/author/' . $nicename . '/' );
}

/**
 * Update a post's status.
 *
 * @param int|string $post_identifier Post ID or slug.
 * @param string     $status New status.
 * @return bool True on success, false on failure.
 */
function update_post_status( $post_identifier, $status ) {
	global $db;
	$prefix = $db->prefix();

	$post_id = 0;
	if ( is_int( $post_identifier ) ) {
		$post_id = $post_identifier;
	} else {
		$post_id = get_post_id_from_slug( $post_identifier );
	}

	if ( ! $post_id ) {
		return false;
	}

	$query = "UPDATE {$prefix}posts SET post_status = ?, post_modified_gmt = ? WHERE ID = ?";
	$params = array( $status, gmdate( 'Y-m-d H:i:s' ), $post_id );
	$types  = 'ssi';

	$result = $db->execute_query( $query, $params, $types );
	return (bool) $result;
}

/**
 * Get post by ID or slug.
 *
 * @param int|string $identifier Post ID or slug.
 * @return array|null Post array or null if not found.
 */
function get_post_by_identifier( $identifier ) {
	if ( is_int( $identifier ) ) {
		return get_post( $identifier );
	}
	$post_id = get_post_id_from_slug( $identifier );
	return $post_id ? get_post( $post_id ) : null;
}

/**
 * Generate a unique slug for a post.
 *
 * @param string $slug Proposed slug.
 * @param int    $exclude_id Post ID to exclude from uniqueness check.
 * @return string Unique slug.
 */
function generate_unique_post_slug( $slug, $exclude_id = 0 ) {
	global $db;
	$prefix = $db->prefix();

	$original_slug = $slug;
	$i             = 1;
	while ( true ) {
		$query  = "SELECT ID FROM {$prefix}posts WHERE slug = ?";
		$params = array( $slug );
		$types  = 's';

		if ( $exclude_id > 0 ) {
			$query .= " AND ID <> ?";
			$params[] = $exclude_id;
			$types   .= 'i';
		}

		$result = $db->execute_query( $query, $params, $types );
		if ( ! $result || $result->num_rows === 0 ) {
			// Unique.
			return $slug;
		}

		$slug = $original_slug . '-' . $i;
		$i++;
	}
}

/**
 * Parse arguments and merge defaults.
 *
 * @param array $args Arguments.
 * @param array $defaults Default values.
 * @return array Merged arguments.
 */
function parse_args( $args, $defaults = array() ) {
	if ( is_object( $args ) ) {
		$args = get_object_vars( $args );
	} elseif ( ! is_array( $args ) ) {
		$args = array();
	}
	return array_merge( $defaults, $args );
}

/**
 * Pluck a certain field out of each object in a list.
 *
 * @param array  $list List of arrays or objects.
 * @param string $field Field name.
 * @return array Array of values.
 */
function list_pluck( $list, $field ) {
	$values = array();
	foreach ( $list as $item ) {
		if ( is_object( $item ) && isset( $item->$field ) ) {
			$values[] = $item->$field;
		} elseif ( is_array( $item ) && isset( $item[ $field ] ) ) {
			$values[] = $item[ $field ];
		}
	}
	return $values;
}
