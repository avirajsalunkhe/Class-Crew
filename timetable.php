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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px; /* Rounded corners */
    overflow: hidden; /* Ensures border-radius applies */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Optional shadow for better look */
}

thead {
    background-color: #11137D; /* Match the logout button color */
    color: white;
    font-weight: bold;
}

thead th {
    padding: 12px;
    text-align: left;
}

table, th, td {
    border: 1px solid #ddd; /* Light gray border */
}

td {
    padding: 10px;
    text-align: center;
}

tr:last-child td {
    border-bottom: none;
}
/* 

        .timetable th, .timetable td {
            border: 1px solidrgb(0, 0, 0);
            padding: 10px;
            text-align: center;
        }

        .timetable th {
            background: #3498db;
            color: white;
        }

        .timetable tr:nth-child(even) {
            background: #f2f2f2;
        } */

.sidebar nav ul li.active {
    color: #11137D;
    background-color: #f5f5f5;
}

        /* Main Content */
        .main-content {
            margin-left: 250px;
            width: 100%;
            padding: 20px;
        }

        /* Timetable */
        .timetable {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .timetable th, .timetable td {
            border: 1pxrgb(0, 0, 0);
            padding: 10px;
            text-align: center;
        }

        .timetable th {
            background:#11137D;
            color: white;
        }

        .timetable tr:nth-child(even) {
            background: #f2f2f2;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 200px;
            }
        }

        @media screen and (max-width: 500px) {

            .main-content {
                margin-left: 100px;
            }
        }
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
.tital h1{
    color: #11137D;
    font-size: 2rem;
    margin-bottom: 1rem;
    display: flex;
    margin-left: -100px;
    align-items: center;
    justify-content: center;
}
    </style>
<?php
        include 'sidebar.php';
        
        ?>
        </head>
        <body>
    <!-- Main Content -->
    <div class="container">

        <!-- Top Bar -->
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
        </div>
        <div class="tital">
            <h1>Timetable</h1>
        </div>
        <!-- Timetable -->
        <table class="timetable">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>9:00 - 10:00 AM</td>
                    <td>Math</td>
                    <td>Science</td>
                    <td>English</td>
                    <td>History</td>
                    <td>Physics</td>
                </tr>
                <tr>
                    <td>10:00 - 11:00 AM</td>
                    <td>English</td>
                    <td>Math</td>
                    <td>Science</td>
                    <td>Computer</td>
                    <td>History</td>
                </tr>
                <tr>
                    <td>11:00 - 12:00 PM</td>
                    <td>Physics</td>
                    <td>English</td>
                    <td>Math</td>
                    <td>Science</td>
                    <td>Computer</td>
                </tr>
            </tbody>
        </table>

    </div>

</body>
</html>
