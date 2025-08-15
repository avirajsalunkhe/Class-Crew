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
    // Check if student exists and fetch batch IDs
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

    // Fetch test details based on batch assignments
    $placeholders = implode(',', array_fill(0, count($batch_ids), '?')); // Create ?,?,? for IN clause
    $query = "SELECT t.test_name, t.subject, t.created_at, IFNULL(m.marks_obtained, '') as marks_obtained 
              FROM stu_test t 
              LEFT JOIN marks m ON t.id = m.test_id AND m.student_id = ?
              WHERE t.batch_id IN ($placeholders)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($batch_ids) + 1), $student_id, ...$batch_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    $tests = [];
    while ($row = $result->fetch_assoc()) {
        $tests[] = [
            "test_name" => $row["test_name"],
            "subject" => $row["subject"],
            "created_at" => $row["created_at"],
            "marks_obtained" => $row["marks_obtained"]
        ];
    }

    echo json_encode(["status" => "success", "student_id" => $student_id, "tests" => $tests]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}

$conn->close();
?>
