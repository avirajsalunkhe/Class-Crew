<?php
session_start();
include "conn.php"; // Database Connection

// Check if test ID is provided
if (!isset($_POST['test_id']) || empty($_POST['test_id'])) {
    $_SESSION['batch'] = "Invalid Test ID.";
    $_SESSION['batchType'] = "error";
    header("Location: view_test.php?id=" . ($_POST['test_id'] ?? ''));
    exit();
}

$test_id = intval($_POST['test_id']); // Get Test ID safely

// Process the marks update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['marks'])) {
    foreach ($_POST['marks'] as $student_id => $marks) {
        $marks = intval($marks);

        $updateQuery = "INSERT INTO marks (test_id, student_id, marks_obtained) 
                        VALUES (?, ?, ?) 
                        ON DUPLICATE KEY UPDATE marks_obtained = VALUES(marks_obtained)";
        
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iii", $test_id, $student_id, $marks);
        $stmt->execute();
    }

    $_SESSION['batch'] = "Marks updated successfully!";
    $_SESSION['batchType'] = "success";
} else {
    $_SESSION['batch'] = "No marks data provided!";
    $_SESSION['batchType'] = "error";
}

// Redirect back to the test page
header("Location: view_test.php?id=" . $test_id);
exit();
?>
