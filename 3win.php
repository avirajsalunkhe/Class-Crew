<?php
session_start();
if(! $_SESSION['avi'])
{
     header ('location:admin-login.php');
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="3winstyle.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-section">
            <h1>Matoshree Classes</h1>
            <div class="search-box">
                <input type="search" placeholder="Adarsh">
                <span class="search-icon">🔍</span>
            </div>
        </div>
        <div class="profile-section">
            <span class="date">Thursday, Nov 28, 2024</span>
            <div class="profile">
                <div class="avatar">AD</div>
                <div class="profile-info">
                    <p class="name">Matoshree Classes</p>
                    <p class="role">Admin</p>
                    <a href="adminlogout.php" class="btn-primary">
                            <center>
                               Logout</center>
                            </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Sidebar -->
        <?php
include 'sidebar.php';

?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Student Profile -->
            <div class="student-profile">
                <div class="profile-info">
                    <h2>Student Name</h2>
                    <h3>Adarsh Deshmukh</h3>
                </div>
                <div class="profile-avatar">👤</div>
            </div>

            <!-- Test Results -->
            <h2 class="section-title">Test Results</h2>
            <div class="test-results">
                <div class="result-card pink">
                    <h3>Physics</h3>
                    <p class="score">45/50</p>
                    <p class="status">present</p>
                </div>
                <div class="result-card green">
                    <h3>Chemistry</h3>
                    <p class="score">00/50</p>
                    <p class="status">Absent</p>
                </div>
                <div class="result-card pink">
                    <h3>Physics</h3>
                    <p class="score">20/50</p>
                    <p class="status">present</p>
                </div>
                <div class="result-card pink">
                    <h3>Maths</h3>
                    <p class="score">48/50</p>
                    <p class="status">present</p>
                </div>
            </div>

            <!-- Attendance Section -->
            <div class="attendance-section">
                <div class="section-header">
                    <h2>Attendance</h2>
                    <button class="check-btn">Check previous month Attendance ▼</button>
                </div>
                <div class="chart-container">
                    <div class="placeholder-chart">Attendance Chart</div>
                </div>
            </div>

            <!-- Quiz Section -->
            <div class="quiz-section">
                <h2>Quiz</h2>
                <div class="chart-container">
                    <div class="placeholder-chart">Quiz Performance Chart</div>
                </div>
            </div>
        </main>
    </div>
</body>
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
</style>
</html>