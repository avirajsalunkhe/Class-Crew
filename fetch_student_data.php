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
    // Fetch student details
    $query = "SELECT id, name, email, phone, p_phone, password, created_at, updated_at, batch1, batch2, batch3, batch4, batch5, roll_number FROM students WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "No student found with this email"]);
        exit;
    }

    $student = $result->fetch_assoc();

    echo json_encode(["status" => "success", "student" => $student]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}

$conn->close();
?>
