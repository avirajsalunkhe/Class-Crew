<?php
require_once 'session_helper.php'; // safely start session
require_once 'auth.php';

$auth = new GoogleAuth($pdo);






require_once 'session_helper.php';






if ($auth->isAuthenticated()) {
    header('Location: upload.php');
    exit;
}

$authUrl = $auth->getAuthUrl();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - File Upload System</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 100px auto; padding: 20px; text-align: center; }
        .login-button { display: inline-block; background: #4285f4; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; }
        .login-button:hover { background: #3367d6; }
    </style>
</head>
<body>
    <h1>File Upload System</h1>
    <p>Please sign in with your Google account to upload files.</p>
    <a href="<?php echo $authUrl; ?>" class="login-button">Sign in with Google</a>
</body>
</html>
