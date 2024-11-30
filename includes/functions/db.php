<?php

if (!defined('ABSPATH')) {
    header('Location: /');
    die();
}

include_once ABSPATH . 'config.php';

try {
    // Connect to the database.
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_error) {
        throw new Exception('Database connection failed: ' . $mysqli->connect_error);
    }

    // Set character set to utf8mb4
    if (!$mysqli->set_charset("utf8mb4")) {
        throw new Exception("Error loading character set utf8mb4: " . $mysqli->error);
    }

    // Retrieve the table prefix.
    $table_prefix = DB_PREFIX;

    // Define table creation SQL in a logical order.
    $table_queries = [
        "{$table_prefix}users" => "CREATE TABLE IF NOT EXISTS {$table_prefix}users (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_login varchar(60) NOT NULL DEFAULT '',
            user_pass varchar(255) NOT NULL DEFAULT '',
            user_nicename varchar(50) NOT NULL DEFAULT '',
            user_email varchar(100) NOT NULL DEFAULT '',
            user_url varchar(100) NOT NULL DEFAULT '',
            user_registered datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            user_activation_key varchar(255) NOT NULL DEFAULT '',
            user_status int(11) NOT NULL DEFAULT '0',
            display_name varchar(250) NOT NULL DEFAULT '',
            PRIMARY KEY (ID),
            UNIQUE KEY user_login_key (user_login),
            UNIQUE KEY user_nicename (user_nicename),
            UNIQUE KEY user_email (user_email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}terms" => "CREATE TABLE IF NOT EXISTS {$table_prefix}terms (
            term_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(200) NOT NULL DEFAULT '',
            slug varchar(200) NOT NULL DEFAULT '',
            PRIMARY KEY (term_id),
            UNIQUE KEY slug (slug)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}term_taxonomy" => "CREATE TABLE IF NOT EXISTS {$table_prefix}term_taxonomy (
            term_taxonomy_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            term_id bigint(20) unsigned NOT NULL DEFAULT 0,
            taxonomy varchar(32) NOT NULL DEFAULT '',
            description longtext NOT NULL,
            count bigint(20) NOT NULL DEFAULT 0,
            PRIMARY KEY (term_taxonomy_id),
            UNIQUE KEY term_id_taxonomy (term_id, taxonomy),
            FOREIGN KEY (term_id) REFERENCES {$table_prefix}terms(term_id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}termmeta" => "CREATE TABLE IF NOT EXISTS {$table_prefix}termmeta (
            meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            term_id bigint(20) unsigned NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY (meta_id),
            KEY term_id (term_id),
            FOREIGN KEY (term_id) REFERENCES {$table_prefix}terms(term_id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}options" => "CREATE TABLE IF NOT EXISTS {$table_prefix}options (
            option_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            option_name varchar(191) NOT NULL DEFAULT '',
            option_value longtext NOT NULL,
            autoload varchar(20) NOT NULL DEFAULT 'yes',
            PRIMARY KEY (option_id),
            UNIQUE KEY option_name (option_name)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}posts" => "CREATE TABLE IF NOT EXISTS {$table_prefix}posts (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            post_author bigint(20) unsigned NOT NULL DEFAULT '0',
            post_date_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            post_content longtext NOT NULL,
            post_title text NOT NULL,
            post_excerpt text NOT NULL,
            post_status varchar(20) NOT NULL DEFAULT 'publish',
            post_reputation int(11) NOT NULL DEFAULT '0',
            comment_status varchar(20) NOT NULL DEFAULT 'open',
            post_name varchar(200) NOT NULL DEFAULT '',
            post_modified_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            slug varchar(255) NOT NULL DEFAULT '',
            comment_count bigint(20) NOT NULL DEFAULT '0',
            PRIMARY KEY (ID),
            FOREIGN KEY (post_author) REFERENCES {$table_prefix}users(ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}postmeta" => "CREATE TABLE IF NOT EXISTS {$table_prefix}postmeta (
            meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            post_id bigint(20) unsigned NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY (meta_id),
            KEY post_id (post_id),
            FOREIGN KEY (post_id) REFERENCES {$table_prefix}posts(ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}comments" => "CREATE TABLE IF NOT EXISTS {$table_prefix}comments (
            comment_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            comment_post_ID bigint(20) unsigned NOT NULL DEFAULT '0',
            comment_author tinytext NOT NULL,
            comment_reputation int(11) NOT NULL DEFAULT '0',
            comment_author_email varchar(100) NOT NULL DEFAULT '',
            comment_author_url varchar(200) NOT NULL DEFAULT '',
            comment_author_IP varchar(100) NOT NULL DEFAULT '',
            comment_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            comment_date_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            comment_content text NOT NULL,
            comment_agent varchar(255) NOT NULL DEFAULT '',
            comment_type varchar(20) NOT NULL DEFAULT 'comment',
            comment_parent bigint(20) unsigned NOT NULL DEFAULT '0',
            user_id bigint(20) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (comment_ID),
            FOREIGN KEY (comment_post_ID) REFERENCES {$table_prefix}posts(ID) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES {$table_prefix}users(ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}commentmeta" => "CREATE TABLE IF NOT EXISTS {$table_prefix}commentmeta (
            meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            comment_id bigint(20) unsigned NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY (meta_id),
            KEY comment_id (comment_id),
            FOREIGN KEY (comment_id) REFERENCES {$table_prefix}comments(comment_ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}usermeta" => "CREATE TABLE IF NOT EXISTS {$table_prefix}usermeta (
            umeta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY (umeta_id),
            KEY user_id (user_id),
            FOREIGN KEY (user_id) REFERENCES {$table_prefix}users(ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    ];

    // Execute each table creation query.
    foreach ($table_queries as $table_name => $query) {
        if ($mysqli->query($query) === true) {
            echo "Table `$table_name` created successfully.<br>";
        } else {
            echo "Error creating table `$table_name`: " . $mysqli->error . "<br>";
        }
    }

    // Pause for 2 seconds
    sleep(2);

    // Insert data as per the $insert array
    $insert = array(
        "{$table_prefix}options" => array(
            array(
                "option_name" => "site_url",
                "option_value" => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'],
                "autoload" => "yes",
            ),
            array(
                "option_name" => "roles",
                "option_value" => serialize(
                    array(
                        'admin' => array(
                            'name' => 'Administrator',
                            'capabilities' => array(
                                'manage_options' => true,
                                'edit_posts' => true,
                                'edit_users' => true,
                                'delete_users' => true,
                                'create_posts' => true,
                                'publish_posts' => true,
                                'edit_pages' => true,
                                'manage_categories' => true,
                                'moderate_comments' => true,
                                'manage_roles' => true,
                            ),
                        ),
                        'subscriber' => array(
                            'name' => 'Subscriber',
                            'capabilities' => array(
                                'read' => true,
                                'create_posts' => true,
                                'edit_posts' => true,
                                'delete_posts' => true,
                            ),
                        ),
                    )
                ),
                "autoload" => "yes",
            ),
        ),
    );

    foreach ($insert as $table => $rows) {
        foreach ($rows as $row) {
            // Prepare columns and values
            $columns = array_keys($row);
            $placeholders = array_fill(0, count($columns), '?');
            $types = '';
            $values = [];

            foreach ($columns as $column) {
                if (is_int($row[$column])) {
                    $types .= 'i';
                } elseif (is_double($row[$column])) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $row[$column];
            }

            $sql = "INSERT INTO `$table` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

            $stmt = $mysqli->prepare($sql);
            if ($stmt === false) {
                echo "Prepare failed for table `$table`: " . $mysqli->error . "<br>";
                continue;
            }

            // Bind parameters
            $stmt->bind_param($types, ...$values);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Data inserted into `$table` successfully.<br>";
            } else {
                // Check for duplicate entry based on UNIQUE KEY
                if ($mysqli->errno == 1062) {
                    echo "Duplicate entry for table `$table`: " . $mysqli->error . "<br>";
                } else {
                    echo "Error inserting data into `$table`: " . $mysqli->error . "<br>";
                }
            }

            $stmt->close();
        }
    }

    // Close the connection.
    $mysqli->close();
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>
