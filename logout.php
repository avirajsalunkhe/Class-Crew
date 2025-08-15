<?php
// logout.php
require_once 'auth.php';

session_start();

$auth = new GoogleAuth($pdo);
$auth->logout();

header('Location: login.php');
exit;
?>