
<?php
// config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'matoshree_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Google OAuth Configuration
define('GOOGLE_CLIENT_ID', '706702353134-244dq7k975lb7avp0bl7nh6fpv7fl1ms.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'http://localhost/matoshree/callback.php');

// Google Service Account
define('GOOGLE_SERVICE_ACCOUNT_FILE', 'C:\xampp\htdocs\matoshree\vendor\fleet-aleph-463811-t6-1e6c20dbae16.json');
define('GOOGLE_DRIVE_FOLDER_ID', '1NKxRGWjAAGa_fBzeElqFrumMI-sxcrVO'); // Optional: specific folder

// Security
define('SESSION_SECRET', 'your-random-secret-key');

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>