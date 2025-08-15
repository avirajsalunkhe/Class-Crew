<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["batch_id"])) {
    $batch_id = intval($_POST["batch_id"]); // Sanitize input

    $sql = "DELETE FROM batches WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $batch_id);

    if ($stmt->execute()) {
        $_SESSION["batch"] = "Batch deleted successfully!";
        $_SESSION["batchType"] = "success";
    } else {
        $_SESSION["batch"] = "Failed to delete batch.";
        $_SESSION["batchType"] = "error";
    }

    $stmt->close();
    $conn->close();

    echo json_encode(["status" => "success"]);
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
