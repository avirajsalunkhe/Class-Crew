<?php
include "conn.php"; // Database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $batch_name = isset($_POST['batch_name']) ? $_POST['batch_name'] : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date("Y-m-d H:i:s");
    $batch_day = isset($_POST['batch_day']) ? $_POST['batch_day'] : ''; // Batch Day
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : ''; // Start Time
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : ''; // End Time

    try {
        // Insert new batch into batches table
        $stmt = $conn->prepare("INSERT INTO batches (name, start_date, batch_days, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $batch_name, $start_date, $batch_day, $start_time, $end_time);

        if ($stmt->execute()) {
            $_SESSION["batch"] = "Batch Created successfully!";
            $_SESSION["batchType"] = "success";
        } else {
            throw new Exception("Batch insertion failed: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        // Redirect back
        header("Location: 4win.php");
        exit();
    } catch (Exception $e) {
        $_SESSION["batch"] = "❌ Error: " . $e->getMessage();
        $_SESSION["batchType"] = "error";

        // Redirect back even on error
        header("Location: 4win.php");
        exit();
    }
}
?>
