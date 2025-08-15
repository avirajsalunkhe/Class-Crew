<?php
header('Content-Type: application/json');
require_once 'conn.php';

// Log for debugging
file_put_contents("debug.log", "=== Incoming Request ===\n", FILE_APPEND);
file_put_contents("debug.log", print_r($_POST, true), FILE_APPEND);

if (!isset($_POST['file_id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing file_id']);
    exit;
}

$fileId = (int) $_POST['file_id'];

// Fetch current status
$stmt = $conn->prepare("SELECT status FROM file_uploads WHERE id = ?");
$stmt->bind_param("i", $fileId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $currentStatus = $row['status'];
    $newStatus = ($currentStatus === 'active') ? 'deactivated' : 'active';

    $updateStmt = $conn->prepare("UPDATE file_uploads SET status = ? WHERE id = ?");
    $updateStmt->bind_param("si", $newStatus, $fileId);
    $updateStmt->execute();

    if ($updateStmt->error) {
        echo json_encode(['success' => false, 'error' => $updateStmt->error]);
    } else {
        echo json_encode(['success' => true, 'new_status' => $newStatus]);
    }

} else {
    echo json_encode(['success' => false, 'error' => 'File not found']);
}
