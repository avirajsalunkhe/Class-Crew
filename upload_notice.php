<?php
session_start();
include "conn.php"; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $message = trim($_POST["message"]);

    // Validate inputs
    if (empty($title) || empty($message)) {
        $_SESSION["message"] = "All fields are required!";
        $_SESSION["messageType"] = "error";
        header("Location: 2win.php");
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO notices (title, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $message);
    if ($stmt->execute()) {
        $_SESSION["message"] = "Notice uploaded successfully!";
        $_SESSION["messageType"] = "success";
    } else {
        $_SESSION["message"] = "Database error. Try again!";
        $_SESSION["messageType"] = "error";
    }
    $stmt->close();
    
    $conn->close();
    header("Location: 2win.php");
    exit();
}
?>
