<?php
/**
 * API endpoints for handling posts via REST routes.
 *
 * This file registers API routes for retrieving, creating, updating, and deleting posts
 * by utilizing functions defined in posts.php.
 *
 * Routes:
 *  - GET:    /dc/posts        Retrieves posts according to provided criteria.
 *  - PUT:    /dc/posts        Creates a new post.
 *  - POST:   /dc/posts        Updates an existing post.
 *  - DELETE: /dc/posts        Deletes a post.
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access not allowed.' );
}

/**
 * Registers API routes for handling posts.
 */
register_api_route( 'dc', 'posts', 'get', 'posts_get', array() );
register_api_route( 'dc', 'posts', 'put', 'posts_put', array() );
register_api_route( 'dc', 'posts', 'post', 'posts_post', array() );
register_api_route( 'dc', 'posts', 'delete', 'posts_delete', array() );

/**
 * Handle GET requests for retrieving posts.
 *
 * Accepts various query parameters (e.g., 'include', 'exclude', 'numberposts')
 * and returns a list of posts matching the provided criteria.
 *
 * @param array $args Request arguments.
 * @return array Response array with status, request type, and result.
 */
function posts_get( $args ) {
    // Map request arguments to get_posts arguments.
    $get_args = array(
        'numberposts' => isset( $args['per_page'] ) ? (int) $args['per_page'] : 10,
        'include'     => isset( $args['include'] ) && is_array( $args['include'] ) ? $args['include'] : array(),
        'exclude'     => isset( $args['exclude'] ) && is_array( $args['exclude'] ) ? $args['exclude'] : array(),
        'category'    => isset( $args['categories'] ) ? $args['categories'] : 0,
    );

    // Retrieve posts.
    $posts = get_posts( $get_args );

    return array(
        'status'       => 'success',
        'request_type' => 'GET',
        'result'       => $posts,
        'error'        => '',
    );
}

/**
 * Handle PUT requests for creating a new post.
 *
 * Requires 'title' and 'content' for creating a post. Other fields are optional.
 *
 * @param array $args Request arguments.
 * @return array Response array with status, request type, result, or error.
 */
function posts_put( $args ) {
    // Prepare data for insertion.
    $post_data = array(
        'post_title'     => isset( $args['title'] ) ? $args['title'] : '',
        'post_content'   => isset( $args['content'] ) ? $args['content'] : '',
        'post_excerpt'   => isset( $args['excerpt'] ) ? $args['excerpt'] : '',
        'post_status'    => isset( $args['status'] ) ? $args['status'] : 'publish',
        'comment_status' => isset( $args['comment_status'] ) ? $args['comment_status'] : 'open',
        'post_author'    => isset( $args['author'] ) ? (int) $args['author'] : 0,
        'post_type'      => 'post',
    );

    $new_post_id = insert_post( $post_data );

    if ( $new_post_id ) {
        return array(
            'status'       => 'success',
            'request_type' => 'PUT',
            'result'       => array( 'post_id' => $new_post_id ),
            'error'        => '',
        );
    }

    return array(
        'status'       => 'failure',
        'request_type' => 'PUT',
        'result'       => '',
        'error'        => 'Failed to create the post.',
    );
}

/**
 * Handle POST requests for updating an existing post.
 *
 * Requires 'id' to identify the post. Other fields are optional and will update if provided.
 *
 * @param array $args Request arguments.
 * @return array Response array with status, request type, result, or error.
 */
function posts_post( $args ) {
    if ( ! isset( $args['id'] ) ) {
        return array(
            'status'       => 'failure',
            'request_type' => 'POST',
            'result'       => '',
            'error'        => 'Post ID is required to update a post.',
        );
    }

    // Prepare data for update. Only include keys if they exist.
    $update_data = array(
        'ID'              => (int) $args['id'],
        'post_title'      => isset( $args['title'] ) ? $args['title'] : null,
        'post_content'    => isset( $args['content'] ) ? $args['content'] : null,
        'post_excerpt'    => isset( $args['excerpt'] ) ? $args['excerpt'] : null,
        'post_status'     => isset( $args['status'] ) ? $args['status'] : null,
        'comment_status'  => isset( $args['comment_status'] ) ? $args['comment_status'] : null,
        'post_author'     => isset( $args['author'] ) ? (int) $args['author'] : null,
        'slug'            => isset( $args['slug'] ) ? $args['slug'] : null,
    );

    // Filter out null values so we don't accidentally set empty fields.
    $update_data = array_filter( $update_data, function ( $value ) {
        return $value !== null;
    } );

    $updated = update_post( $update_data );

    if ( $updated ) {
        return array(
            'status'       => 'success',
            'request_type' => 'POST',
            'result'       => 'Post updated successfully.',
            'error'        => '',
        );
    }

    return array(
        'status'       => 'failure',
        'request_type' => 'POST',
        'result'       => '',
        'error'        => 'Failed to update the post.',
    );
}

/**
 * Handle DELETE requests for deleting a post.
 *
 * Requires 'id' to identify the post. If successful, the post will be deleted.
 *
 * @param array $args Request arguments.
 * @return array Response array with status, request type, result, or error.
 */
function posts_delete( $args ) {
    if ( ! isset( $args['id'] ) ) {
        return array(
            'status'       => 'failure',
            'request_type' => 'DELETE',
            'result'       => '',
            'error'        => 'Post ID is required to delete a post.',
        );
    }

    $deleted = delete_post( $args['id'] );

    if ( $deleted ) {
        return array(
            'status'       => 'success',
            'request_type' => 'DELETE',
            'result'       => 'Post deleted successfully.',
            'error'        => '',
        );
    }

    return array(
        'status'       => 'failure',
        'request_type' => 'DELETE',
        'result'       => '',
        'error'        => 'Failed to delete the post.',
    );
}
