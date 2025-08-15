<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "conn.php";

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT id, title, message, uploaded_at FROM notices ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

$notices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
    echo json_encode(["status" => "success", "notices" => $notices]);
} else {
    echo json_encode(["status" => "error", "message" => "No notices found"]);
}

$conn->close();
?>