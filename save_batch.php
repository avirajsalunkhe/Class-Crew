<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batch_name = $_POST['batch_name'];
    $start_date = $_POST['start_date'];
    $student_ids = isset($_POST['students']) ? $_POST['students'] : [];

    // Insert batch
    $stmt = $conn->prepare("INSERT INTO batches (batch_name, start_date) VALUES (?, ?)");
    $stmt->bind_param("ss", $batch_name, $start_date);
    $stmt->execute();
    $batch_id = $stmt->insert_id;
    $stmt->close();

    // Insert selected students into batch_students table
    foreach ($student_ids as $student_id) {
        $stmt = $conn->prepare("INSERT INTO batch_students (batch_id, student_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $batch_id, $student_id);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(["success" => true, "message" => "Batch created successfully!"]);
}
?>
