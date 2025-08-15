<?php
require_once 'config.php';    // DB config if it contains anything useful
require_once 'auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h2>Session Data</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Check if session_id exists in session
if (!isset($_SESSION['session_id'])) {
    echo "<p style='color:red;'>No session_id found in PHP session. User not logged in.</p>";
    exit;
}

// Connect to DB
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=matoshree_db;charset=utf8mb4',
        'root',
        ''
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "<p style='color:red;'>DB Connection error: " . $e->getMessage() . "</p>";
    exit;
}

$sessionId = $_SESSION['session_id'];

$stmt = $pdo->prepare("SELECT * FROM user_sessions WHERE session_id = ?");
$stmt->execute([$sessionId]);
$sessionData = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h2>Database Session Record</h2>";

if ($sessionData) {
    echo "<pre>";
    print_r($sessionData);
    echo "</pre>";
    
    $now = new DateTime();
    $expiresAt = new DateTime($sessionData['expires_at']);
    
    if ($expiresAt > $now) {
        echo "<p style='color:green;'>Session is valid and NOT expired.</p>";
    } else {
        echo "<p style='color:red;'>Session expired at: " . $sessionData['expires_at'] . "</p>";
    }
} else {
    echo "<p style='color:red;'>No session record found in DB for session_id: $sessionId</p>";
}
?>
