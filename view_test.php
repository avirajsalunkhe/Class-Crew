<?php
session_start();
if (!isset($_SESSION['avi'])) {
    header('location:admin-login.php');
    exit();
}

include "conn.php"; // Database Connection

// Check if test ID is passed
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid Test ID.";
    exit();
}

$test_id = intval($_GET['id']); // Get Test ID safely

// Fetch test details
$testQuery = "SELECT test_name, subject, total_marks, batch_id FROM stu_test WHERE id = ?";
$stmt = $conn->prepare($testQuery);
$stmt->bind_param("i", $test_id);
$stmt->execute();
$testResult = $stmt->get_result();
$test = $testResult->fetch_assoc();

if (!$test) {
    echo "Test not found.";
    exit();
}

$batch_id = $test['batch_id'];

// Fetch students in the batch
$studentsQuery = "SELECT s.id, s.name, IFNULL(m.marks_obtained, '') as marks_obtained 
                  FROM students s
                  LEFT JOIN marks m ON s.id = m.student_id AND m.test_id = ?
                  WHERE s.batch1 = ? OR s.batch2 = ? OR s.batch3 = ? OR s.batch4 = ? OR s.batch5 = ? ";

$stmt = $conn->prepare($studentsQuery);
$stmt->bind_param("iiiiii", $test_id, $batch_id, $batch_id, $batch_id, $batch_id,$batch_id);
$stmt->execute();
$studentsResult = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Test - Matoshree Classes</title>
    <link rel="stylesheet" href="9winstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    .btn-primary {
    background-color: #11137D;
    text-decoration: none;
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 0.5rem;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.test-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    padding: 1rem;
}

.current-test {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.current-test h3 {
    color: #11137D;
}

.current-test .btn-primary {
    display: inline-block;
    margin-top: 10px;
}

.upload-test {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.upload-test h1 {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
    color: #333;
}

.upload-test .upload-info {
    text-align: center;
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

.upload-test table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.upload-test table th,
.upload-test table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.upload-test table th {
    background-color: #11137D;
    color: white;
    font-weight: bold;
}

.upload-test table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.upload-test table tr:hover {
    background-color: #f1f1f1;
}

.upload-test input[type="number"] {
    width: 80px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
    font-size: 14px;
}

.upload-test .btn-primary {
    display: block;
    width: 100%;
    max-width: 200px;
    margin: 20px auto;
    padding: 10px;
    background: #11137D;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.upload-test .btn-primary:hover {
    background: #11137D;
}

.back-button { width: 80px; text-decoration: none; background: #11137D; color: white; padding: 10px; border-radius: 5px; }

.notification1 {
                    display: none;
                    position: fixed;
                    top: 10px;
                    left: 90%;
                    height: 50px;
                    margin-top: 120px;
                    margin-right: 100px;
                    transform: translateX(-50%);
                    padding: 15px;
                    width: 300px;
                    text-align: center;
                    color: white;
                    border-radius: 10px;
                    font-weight: bold;
                    z-index: 1000;
                }
                .success {
                    background-color: #4CAF50; /* Green */
                }
                .error {
                    background-color: #f44336; /* Red */
                }
</style>

<body>
<?php if (isset($_SESSION["batch"])): ?>
    <div class="notification1 <?php echo $_SESSION['batchType']; ?>" id="notification">
        <?php echo $_SESSION["batch"]; ?>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var notification = document.getElementById("notification");
            notification.style.display = "block"; // Show immediately

            setTimeout(function () {
                notification.style.opacity = "0"; // Fade out
                setTimeout(() => {
                    notification.style.display = "none";
                    notification.style.opacity = "1"; // Reset opacity for future notifications
                }, 500);
            }, 3000);
        });
    </script>
    <?php
    unset($_SESSION["batch"]);
    unset($_SESSION["batchType"]);
    ?>
<?php endif; ?>


    <div class="container">
        <?php include 'sidebar.php'; ?>
        <main class="main-content">
            <!-- Header -->
            <header>    
                <div class="search-bar">
                    <input type="text" placeholder="Search">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-right">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </header>
            <br><a href="9win.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>
            <section class="upload-test" style="position: relative;">
                <h1>Test: <?php echo htmlspecialchars($test['test_name']); ?></h1>
                <p class="upload-info">Subject: <?php echo htmlspecialchars($test['subject']); ?> | Total Marks: <?php echo $test['total_marks']; ?></p>

                <form action="update_test_marks.php" method="POST">
                    <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
                    <table>
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Marks Obtained</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($student = $studentsResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                                    <td>
                                        <input type="number" name="marks[<?php echo $student['id']; ?>]" 
                                               value="<?php echo $student['marks_obtained']; ?>" 
                                               min="0" max="<?php echo $test['total_marks']; ?>">
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <button class="btn-primary" type="submit">Update Marks</button>
                </form>
                
            </section>
        </main>
    </div>
</body>
</html>
