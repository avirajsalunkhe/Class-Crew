<?php
include "conn.php"; // Database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['test_id'])) {
    $test_id = intval($_POST['test_id']);

    try {
        // Prepare delete query for test
        $stmt = $conn->prepare("DELETE FROM stu_test WHERE id = ?");
        $stmt->bind_param("i", $test_id);

        if ($stmt->execute()) {
            $_SESSION["batch"] = "Test deleted successfully!";
            $_SESSION["batchType"] = "success";

            $response = ["status" => "success", "message" => $_SESSION["batch"], "type" => $_SESSION["batchType"]];
        } else {
            throw new Exception("Failed to delete test: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $_SESSION["batch"] = "❌ Error: " . $e->getMessage();
        $_SESSION["batchType"] = "error";

        $response = ["status" => "error", "message" => $_SESSION["batch"], "type" => $_SESSION["batchType"]];
    }

    // Send JSON response
    echo json_encode($response);
    exit();
}
?>
