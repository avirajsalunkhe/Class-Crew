<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['avi'])) {
    header('location:admin-login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('Batch ID is missing.'); window.location.href='5win.php';</script>";
    exit;
}

$batch_id = $_GET['id'];

// Fetch batch details
$batch_query = "SELECT * FROM batches WHERE id = '$batch_id'";
$batch_result = mysqli_query($conn, $batch_query);
$batch = mysqli_fetch_assoc($batch_result);

if (!$batch) {
    echo "<script>alert('Batch not found.'); window.location.href='5win.php';</script>";
    exit;
}

// Fetch students assigned to the batch
$student_query = "SELECT * FROM students WHERE batch1 = '$batch_id' OR batch2 = '$batch_id' OR batch3 = '$batch_id' OR batch4 = '$batch_id' OR batch5 = '$batch_id'";
$student_result = mysqli_query($conn, $student_query);
$assigned_students = [];
while ($student = mysqli_fetch_assoc($student_result)) {
    $assigned_students[] = $student;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #11137D; color: white; }
        .back-button { text-decoration: none; background: #11137D; color: white; padding: 10px; border-radius: 5px; }
        .checked-box { accent-color: #11137D; }
        .sidebar {
    width: 250px;
    background-color: white;
    padding: 2rem;
    border-right: 1px solid #eee;
    position: fixed;
    height: 100vh;
    z-index: 1000;
}

.logo h1 {
    color: #11137D;
    font-size: 1.5rem;
    margin-bottom: 2rem;
}

.sidebar nav ul {
    list-style: none;
}

.sidebar nav ul li {
    padding: 0.8rem 1rem;
    margin-bottom: 0.5rem;
    color: #666;
    cursor: pointer;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.sidebar nav ul li.active {
    background-color: #f5f5f5;
    color: #11137D;
}

/* Main Content Styles */
.main-content {
    flex: 1;
    margin-left: 250px;
    padding: 2rem;
    position: relative;
}

/* Header Styles */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.search-bar {
    position: relative;
    width: 400px;
}

.search-bar input {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 1px solid #eee;
    border-radius: 2rem;
    outline: none;
}

.search-bar i {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #11137D;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.notification-btn {
    background: none;
    border: none;
    color: #11137D;
    cursor: pointer;
    font-size: 1.2rem;
}
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
/* Add Batch Button */
.add {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    background: #11137D;
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.2s;
    /* text-decoration: none; */
} 
    </style>
</head>
<body>
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
        <br><a href="5win.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a><br><br><br>
        <h1>Batch Details</h1><br>
        <h2>Batch Name: <?php echo $batch['name']; ?></h2>
        <p><strong>Batch ID:</strong> <?php echo $batch['id']; ?></p>
        <p><strong>Days:</strong> <?php echo $batch['batch_days']; ?></p>
        <p><strong>Time:</strong> <?php echo $batch['start_time']; ?> to <?php echo $batch['end_time']; ?></p>
        <p><strong>Start Date:</strong> <?php echo $batch['start_date']; ?></p><br>
        <h3>Assigned Students</h3>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Assigned</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($assigned_students) > 0): ?>
                    <?php foreach ($assigned_students as $student): ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td><?php echo $student['phone']; ?></td>
                            <td><input type="checkbox" class="checked-box" checked disabled></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5"><center>No students assigned.</center></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><br>
        <a href="add-students.php?id=<?php echo $batch_id; ?>" class="btn-primary">Add More Students</a>
    </div>
    <!-- Add More Students Button -->
</body>
</html>