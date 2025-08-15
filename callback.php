<?php
// callback.php
require_once 'auth.php';

session_start();

$auth = new GoogleAuth($pdo);

if (isset($_GET['code'])) {
    if ($auth->handleCallback($_GET['code'])) {
        header('Location: upload.php');
    } else {
        header('Location: login.php?error=auth_failed');
    }
} else {
    header('Location: login.php?error=no_code');
}
exit;
?>