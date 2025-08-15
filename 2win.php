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
    <title>Create Notice - Matoshree Classes</title>
    <link rel="stylesheet" href="2winstyle.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
</head>
<body>
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
    
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
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
.notice-card {
    background: white;
    border-radius: 1rem;
    padding: 0rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}
textarea {
    width: 100%;
    min-height: 200px;
    /* padding: 1rem; */
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 0.5rem;
    outline: none;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 0.5rem;
    outline: none;
}



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
    <div class="container">
        <!-- Sidebar -->
        <?php
        include 'sidebar.php';
        
        ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header>
                <div class="header-left">
                    <button class="back-button">
                    <a href="1stwin.php" class="create-notice">
                        <i class="fas fa-arrow-left"></i> Back
                    </button></a>
                    <button id="menu-toggle" class="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
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


            <?php session_start(); ?>
    
    <?php if (isset($_SESSION["message"])): ?>
        <div class="notification1 <?php echo $_SESSION['messageType']; ?>" id="notification">
            <?php echo $_SESSION["message"]; ?>
        </div>
        <?php
        unset($_SESSION["message"]);
        unset($_SESSION["messageType"]);
        ?>
    <?php endif; ?>


            <!-- Create Notice Section -->
            <form action="upload_notice.php" method="POST" class="create-notice" enctype="multipart/form-data">
                <h1>Create Notice</h1>
                        <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" placeholder="Enter Title">
                        </div>
                        <div class="notice-card">
                        <textarea type="text"name="message" placeholder="Type your message here..."></textarea>
                        <div class="notice-actions">
                        <button type="submit" class="btn-primary">Send</button>
                        <button class="btn-secondary">
                            <i class="fas fa-paperclip">
                            <input type="file" id="fileUpload" name="noticeFile">
                            </i>
                        </button>
                        <button class="btn-secondary">
                            <i class="fas fa-comment-alt"></i> Send SMS
                        </button>
                        </div>
                </div>
            </form>
        </main>
    </div>
</body>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            var notification = document.getElementById("notification");
            if (notification) {
                notification.style.display = "block";
                setTimeout(function () {
                    notification.style.display = "none";
                }, 3000);
            }
        });
    </script>
</html> 