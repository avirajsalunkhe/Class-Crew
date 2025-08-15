<?php
session_start();
if (!isset($_SESSION['avi'])) {
    header('location:admin-login.php');
    exit();
}

include "conn.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function formatBatchDays($batch_days) {
    $days = array_map('trim', explode(',', $batch_days));
    return implode('-', array_map(fn($day) => ucfirst(substr($day, 0, 3)), $days));
}

$sql = "SELECT id, name, batch_days, start_time, end_time, start_date FROM batches ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch List - Matoshree Classes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #F8FDFF; margin: 0; }
        .container { padding: 20px; }
        .batch-card { background: white; padding: 15px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ddd; cursor: pointer; }
        .batch-card h3 { margin: 0; color: #11137D; }
        .batch-details { font-size: 14px; color: #666; margin-top: 5px; }
        .badge { background: #E8FFF3; color: #00B341; padding: 5px 10px; border-radius: 12px; font-size: 12px; display: inline-block; }
        .add { position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; background: #11137D; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
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


        body { font-family: Arial, sans-serif; background-color: #F8FDFF; margin: 0; }
        .container { padding: 20px; }
        .batch-card { background: white; padding: 15px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ddd; cursor: pointer; position: relative; }
        .batch-card h3 { margin: 0; color: #11137D; }
        .batch-details { font-size: 14px; color: #666; margin-top: 5px; }
        .badge { background: #E8FFF3; color: #00B341; padding: 5px 10px; border-radius: 12px; font-size: 12px; display: inline-block; }
        .add { position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; background: #11137D; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        
        /* Delete Icon */
        .delete-icon {
            color: red;
            font-size: 18px;
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }
        .delete-icon:hover {
            color: darkred;
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
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php
include 'sidebar.php';

?>
<?php if (isset($_SESSION["batch"])): ?>
    <div class="notification1 <?php echo $_SESSION['batchType']; ?>" id="notification">
        <?php echo $_SESSION["batch"]; ?>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var notification = document.getElementById("notification");
            if (notification.innerHTML.trim() !== "") {
                notification.style.display = "block"; // Show notification
                setTimeout(function () {
                    notification.style.opacity = "0"; // Fade out
                    setTimeout(() => {
                        notification.style.display = "none";
                        notification.style.opacity = "1"; // Reset opacity for next time
                    }, 500);
                }, 3000);
            }
        });
    </script>
    <?php
    unset($_SESSION["batch"]);
    unset($_SESSION["batchType"]);
    ?>
<?php endif; ?>



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
            <h2>Previous Batches</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="batch-card" onclick="location.href='4.1win.php?id=<?php echo $row['id']; ?>'">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <div class="batch-details">
                            Start Date: <?php echo date('d/m/Y', strtotime($row['start_date'])); ?> | 
                            <?php echo date('h:i A', strtotime($row['start_time'])); ?> - <?php echo date('h:i A', strtotime($row['end_time'])); ?>
                        </div>
                        <span class="badge"><?php echo formatBatchDays($row['batch_days']); ?></span>

                        <!-- Delete Icon -->
                        <i class="fas fa-trash delete-icon" data-id="<?php echo $row['id']; ?>"></i>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No batches found</p>
            <?php endif; ?>

            <div class="add" onclick="location.href='4win.php'">
                <i class="fas fa-plus"></i>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-icon").forEach(icon => {
        icon.addEventListener("click", function (e) {
            e.stopPropagation(); // Prevent navigation when clicking delete
            let batchId = this.getAttribute("data-id");

            fetch("delete_batch.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "batch_id=" + encodeURIComponent(batchId)
            })
            .then(response => response.text()) // Get text response (debugging)
            .then(data => {
                console.log("Server Response:", data); // Debugging
                window.location.reload(); // Reload to see session message
            })
            .catch(error => console.error("Error:", error));
        });
    });
});


    </script>
</body>
</html>