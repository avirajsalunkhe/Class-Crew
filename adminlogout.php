<?php
session_start();
unset($_SESSION['avi']);
session_destroy();
header ('location:admin-login.php');
?>
