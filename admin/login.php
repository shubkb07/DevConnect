<?php
/**
 * login.php
 *
 * Handles user login by validating credentials and utilizing the signon() function
 * for authentication. Redirects users upon successful login and displays error messages
 * for failed attempts.
 */

// Prevent direct access if ABSPATH is not defined.
if (!defined('ABSPATH')) {
    die('Direct access not allowed.');
}

// Initialize variables.
$error_message = '';
$redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : '';

if (preg_match('/^(https?:\/\/|\/)/', $redirect_to)) {
    // If it's a relative URL, prepend the scheme and host.
    if (strpos($redirect_to, 'http') === 0) {
        $redirect_url = $redirect_to;
    } else {
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $redirect_url = $scheme . '://' . $_SERVER['HTTP_HOST'] . $redirect_to;
    }
} else {
    // Default redirect if the URL is invalid.
    $redirect_url = '/admin';
}

// Check if the user is already logged in.
if (is_user_logged_in()) {
    // Redirect the logged-in user.
    header("Location: $redirect_url");
    exit();
}

// Handle login form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs.
    $identifier = isset($_POST['identifier']) ? trim($_POST['identifier']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $remember = isset($_POST['remember']) ? true : false;

    // Validate inputs.
    if (empty($identifier) || empty($password)) {
        $error_message = 'Please provide both username/email and password.';
    } else {
        try {
            /**
             * Attempt to log in the user using the signon() function.
             *
             * Parameters:
             * - $identifier: Username or Email.
             * - $password: User's password.
             * - $remember: Boolean indicating "Remember Me" preference.
             *
             * The signon() function is expected to handle:
             * - User authentication.
             * - Setting authentication cookies.
             * - Updating user session data.
             */
            signon($identifier, $password, $remember);

            // Determine the redirect URL after successful login.
            if (preg_match('/^(https?:\/\/|\/)/', $redirect_to)) {
                if (strpos($redirect_to, 'http') === 0) {
                    $redirect_url = $redirect_to;
                } else {
                    $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                    $redirect_url = $scheme . '://' . $_SERVER['HTTP_HOST'] . $redirect_to;
                }
            } else {
                $redirect_url = "/admin";
            }

            // Redirect the user.
            header("Location: $redirect_url");
            exit();
        } catch (Exception $e) {
            /**
             * If signon() throws an exception, capture it and display a generic error message.
             * Avoid displaying detailed error information to prevent security vulnerabilities.
             */
            $error_message = 'Invalid username/email or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to the login stylesheet -->
    <link rel="stylesheet" href="./../admin/assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <form method="POST" action="">
            <h1>Login</h1>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="identifier">Username or Email</label>
                <input
                    type="text"
                    id="identifier"
                    name="identifier"
                    value="<?php echo isset($identifier) ? htmlspecialchars($identifier, ENT_QUOTES, 'UTF-8') : ''; ?>"
                    required
                >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>
            <div class="form-group checkbox-group">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    <?php echo isset($_POST['remember']) ? 'checked' : ''; ?>
                >
                <label for="remember">Remember Me</label>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    <!-- Link to the login JavaScript file -->
    <script src="./../admin/assets/js/login.js"></script>
</body>
</html>
