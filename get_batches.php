<?php
header("Content-Type: application/json"); // Set response type to JSON
include "conn.php"; // Include database connection

// Check if 'email' is provided in the GET request
if (!isset($_GET['email']) || empty($_GET['email'])) {
    echo json_encode(["status" => "error", "message" => "Student email is required"]);
    exit;
}

$email = trim($_GET['email']); // Sanitize email input

try {
    // Check if student exists
    $query = "SELECT id, batch1, batch2, batch3, batch4, batch5 FROM students WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "No student found with this email"]);
        exit;
    }

    $student = $result->fetch_assoc();
    $student_id = $student["id"];
    
    // Extract batch IDs
    $batch_ids = array_filter([$student['batch1'], $student['batch2'], $student['batch3'], $student['batch4'], $student['batch5']]);

    if (empty($batch_ids)) {
        echo json_encode(["status" => "error", "message" => "No batches assigned"]);
        exit;
    }

    // Fetch batch details from batches table
    $placeholders = implode(',', array_fill(0, count($batch_ids), '?')); // Create ?,?,? for IN clause
    $query = "SELECT name, batch_days, start_time, end_time FROM batches WHERE id IN ($placeholders)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($batch_ids)), ...$batch_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    $batches = [];
    while ($row = $result->fetch_assoc()) {
        $batches[] = [
            "batch_name" => $row["name"],
            "batch_days" => $row["batch_days"],
            "start_time" => date("h:i A", strtotime($row["start_time"])),
            "end_time" => date("h:i A", strtotime($row["end_time"]))
        ];
    }

    echo json_encode(["status" => "success", "student_id" => $student_id, "batches" => $batches]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}

$conn->close();
?>
