<?php
include "conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (
        empty($_POST['test_name']) || 
        empty($_POST['subject']) || 
        empty($_POST['total_marks']) || 
        empty($_POST['batch_id'])
    ) {
        $_SESSION["test"] = "All fields are required!";
        $_SESSION["testType"] = "error";
        header("Location: 8win.php");
        exit();
    }

    // Get form data
    $test_name = trim($_POST['test_name']);
    $subject = trim($_POST['subject']);
    $total_marks = intval($_POST['total_marks']);
    $batch_id = intval($_POST['batch_id']);
    $created_at = date("Y-m-d H:i:s"); // Current timestamp

    // Insert new test into stu_test table
    $insertQuery = "INSERT INTO stu_test (test_name, subject, total_marks, batch_id, created_at) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssiis", $test_name, $subject, $total_marks, $batch_id, $created_at);

    if ($stmt->execute()) {
        // Get the inserted test ID
        $test_id = $stmt->insert_id;

        // Update batches table with the new test_id
        $updateQuery = "UPDATE batches SET test_id = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ii", $test_id, $batch_id);

        if ($updateStmt->execute()) {
            $_SESSION["test"] = "Test generated successfully!";
            $_SESSION["testType"] = "success";
        } else {
            $_SESSION["test"] = "Test created, but batch update failed.";
            $_SESSION["testType"] = "error";
        }

        $updateStmt->close();
    } else {
        $_SESSION["test"] = "Failed to create test.";
        $_SESSION["testType"] = "error";
    }

    $stmt->close();
    header("Location: 8win.php");
    exit();
}
?>
