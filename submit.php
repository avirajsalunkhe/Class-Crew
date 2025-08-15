<?php
include 'config/firebase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['title'];
    $message = $_POST['message'];

    $usersRef = $database->collection('Notice')->add([
        'Title' => $name,
        'Description' => $message
    ]);

    header("Location: 2win.php");
    exit();
}
?>