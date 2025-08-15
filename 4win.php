<?php
session_start();
if(! $_SESSION['avi'])
{
     header ('location:admin-login.php');
}
error_reporting(0);

session_start();
if (!isset($_SESSION['avi'])) {
    header('location:admin-login.php');
    exit;
}

// Ensure selected students array is always set
if (!isset($_SESSION['selected_students'])) {
    $_SESSION['selected_students'] = [];
}

// If new students are selected, update session
if (isset($_GET['selected_students']) && !empty($_GET['selected_students'])) {
    $_SESSION['selected_students'] = explode(',', $_GET['selected_students']);
}
$selected_students = $_SESSION['selected_students'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Batch - Matoshree Classes</title>
    <!-- <link rel="stylesheet" href="4winstyle.css"> -->
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
            </header>
            <div class="header-left">
            <a href="5win.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<style>
    .btn-primary,.btn-prim{background:#11137D;color:#fff;border:none;padding:.8rem 2rem;border-radius:.5rem;cursor:pointer;font-weight:700;transition:.3s}.btn-prim{margin-top:20px}.back-button{width:60px;border:none;font-size:16px;text-decoration:none}.btn-secondary{background:#11137D;color:#fff;border:1px solid #11137D;padding:.8rem 1.5rem;border-radius:.5rem;cursor:pointer;font-weight:700;display:flex;align-items:center;gap:.5rem;transition:.3s;text-decoration:none;flex-direction:column-reverse;flex-wrap:wrap;align-content:space-around;justify-content:space-between}.content-wrapper{display:grid;gap:2rem}*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}body{background:#F8FDFF}.container{display:flex;min-height:100vh}.sidebar{width:250px;background:#fff;padding:2rem;border-right:1px solid #eee;position:fixed;height:100vh;z-index:1000}.logo h1{color:#11137D;font-size:1.5rem;margin-bottom:2rem}.sidebar nav ul{list-style:none}.sidebar nav ul li{padding:.8rem 1rem;margin-bottom:.5rem;color:#666;cursor:pointer;border-radius:.5rem;display:flex;align-items:center;gap:.8rem}.sidebar nav ul li.active{background:#f5f5f5;color:#11137D}.main-content{flex:1;margin-left:250px;padding:2rem}header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem}.search-bar{position:relative;width:400px}.search-bar input{width:100%;padding:.8rem 1rem;border:1px solid #eee;border-radius:2rem;outline:none}.search-bar i{position:absolute;right:1rem;top:50%;transform:translateY(-50%);color:#11137D}.header-right{display:flex;align-items:center;gap:1.5rem}.notification-btn{background:none;border:none;color:#11137D;cursor:pointer;font-size:1.2rem}.profile{display:flex;align-items:center;gap:1rem}.profile img{width:40px;height:40px;border-radius:50%}.profile-name{font-weight:700;display:flex;align-items:center;gap:.5rem}.profile-role{color:#666;font-size:.9rem}.create-batch{background:#fff;padding:2rem;border-radius:1rem;box-shadow:0 2px 4px rgba(0,0,0,.05)}.create-batch h1{color:#11137D;font-size:1.8rem;margin-bottom:2rem}.form-group{margin-bottom:1.5rem}.form-group label{display:block;margin-bottom:.5rem;font-weight:500}.form-group input{width:100%;padding:.8rem;border:1px solid #ddd;border-radius:.5rem;outline:none}.date-input,.add-students{position:relative}.date-input i,.add-students i{position:absolute;right:1rem;top:50%;transform:translateY(-50%);color:#11137D}.previous-batches h2{color:#11137D;font-size:1.8rem;margin-bottom:2rem}.batch-card{background:#fff;padding:1.5rem;border-radius:.5rem;margin-bottom:1rem;display:flex;justify-content:space-between;align-items:center}.batch-info h3{margin-bottom:.5rem}.batch-details{color:#666;font-size:.9rem}.badge{padding:.5rem 1rem;border-radius:2rem;font-size:.8rem}.badge.everyday,.badge.weekend{background:#E8FFF3;color:#00B341}@media (max-width:768px){.sidebar{transform:translateX(-100%);transition:.3s}.sidebar.active{transform:translateX(0)}.main-content{margin-left:0}header{flex-direction:column;gap:1rem}.search-bar{width:100%}.header-right{width:100%;justify-content:space-between}}@media (max-width:576px){.profile-info{display:none}.create-batch,.previous-batches{padding:1rem}.batch-card{flex-direction:column;align-items:flex-start;gap:1rem}.badge{align-self:flex-start}}.notification1{display:none;position:fixed;top:10px;left:90%;height:50px;margin-top:120px;margin-right:100px;transform:translateX(-50%);padding:15px;width:300px;text-align:center;color:#fff;border-radius:10px;font-weight:700;z-index:1000}.success{background:#4CAF50}.error{background:#f44336}.day-container{display:flex;gap:10px;flex-wrap:wrap}.day-option{padding:8px 15px;border:1px solid #000;border-radius:5px;cursor:pointer;user-select:none;background:#fff}.day-option.selected{background:#11137D;color:#fff;border-color:#000}
    .back-button {
            text-decoration: none;
            background: #11137D;
            color: white;
            width: 90px;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 15px;
        }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dayOptions = document.querySelectorAll(".day-option");
        const batchDayInput = document.getElementById("batch_day");

        let selectedDays = [];

        dayOptions.forEach(day => {
            day.addEventListener("click", function () {
                const value = this.getAttribute("data-value");

                if (selectedDays.includes(value)) {
                    // Remove if already selected
                    selectedDays = selectedDays.filter(day => day !== value);
                    this.classList.remove("selected");
                } else {
                    // Add to selection
                    selectedDays.push(value);
                    this.classList.add("selected");
                }

                // Store selected days in hidden input (comma-separated)
                batchDayInput.value = selectedDays.join(", ");
            });
        });
    });
</script>



<!-- notification section  -->
<?php session_start(); ?>
    
    <?php if (isset($_SESSION["batch"])): ?>
        <div class="notification1 <?php echo $_SESSION['batchType']; ?>" id="notification">
            <?php echo $_SESSION["batch"]; ?>
        </div>
        <?php
        unset($_SESSION["batch"]);
        unset($_SESSION["batchType"]);
        ?>
    <?php endif; ?>
    
            <div class="content-wrapper">
                <!-- Create Batch Form -->
                <section class="create-batch">
                    <h1>Create New Batch</h1>    
                    <form action="create_batch.php" method="POST" id="batchForm">
                           <div class="form-group">
                               <label>Batch Name</label>
                               <input type="text" name="batch_name" required placeholder="Enter Batch Name">
                           </div>
                       
                           <div class="form-group">
                               <label>Batch Start Date</label>
                               <input type="date" required name="start_date" id="datepicker">
                           </div>
                       
                           <!-- Day Selection -->
                           <div class="form-group">
                               <label>Batch Days</label>
                               <div class="day-container">
                                   <div class="day-option" data-value="Monday">Monday</div>
                                   <div class="day-option" data-value="Tuesday">Tuesday</div>
                                   <div class="day-option" data-value="Wednesday">Wednesday</div>
                                   <div class="day-option" data-value="Thursday">Thursday</div>
                                   <div class="day-option" data-value="Friday">Friday</div>
                                   <div class="day-option" data-value="Saturday">Saturday</div>
                                   <div class="day-option" data-value="Sunday">Sunday</div>
                               </div>
                               <input type="hidden" name="batch_day" id="batch_day">
                           </div>
                       
                           <!-- Time Selection -->
                           <div class="form-group">
                               <label>Batch Time</label>
                               <div style="display: flex; gap: 10px;">
                                   <input type="time" name="start_time" required>
                                   <span>to</span>
                                   <input type="time" name="end_time" required>
                               </div>
                           </div>
                                <button type="submit" class="btn-secondary">Create</button>
                               </form>
                </section>
            </div>
        </main>
    </div>
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

</body>
</html>