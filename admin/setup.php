<?php

if (! defined( 'ABSPATH' ) ) {
    header('Location: /');
    die();
}

// Default values.
$error_message = '';
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = '';
$table_prefix = 'dc_';

// Generate a secure AUTH_KEY.
function generate_auth_key_setup($length = 64, $include_symbols = true) {
    if ($length < 32) {
        throw new Exception('AUTH_KEY length must be at least 32 characters for security.');
    }

    // Define character sets
    $sets = [
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ',        // Uppercase letters
        'abcdefghijklmnopqrstuvwxyz',        // Lowercase letters
        '0123456789',                        // Numbers
    ];

    // Include symbols if specified
    if ($include_symbols) {
        $sets[] = '!@#$%^&*()-_=+[]{}|;:,.<>?/~`'; // Symbols
    }

    // Shuffle the sets to randomize their order
    shuffle($sets);

    $auth_key = '';
    $all_characters = implode('', $sets); // Combine all sets into one string
    $all_length = strlen($all_characters);

    // Ensure at least one character from each set is included
    foreach ($sets as $set) {
        $auth_key .= $set[random_int(0, strlen($set) - 1)];
    }

    // Fill the remaining length with random characters from the combined set
    for ($i = strlen($auth_key); $i < $length; $i++) {
        $auth_key .= $all_characters[random_int(0, $all_length - 1)];
    }

    // Shuffle the final key to ensure the placement of characters is random
    return str_shuffle($auth_key);
}

// Handle form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST values.
    $db_host = $_POST['db_host'] ?? 'localhost';
    $db_user = $_POST['db_user'] ?? 'root';
    $db_password = $_POST['db_password'] ?? '';
    $db_name = $_POST['db_name'] ?? '';
    $table_prefix = $_POST['table_prefix'] ?? 'dc_';

    // Validate required fields.
    if (empty($db_host) || empty($db_user) || empty($db_name)) {
        $error_message = 'Hostname, username, and database name are required.';
    } else {
        try {
            // Attempt database connection.
            $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

            if ($mysqli->connect_error) {
                throw new Exception($mysqli->connect_error);
            }

            // Database connection successful.

            // Path to config-sample.php and config.php.
            $sample_file_path = ABSPATH . 'config-sample.php';
            $new_file_path = ABSPATH . 'config.php';

            // Read the content of config-sample.php.
            $sample_content = file_get_contents($sample_file_path);

            if ($sample_content === false) {
                $error_message = 'Failed to read config-sample.php.';
            } else {
                // Replace placeholders with form values.
                $updated_content = str_replace(
                    [
                        "define('DB_HOST', '');",
                        "define('DB_USER', '');",
                        "define('DB_PASS', '');",
                        "define('DB_NAME', '');",
                        "define('DB_PREFIX', '');",
                        "define('SECURE_AUTH_KEY', '');",
                        "define('LOGGED_IN_KEY', '');",
                        "define('NONCE_KEY', '');",
                        "define('AUTH_SALT', '');",
                        "define('SECURE_AUTH_SALT', '');",
                        "define('LOGGED_IN_SALT', '');",
                        "define('NONCE_SALT', '');",
                        "define('CACHE_KEY_SALT', '');",
                    ],
                    [
                        "define('DB_HOST', '$db_host');",
                        "define('DB_USER', '$db_user');",
                        "define('DB_PASS', '$db_password');",
                        "define('DB_NAME', '$db_name');",
                        "define('DB_PREFIX', '$table_prefix');",
                        "define('SECURE_AUTH_KEY', '" . generate_auth_key_setup() ."');",
                        "define('LOGGED_IN_KEY', '" . generate_auth_key_setup() ."');",
                        "define('NONCE_KEY', '" . generate_auth_key_setup() ."');",
                        "define('AUTH_SALT', '" . generate_auth_key_setup() ."');",
                        "define('SECURE_AUTH_SALT', '" . generate_auth_key_setup() ."');",
                        "define('LOGGED_IN_SALT', '" . generate_auth_key_setup() ."');",
                        "define('NONCE_SALT', '" . generate_auth_key_setup() ."');",
                        "define('CACHE_KEY_SALT', '" . generate_auth_key_setup() ."');",
                    ],
                    $sample_content
                );

                if (!is_dir(dirname($new_file_path))) {
                    mkdir(dirname($new_file_path), 0777, true);
                }

                // Write the updated content to config.php.
                if (file_put_contents($new_file_path, $updated_content) === false) {
                    $error_message = 'Failed to create config.php.';
                } else {
                    // Create Tables.
                    include_once ABSPATH . 'includes/functions/db.php';

                    // Redirect to /site-setup.
                    header('Location: /site-setup');
                    exit();
                }
            }
        } catch (Exception $e) {
            // Capture and display the connection error.
            $error_message = 'Database connection failed while checking: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Database</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
        }
        .setup-container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
            text-align: center;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            font-size: 0.9em;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9em;
        }
        input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <h1>Setup Database</h1>
        <form method="POST" action="">
            <?php if ($error_message): ?>
                <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="db_host">Hostname</label>
                <input type="text" id="db_host" name="db_host" value="<?php echo htmlspecialchars($db_host); ?>" required>
            </div>
            <div class="form-group">
                <label for="db_user">Username</label>
                <input type="text" id="db_user" name="db_user" value="<?php echo htmlspecialchars($db_user); ?>" required>
            </div>
            <div class="form-group">
                <label for="db_password">Password</label>
                <input type="password" id="db_password" name="db_password" value="<?php echo htmlspecialchars($db_password); ?>" required>
            </div>
            <div class="form-group">
                <label for="db_name">Database Name</label>
                <input type="text" id="db_name" name="db_name" value="<?php echo htmlspecialchars($db_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="table_prefix">Table Prefix</label>
                <input type="text" id="table_prefix" name="table_prefix" value="<?php echo htmlspecialchars($table_prefix); ?>">
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
