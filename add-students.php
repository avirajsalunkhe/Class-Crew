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

if (!isset($_GET['id'])) {
    echo "<script>alert('Batch ID is missing.'); window.location.href='5win.php';</script>";
    exit;
}

$batch_id = $_GET['id'];

// Fetch students NOT in the batch
$students_query = "SELECT id, name, email, phone, batch1, batch2, batch3, batch4, batch5 FROM students";
$students_result = $conn->query($students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Students to Batch</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #F8FDFF; margin: 0; }
        .container { padding: 20px; }
        .search-bar {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
            position: relative;
        }
        .search-bar input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }
        .search-bar i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #11137D;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #11137D;
            color: white;
        }
        .back-button {
            text-decoration: none;
            background: #11137D;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 15px;
        }
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
    </style>
    <script>
        function searchStudents() {
            let input = document.getElementById("search").value.toLowerCase();
            let rows = document.getElementsByClassName("student-row");

            for (let i = 0; i < rows.length; i++) {
                let name = rows[i].getElementsByClassName("student-name")[0].textContent.toLowerCase();
                if (name.includes(input)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
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
            <a href="4.1win.php?id=<?php echo $batch_id; ?>" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>
            <h2>Add Students to Batch</h2>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" id="search" onkeyup="searchStudents()" placeholder="Search students...">
                <i class="fas fa-search"></i>
            </div>

            <!-- Students Table -->
            <form action="add_student_to_batch.php" method="POST">
            <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>">

            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($students_result->num_rows > 0): ?>
                        <?php while ($student = $students_result->fetch_assoc()): 
                            $student_id = $student['id'];
                            $isInBatch = in_array($batch_id, [$student['batch1'], $student['batch2'], $student['batch3'], $student['batch4'], $student['batch5']]);
                        ?>
                            <tr class="student-row">
                                <td><?php echo $student_id; ?></td>
                                <td class="student-name"><?php echo htmlspecialchars($student['name']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                <td>
                                    <input type="checkbox" name="selected_students[]" value="<?php echo $student_id; ?>" <?php echo $isInBatch ? 'checked' : ''; ?>>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5"><center>No students available.</center></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <br><br><br><button type="submit" class="btn-primary">Add Selected Students</button>
        </form>
        </main>
    </div>
</body>
</html>
