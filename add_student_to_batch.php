<?php
include "conn.php"; // Database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure batch_id is provided
    if (!isset($_POST['batch_id']) || empty($_POST['batch_id'])) {
        $_SESSION["batch"] = "Batch ID is missing.";
        $_SESSION["batchType"] = "error";
        header("Location: 5win.php");
        exit();
    }

    // Get batch ID and student selections
    $batch_id = intval($_POST['batch_id']); // Ensure batch_id is an integer
    $students = isset($_POST['selected_students']) ? $_POST['selected_students'] : [];

    // If no students are selected, set an error notification and exit
    if (empty($students)) {
        $_SESSION["batch"] = "No students selected.";
        $_SESSION["batchType"] = "error";
        header("Location: 5win.php");
        exit();
    }

    $studentsAdded = 0; // Counter for tracking added students

    // Unselect all students from this batch first (reset their batch slots)
    $resetQuery = "UPDATE students SET batch1 = IF(batch1 = ?, 0, batch1),
                                        batch2 = IF(batch2 = ?, 0, batch2),
                                        batch3 = IF(batch3 = ?, 0, batch3),
                                        batch4 = IF(batch4 = ?, 0, batch4),
                                        batch5 = IF(batch5 = ?, 0, batch5)";
    $stmt = $conn->prepare($resetQuery);
    $stmt->bind_param("iiiii", $batch_id, $batch_id, $batch_id, $batch_id, $batch_id);
    $stmt->execute();
    $stmt->close();

    foreach ($students as $student_id) {
        $student_id = intval($student_id); // Ensure it's an integer

        // Fetch the student's batch slots
        $query = "SELECT batch1, batch2, batch3, batch4, batch5 FROM students WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Find the first empty batch slot
            for ($i = 1; $i <= 5; $i++) {
                if (empty($row["batch$i"])) {  
                    // Correctly update the student's batch slot
                    $updateQuery = "UPDATE students SET batch$i = ? WHERE id = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param("ii", $batch_id, $student_id);
                    $updateStmt->execute();
                    $updateStmt->close();
                    $studentsAdded++; // Increment success counter
                    break;
                }
            }
        } else {
            $_SESSION["batch"] = "No student found with ID: $student_id";
            $_SESSION["batchType"] = "error";
            header("Location: 5win.php");
            exit();
        }

        $stmt->close();
    }

    // If students were added successfully
    if ($studentsAdded > 0) {
        $_SESSION["batch"] = "Added successfully!";
        $_SESSION["batchType"] = "success";
    } else {
        $_SESSION["batch"] = "No students could be added.";
        $_SESSION["batchType"] = "error";
    }

    // Redirect after processing
    header("Location: 5win.php");
    exit();
}
