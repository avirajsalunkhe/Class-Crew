<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['selected_students'])) {
    $_SESSION['selected_students'] = $data['selected_students'];
}
?>
