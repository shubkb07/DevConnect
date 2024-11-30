<?php

if (!defined('ABSPATH')) {
    die('Direct access not allowed.');
}

// Start output buffering to prevent accidental output before headers.
ob_start();

// Initialize error messages.
$error_messages = [
    'username' => '',
    'password' => '',
    'email' => '',
    'general' => '',
];

// Default input values (to persist entered data).
$username = '';
$password = '';
$email = '';

// Handle form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Escape and retrieve input values.
    $username = esc_html($_POST['username'] ?? '');
    $password = esc_html($_POST['password'] ?? '');
    $email = esc_html($_POST['email'] ?? '');

    // Validation flags.
    $is_valid = true;

    // Validate username.
    if (empty($username) || !preg_match('/^[A-Za-z0-9_]+$/', $username)) {
        $error_messages['username'] = 'Username must only contain letters, numbers, and underscores.';
        $is_valid = false;
    }

    // Validate password.
    if (empty($password) || !preg_match('/^[A-Za-z0-9-_@#$%&*?><:]{6,32}$/', $password)) {
        $error_messages['password'] = 'Password must be 6-32 characters long and only contain A-Za-z0-9-_@#$%&*?><:.';
        $is_valid = false;
    }

    // Validate email.
    if (
        empty($email) ||
        !preg_match('/^[A-Za-z0-9-+.]+@[a-z0-9]+\.[a-z]{2,}$/i', $email)
    ) {
        $error_messages['email'] = 'Please provide a valid email in the format name@domain.com.';
        $is_valid = false;
    }

    // If all validations pass, attempt to create the admin user.
    if ($is_valid) {
        try {
            // Create the user as admin.
            $user_data = [
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'meta' => ['role' => 'admin'], // Assign the admin role explicitly.
            ];
            $user_id = create_user($username, $password, $email);
            update_user_meta($user_id, 'role', 'admin');

            // Update the config.php file.
            $config_path = ABSPATH . '/config.php';
            $config_content = file_get_contents($config_path);

            if ($config_content === false) {
                throw new Exception('Failed to read the config.php file.');
            }

            $updated_config = str_replace(
                "define('SITE_STATUS', 'PRE_SETUP');",
                "define('SITE_STATUS', 'ACTIVE');",
                $config_content
            );

            if (file_put_contents($config_path, $updated_config) === false) {
                throw new Exception('Failed to update the config.php file.');
            }

            sleep(3);

            // Redirect to /login on success.
            header('Location: /login');
            exit();
        } catch (Exception $e) {
            $error_messages['general'] = 'An error occurred: ' . esc_html($e->getMessage());
        }
    }
}

// End output buffering to allow redirection if no errors occur.
ob_end_flush();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }
        .setup-container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
            text-align: center;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9em;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        small {
            display: block;
            margin-top: 5px;
            font-size: 0.8em;
            color: #666;
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
        <h1>Site Setup</h1>
        <?php if ($error_messages['general']): ?>
            <div class="error"><?php echo htmlspecialchars($error_messages['general']); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                <?php if ($error_messages['username']): ?>
                    <div class="error"><?php echo htmlspecialchars($error_messages['username']); ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
                <small>Allowed: A-Za-z0-9-_@#$%&*?><:. Length: 6-32 characters.</small>
                <?php if ($error_messages['password']): ?>
                    <div class="error"><?php echo htmlspecialchars($error_messages['password']); ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <?php if ($error_messages['email']): ?>
                    <div class="error"><?php echo htmlspecialchars($error_messages['email']); ?></div>
                <?php endif; ?>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
