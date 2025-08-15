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

<style>

        body {
            background-color: #F8FDFF;
        }

        .container {
            padding: 2rem;
            margin-left: 250px;
        }

        .header {
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 1.5rem;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card.blue {
            background-color: #E4FBF9;
        }

        .stat-card.pink {
            background-color: #FFE9EC;
        }

        .stat-card h3 {
            color: #11137D;
            font-size: 2.5rem;
            margin: 0.5rem 0;
            pointer-events: none;
        }

        .stat-card p {
            color: #666;
            font-size: 0.9rem;
            pointer-events: none;
        }

        .stat-card h4 {
        pointer-events: none;
        }
        .activity-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .activity-card {
            background: #11137D;
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .create-notice {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            padding: 1rem 44rem;
            background: white;
            border: none;
            border-radius: 10px;
            color: #11137D;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            box-shadow: -3px 5px 20px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .create-notice:hover {
            transform: translateY(-4px);
        }

        @media (max-width: 768px) {
            .container {
                margin-left: 0;
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
            }

            .search-bar {
                width: 100%;
            }

            .activity-section {
                grid-template-columns: 1fr;
            }
        }

        .sidebar {
    width: 250px;
    background-color: white;
    padding: 2rem;
    border-right: 1px solid #eee;
    position: fixed;
    height: 100vh;
}

.logo h1 {
    color: #11137D;
    font-size: 1.5rem;
    margin-bottom: 2rem;
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
    color: #11137D;
    background-color: #f5f5f5;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}
.header-right {
    display: flex;
    align-items: stretch;
    gap: 1.5rem;
    flex-direction: row;
    justify-content: flex-end;
}

.notification-btn {
    background: none;
    border: none;
    color: #11137D;
    cursor: pointer;
    font-size: 1.2rem;
}

.profile {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.profile-info {
    display: flex;
    flex-direction: column;
}

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

.toggle-buttons {
    display: flex;
    gap: 1rem;
}

.toggle-btn {
    padding: 0.8rem 2rem;
    border: none;
    border-radius: 2rem;
    background: #FFE5E5;
    color: #666;
    cursor: pointer;
    font-weight: 500;
}

.toggle-btn.active {
    background: #FFE5E5;
    color: #11137D;
}
</style>
<?php
        include 'sidebar.php';
        
        ?>
</head>
<body>
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'matoshree_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Search functionality
    $search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $students = [];
    if ($search_query) {
        $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' LIMIT 5";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
    }

    // Fetch stats
    $total_batches = $conn->query("SELECT COUNT(*) as count FROM batches")->fetch_assoc()['count'];
    $attendance_percent = $conn->query("SELECT AVG(attendance_rate) as avg FROM attendance")->fetch_assoc()['avg'];
    $notes_uploaded = $conn->query("SELECT COUNT(*) as count FROM notes")->fetch_assoc()['count'];
    $quizzes_count = $conn->query("SELECT COUNT(*) as count FROM stu_test")->fetch_assoc()['count'];
    ?>
    
    
    <div class="container">
        <div class="header">
            <form class="search-bar" method="GET" action="">
                <input type="text" name="search" placeholder="Search" value="<?php echo htmlspecialchars($search_query); ?>">
                <i class="fas fa-search"></i>
            </form>
        <div class="header-right">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                    </button>
                    <!-- <div class="profile">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/6-Rxq3Mdgno9OezARSiLhn9vj0qyZoAC.png" alt="Profile">
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

        </div>
        <?php if (!empty($students)): ?>
        <div class="search-results">
            <h3>Search Results:</h3>
            <ul>
                <?php foreach ($students as $student): ?>
                    <li><?php echo htmlspecialchars($student['name']); ?> - Batch: <?php echo htmlspecialchars($student['batch']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

         <div class="stats-grid">
         <div class="stat-card blue" id='batches' >
                <h4>Total Batches</h4>
                <h3><?php echo $total_batches; ?></h3>
            </div>
            <div class="stat-card pink" id='attendance'>
                <h4>Attendance</h4>
                <h3><?php echo round($attendance_percent); ?>%</h3>
                <p><?php echo round(100 - $attendance_percent); ?>% Absent</p>
            </div>
            <div class="stat-card blue" id='notes'>
                <h4>Notes Upload</h4>
                <h3><?php echo $notes_uploaded; ?></h3>
            </div>
        </div>

        <div class="activity-section">
            <div class="activity-card">
                <h2>Recently Activity</h2>
                <?php
                $activities = $conn->query("SELECT * FROM activities ORDER BY timestamp DESC LIMIT 5");
                while($activity = $activities->fetch_assoc()):
                ?>
                <div class="activity-item">
                    <i class="fas fa-file-alt"></i>
                    <div>
                        <h4><?php echo htmlspecialchars($activity['title']); ?></h4>
                        <p><?php echo date('F j, Y, g:i a', strtotime($activity['timestamp'])); ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <div class="stat-card" id='quezz'>
                <h4>Test Generated</h4>
                <h3><?php echo $quizzes_count; ?></h3>
                <p>Most Played</p>
                <p style="color: #11137D; font-weight: bold;">Chemistry</p>
            </div>
        </div>

        <a href="2win.php" class="create-notice">
        <center>  <i class="fas fa-bullhorn"></i>
           Create Notice</center>
        </a>
    </div>

    <?php $conn->close(); ?>

    <script>
        // Add any additional JavaScript functionality here
        document.querySelector('.search-bar input').addEventListener('input', function(e) {
            if(e.target.value.length > 2) {
                this.form.submit();
            }
        });

        document.addEventListener("click", function(event) {
            let targetId = event.target.id;
            let path = "";

            if (targetId === "batches") {
                path = "5win.php";
            } else if (targetId === "attendance") {
                path = "7win.php";
            } else if (targetId === "notes") {
                path = "6win.php";
            } else if (targetId === "quezz") {
                path = "9win.php";
            }

            if (path) {
                window.location.href = path; // Opens in the same tab
            }
        });
    </script>
</body>
</html>