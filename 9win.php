<?php
session_start();
if (!$_SESSION['avi']) {
    header('location:admin-login.php');
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Upload - Matoshree Classes</title>
    <link rel="stylesheet" href="9winstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <script>
        // Mobile menu toggle functionality
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }
    </script>

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

    <div class="container">
        <?php include 'sidebar.php'; ?>
        <main class="main-content">
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
                    position: relative;
                    background: white;
                    border-radius: 8px;
                    padding: 1rem;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: space-between;
                    min-height: 150px;
                }
                
                .delete-test {
                    position: absolute;
                    bottom: 10px;
                    right: 10px;
                    color: #ff4d4d;
                    font-size: 1.2rem;
                    cursor: pointer;
                    transition: color 0.3s ease, transform 0.2s ease;
                }
                
                .delete-test:hover {
                    color: #d90000;
                    transform: scale(1.1);
                }
                
                .current-test h3{
                    color: #11137D;
                }

                .current-test h5{
                    color: #11137D;
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

            <?php
            include "conn.php";
            $query = "SELECT id, batch_id, test_name, subject FROM stu_test ORDER BY created_at DESC LIMIT 10";
            $result = $conn->query($query);
            ?>

            <section class="upload-section"><br><br><br>
                <div class="recently-uploaded">
                    <h2>Recently Generated Tests</h2>
                    <div class="test-grid">
                        <?php 
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='current-test' data-test-id='" . $row["id"] . "'>";
                                echo "<h3>" . htmlspecialchars($row["test_name"]) . "</h3>";
                                echo "<h5>Batch ID: " . htmlspecialchars($row["batch_id"]) . "</h5>";
                                echo "<a href='view_test.php?id=" . $row["id"] . "' class='btn-primary'>View</a>"; 
                                echo "<i class='fas fa-trash delete-test' data-test-id='" . $row["id"] . "'></i>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No tests found.</p>";
                        }
                        ?>
                    </div>
                </div>
            </section>

            <button id='add' class="fab">
                <i id='plus' class="fas fa-plus"></i>
            </button>
        </main>
    </div>

    <script>
        document.addEventListener("click", function(event) {
            let targetId = event.target.id;
            let path = "";

            if (targetId === "add" || targetId === "plus") {
                path = "8win.php";
            }

            if (path) {
                window.location.href = path;
            }
        });
    </script>
<script>

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("delete-test")) {
            let testId = event.target.getAttribute("data-test-id");
            let testDiv = event.target.closest(".current-test");
            
            if (testId) {
                fetch("delete_test.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "test_id=" + testId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        testDiv.remove(); // Remove the test immediately
                        showNotification(data.message, "success"); // Show notification
                    } else {
                        showNotification(data.message, "error"); 
                    }
                })
            .catch(error => showNotification("An unexpected error occurred.", "error"));
        }
    }
});

function showNotification(message, type) {
    let notification = document.createElement("div");
    notification.classList.add("notification1", type);
    notification.innerText = message;
    
    // Ensure the notification is visible immediately
    notification.style.display = "block";
    notification.style.opacity = "0"; // Start hidden
    document.body.appendChild(notification);

    // Allow a slight delay before showing
    setTimeout(() => {
        notification.style.opacity = "1";
    }, 100);

    // Auto-hide notification
    setTimeout(() => {
        notification.style.opacity = "0";
        setTimeout(() => notification.remove(), 500); // Remove after fade-out
    }, 3000);
}


</script>

</body>
</html>