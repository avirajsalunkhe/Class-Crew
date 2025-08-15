<?php
include "conn.php"; // Database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $batch_name = isset($_POST['batch_name']) ? $_POST['batch_name'] : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date("Y-m-d H:i:s");
    $batch_day = isset($_POST['batch_day']) ? $_POST['batch_day'] : ''; // Batch Day
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : ''; // Start Time
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : ''; // End Time
   

    // Start a transaction for safer execution
    $conn->begin_transaction();

    try {
        // Insert new batch into batches table
        $stmt = $conn->prepare("INSERT INTO batches (name, current_students, start_date, batch_days, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissss", $batch_name, $student_count, $start_date, $batch_day, $start_time, $end_time);
        $student_count = 0;

        if (!$stmt->execute()) {
            throw new Exception("Batch insertion failed: " . $stmt->error);
        }

        $batch_id = $stmt->insert_id;
        $_SESSION["batch"] = "Batch Created successfully!";
        $_SESSION["batchType"] = "success";
        $stmt->close();

        // Updating student batch information
    } catch (Exception $e) {
        // Rollback if any error occurs
        $conn->rollback();
        $_SESSION["batch"] = "❌ Transaction failed: " . $e->getMessage();
        $_SESSION["batchType"] = "error";

        // Redirect back even on error
        header("Location: 4win.php");
        exit();
    }

    $conn->close();
}
?>
