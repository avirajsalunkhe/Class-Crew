<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Navigation</title>
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <!-- Mobile Toggle Button -->
    <!-- <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button> -->

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="logo">
        
            <h1 > Matoshree classes</h1>
            <!-- <a href="1stwin.php" class="nav-link"> -->
        </div>
        <nav>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="1stwin.php" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="5win.php" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Batches</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="timetable.php" class="nav-link">
                        <i class="fas fa-calendar"></i>
                        <span>Timetable</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="6win.php" class="nav-link">
                        <i class="fas fa-file-alt"></i>
                        <span>Notes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="7win.php" class="nav-link">
                        <i class="fas fa-user-check"></i>
                        <span>Attendance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="9win.php" class="nav-link">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Test</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="adminlogout.php" class="btn-primary">
                        <i class="fas fa-logout"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <script>
        // Add active class to current page link
        const currentPage = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            if(link.getAttribute('href') === currentPage.split('/').pop()) {
                link.classList.add('active');
            }
        });

        // Mobile sidebar toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>