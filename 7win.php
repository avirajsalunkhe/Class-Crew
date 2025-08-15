<?php
session_start();
if(! $_SESSION['avi'])
{
     header ('location:admin-login.php');
}
error_reporting(0);

if (isset($_POST['generate_qr']) && empty($_SESSION['qr_text'])) {
    $_SESSION['qr_text'] = uniqid(); // Generate a unique string
}

// Remove QR Code
if (isset($_POST['remove_qr'])) {
    unset($_SESSION['qr_text']); // Remove stored QR text
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    exit;
}

// Fetch stored QR text
$qrText = $_SESSION['qr_text'] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - Matoshree Classes</title>
    <link rel="stylesheet" href="7winstyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php
include 'sidebar.php';

?>
<style>
    .profile-name {
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.profile-role {
    color: #666;
    font-size: 0.9rem;
}
#qrcode.qrcode {
    text-align: center;
    margin-bottom: 2rem;
    display: grid; 
    place-items: center;
}
.qr-actions {
    display: flex
;
    gap: 1rem;
    margin-bottom: 2rem;
    place-items: center;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: center;
}
</style>

        <!-- Main Content -->
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
                    <!-- <div class="profile">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/7-5gA74M7xJFAqt0EBd7AtHfquA2LTVj.png" alt="Profile">
                        <div class="profile-info">
                            <div class="profile-name">
                                Matoshree Classes <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="profile-role">Admin</div>
                            <a href="adminlogout.php" class="btn-primary">
                            <center>
                               Logout</center>
                            </a>
                        </div>
                    </div> -->
                </div>
            </header>
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
            <div class="content-wrapper">
                <!-- Left Section -->
                <section class="attendance-section">
                    <h1>Generate Attendance QR code</h1>
                    
                    <div  class="qrcode" id="qrcode"></div>
                    <form method="post">
                        <div class="qr-actions">
                            <button  class="action-btn" name="generate_qr">Generate QR</button>
                            <button class="action-btn" name="remove_qr">Delete QR</button>
                            <button class="action-btn">Share QR</button>
                        </div>
                    </form>
                    <!-- Date Selector -->
                    <div class="date-selector">
                        <div class="date-item">
                            <span class="date">19</span>
                            <span class="day">Sun</span>
                        </div>
                        <div class="date-item">
                            <span class="date">13</span>
                            <span class="day">Mon</span>
                        </div>
                        <div class="date-item">
                            <span class="date">14</span>
                            <span class="day">Tue</span>
                        </div>
                        <div class="date-item active">
                            <span class="date">15</span>
                            <span class="day">Wed</span>
                        </div>
                        <!-- Add more date items -->
                    </div>

                    <div class="attendance-list">
                        <h2>Wednesday, Nov 15</h2>
                        
                        <div class="student-card">
                            <div class="student-info">
                                <h3>Jaya</h3>
                                <div class="check-time">
                                    <i class="fas fa-circle"></i>
                                    <span>Check in Time</span>
                                    <span>06:07 AM</span>
                                </div>
                            </div>
                            <span class="status present">Present</span>
                        </div>

                        <div class="student-card">
                            <div class="student-info">
                                <h3>Diksha</h3>
                                <div class="check-time">
                                    <i class="fas fa-circle"></i>
                                    <span>Check in Time</span>
                                    <span>06:07 AM</span>
                                </div>
                            </div>
                            <span class="status absent">Absent</span>
                        </div>
                        <!-- Add more student cards -->
                    </div>
                </section>

                <!-- Right Section - Message -->
                <section class="message-section">
                    <h2>Message</h2>
                    <div class="message-form">
                        <div class="form-group">
                            <label>Student Name</label>
                            <div class="select-wrapper">
                                <select>
                                    <option>Adarsh</option>
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Student Batch</label>
                            <div class="select-wrapper">
                                <select>
                                    <option>JEE</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea placeholder="Type your message here..."></textarea>
                        </div>

                        <div class="message-actions">
                            <button class="send-btn">Send Message</button>
                            <button class="attach-btn">
                                <i class="fas fa-paperclip"></i>
                                <div class="upload-box" onclick="openFilePicker()">Click to Upload File</div>
                                  <input type="file" id="fileInput" style="display: none;">
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script>
    // Fetch stored QR text from PHP
    let qrText = "<?php echo $qrText; ?>";

    // Generate QR Code if it exists
    if (qrText) {
        let qrContainer = document.getElementById("qrcode");
        qrContainer.innerHTML = ""; // Clear old QR
        new QRCode(qrContainer, {
            text: qrText,
            width: 200,
            height: 200
        });
    }
</script>
<script>
                                  function openFilePicker() {
                                      document.getElementById("fileInput").click();
                                  }
                                  </script>
</body>
</html>