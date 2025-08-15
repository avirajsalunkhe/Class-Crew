<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");  // Allow API access from anywhere
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include "conn.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["action"])) {
    echo json_encode(["status" => "error", "message" => "Action is required"]);
    exit;
}

$action = $data["action"];

if ($action == "signup") {
    signup($conn, $data);
} elseif ($action == "login") {
    login($conn, $data);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid action"]);
}

// Signup Function
function signup($conn, $data) {
    if (!isset($data["name"], $data["email"], $data["password"], $data["phone"], $data["p_phone"])) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        return;
    }

    $name = $conn->real_escape_string($data["name"]);
    $email = $conn->real_escape_string($data["email"]);
    $password = password_hash($data["password"], PASSWORD_BCRYPT);  // Encrypt password
    $phone = $conn->real_escape_string($data["phone"]);
    $p_phone = $conn->real_escape_string($data["p_phone"]);

    // Check if email exists
    $check = $conn->query("SELECT id FROM students WHERE email = '$email'");
    if ($check->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists"]);
        return;
    }

    // Insert user into database
    $sql = "INSERT INTO students (name, email, password, phone, p_phone) VALUES ('$name', '$email', '$password', '$phone', '$p_phone')";
    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "User registered successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
}

// Login Function
function login($conn, $data) {
    if (!isset($data["email"], $data["password"])) {
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
        return;
    }

    $email = $conn->real_escape_string($data["email"]);
    $password = $data["password"];

    $result = $conn->query("SELECT id, name, email, phone, p_phone, password FROM students WHERE email = '$email'");
    if ($result->num_rows == 0) {
        echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
        return;
    }

    $user = $result->fetch_assoc();
    if (password_verify($password, $user["password"])) {
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "user" => [
                "id" => $user["id"],
                "name" => $user["name"],
                "email" => $user["email"],
                "phone" => $user["phone"],
                "p_phone" => $user["p_phone"]
            ]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    }
}

$conn->close();
?>
