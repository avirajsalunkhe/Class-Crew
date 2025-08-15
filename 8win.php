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
    <title>Upload Test - Matoshree Classes</title>
    <link rel="stylesheet" href="8winstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <script>
        // Mobile menu toggle functionality
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        
        if(menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }
    </script>
    <div class="container">
        <!-- Sidebar -->
        <?php
include 'sidebar.php';

?>
<style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}body{background:#F8FDFF}.container{display:flex;min-height:100vh}.sidebar{width:250px;background:#fff;padding:2rem;border-right:1px solid #eee;position:fixed;height:100vh;z-index:1000}.logo h1{color:#11137D;font-size:1.5rem;margin-bottom:2rem}.sidebar nav ul{list-style:none}.sidebar nav ul li{padding:0.8rem 1rem;margin-bottom:0.5rem;color:#666;cursor:pointer;border-radius:0.5rem;display:flex;align-items:center;gap:0.8rem;transition:.3s}.sidebar nav ul li.active,.sidebar nav ul li:hover{background:#f5f5f5;color:#11137D}.main-content{flex:1;margin-left:250px;padding:2rem}header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem}.search-bar{position:relative;width:400px}.search-bar input{width:100%;padding:0.8rem 1rem;border:1px solid #eee;border-radius:2rem;outline:none}.search-bar i{position:absolute;right:1rem;top:50%;transform:translateY(-50%);color:#11137D}.header-right{display:flex;align-items:center;gap:1.5rem}.notification-btn{background:none;border:none;color:#11137D;cursor:pointer;font-size:1.2rem}.profile{display:flex;align-items:center;gap:1rem}.profile img{width:40px;height:40px;border-radius:50%}.profile-info{display:flex;flex-direction:column}.profile-name{font-weight:bold;display:flex;align-items:center;gap:0.5rem}.profile-role{color:#666;font-size:.9rem}.upload-test{max-width:1200px;margin:0 auto;padding:2rem}.upload-test h1{color:#11137D;font-size:2rem;margin-bottom:1rem}.upload-info{color:#666;margin-bottom:3rem}.test-form{display:flex;flex-direction:column;gap:2rem}.form-group input::placeholder{color:#999}.generate-btn{width:100%;max-width:400px;margin:0 auto;padding:1rem;background:#F8FDFF;border:none;border-radius:0.5rem;color:#11137D;font-weight:bold;font-size:1rem;cursor:pointer;transition:.3s}.generate-btn:hover{background:#e8f4ff}@media (max-width:1200px){.form-grid{grid-template-columns:1fr 1fr}}@media (max-width:768px){.sidebar{transform:translateX(-100%);transition:.3s}.sidebar.active{transform:translateX(0)}.main-content{margin-left:0}header{flex-direction:column;gap:1rem}.search-bar{width:100%}.header-right{width:100%;justify-content:space-between}.form-grid{grid-template-columns:1fr}.upload-test{padding:1rem}}@media (max-width:576px){.profile-info{display:none}.upload-test h1{font-size:1.5rem}.form-group input{padding:0.8rem}}

    .header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.back-button {
    background: none;
    border: none;
    color: #11137D;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
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
                </div>
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

.form-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    color: #11137D;
    font-weight: 500;
}

.form-group input,
.form-group select { 
    width: 100%; /* Ensure both have the same width */
    padding: 1rem;
    border: 1px solid #11137D;
    border-radius: 0.5rem;
    outline: none;
    font-size: 1rem;
    height: 3.25rem; /* Explicitly set the height to match */
}

.form-group select {
    background-color: white; 
    cursor: pointer;
    appearance: none; /* Removes browser default styles */
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 2rem; /* Ensure space for the dropdown icon */
    text-align: left;
}

.back-button { text-decoration: none; background: #11137D; color: white; padding: 10px; border-radius: 5px; }

/* Optional: Add a dropdown arrow for select */
.form-group select {
    background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%2311137D" d="M2 0L0 2h4z"/></svg>'); 
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 10px;
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

<?php if (isset($_SESSION["test"])): ?>
    <div class="notification1 <?php echo $_SESSION['testType']; ?>" id="notification">
        <?php echo $_SESSION["test"]; ?>
    </div>
    <?php
    unset($_SESSION["test"]);
    unset($_SESSION["testType"]);
    ?>
<?php endif; ?>
            </header>
            <div class="header-left">
            <a href="9win.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>
                </div>
            <!-- Upload Test Form -->
            <section class="upload-test">
                <h1>Upload The Test</h1>
                <p class="upload-info">Upload the pdf's , Documents , pptx , Zip file Notes</p>




                <form class="test-form" action="generate_test.php" method="POST">
                    <div class="form-grid">
                    <div class="form-group">
                    <label>Test Name:</label>
                    <input type="text" name="test_name" required>
                    </div>
                    
                    <div class="form-group">
                    <label>Topic:</label>
                    <input type="text" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                    <label>Total Marks:</label>
                    <input type="number" name="total_marks" required>
                    </div>
                    
                    <div class="form-group">
                    <label>Select Batch:</label>
                    <select name="batch_id" required>
                        <?php
                        include "conn.php";
                        $result = $conn->query("SELECT id, name FROM batches");
                        while ($batch = $result->fetch_assoc()) {
                            echo "<option value='{$batch['id']}'>{$batch['name']}</option>";
                        }
                        ?>
                    </select>
                    </div>
                
                    <button class="btn-primary" type="submit">Generate Test</button>
                </form>
            </section>
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