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
    <title>Upload Notes</title>
    <!-- <link rel="stylesheet" href="6winstyle.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
</head>
<body>
        <script>
    // Toggle buttons functionality
    const toggleBtns = document.querySelectorAll('.toggle-btn');
    
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            toggleBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
</script>
    <div class="container">
        <!-- Sidebar -->
        <?php
include 'sidebar.php';

?>
<style>
    .btn-primary {
    background-color: #11137D;
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 0.5rem;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

/* Merged and enhanced styles with consistent colors and hover effects */

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
  transition: background-color 0.3s ease, color 0.3s ease;
}

.sidebar nav ul li.active {
  color: #11137D;
  background-color: #f5f5f5;
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

/* Upload Section Styles */
.upload-section {
  max-width: 1200px;
  margin: 0 auto;
}

.upload-section h1 {
  color: #11137d;
  font-size: 2rem;
  margin-bottom: 1rem;
}

.upload-info {
  color: #666;
  margin-bottom: 2rem;
}

.upload-options {
  display: flex;
  margin-bottom: 3rem;
  flex-direction: column;

}

.toggle-buttons {
  display: flex;
  gap: 1rem;
}

.toggle-btn {
  padding: 0.0rem 2rem;
  border: none;
  border-radius: 2rem;
  background: #ffe5e5;
  color: #666;
  cursor: pointer;
  font-weight: 500;
}

.toggle-btn.active {
  background: #ffe5e5;
  color: #11137d;
}

.upload-btn {
  padding: 0.8rem 3rem;
  background: #f8fdff;
  border: none;
  border-radius: 0.5rem;
  color: #11137d;
  font-weight: bold;
  cursor: pointer;
}

/* Button Styles */
.btn-primary,
.btn-secondary,
.view-btn {
  background-color: #11137D;
  color: white;
  border: none;
  border-radius: 0.5rem;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary,
.view-btn {
  padding: 0.8rem 2rem;
}

.btn-secondary {
  padding: 0.8rem 1.5rem;
  width: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  text-decoration: none;
  border: 1px solid #11137D;
}

.view-btn:hover,
.btn-primary:hover,
.btn-secondary:hover {
  background-color: #11137D;
}

.view-btn:active,
.btn-primary:active,
.btn-secondary:active {
  background-color: #11137D;
  transform: translateY(1px);
}

.sub-btn {
  display: flex;
  justify-content: center;
}

/* Form Styling */
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
  width: 100%;
  padding: 1rem;
  border: 1px solid #11137D;
  border-radius: 0.5rem;
  outline: none;
  font-size: 1rem;
  height: 3.25rem;
}

.form-group select {
  background-color: white;
  cursor: pointer;
  appearance: none;
  padding-right: 2rem;
  text-align: left;
  background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%2311137D" d="M2 0L0 2h4z"/></svg>');
  background-repeat: no-repeat;
  background-position: right 1rem center;
  background-size: 10px;
}

.back-button {
  text-decoration: none;
  background: #11137D;
  color: white;
  padding: 10px;
  border-radius: 5px;
}

/* Recently Uploaded */
.recently-uploaded {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.recently-uploaded h2 {
  font-size: 24px;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 24px;
  text-align: left;
}

.files-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  align-items: start;
}

.files-column {
  display: flex;
  flex-direction: column;
}

.file-cards {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.file-card {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: all 0.2s ease;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.file-card:hover {
  border-color: #d1d5db;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
}

.file-info {
  flex: 1;
}

.file-info h4 {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 4px 0;
  line-height: 1.4;
}

.file-info .batch {
  font-size: 14px;
  color: #6b7280;
  font-weight: 400;
}

.file-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 8px;
}

.file-actions .date {
  font-size: 12px;
  color: #9ca3af;
  font-weight: 400;
}

/* Responsive */
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

  .files-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .recently-uploaded {
    padding: 16px;
  }

  .file-card {
    padding: 16px;
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
  }

  .file-actions {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }
}

@media (max-width: 480px) {
  .recently-uploaded h2 {
    font-size: 20px;
    margin-bottom: 16px;
  }

  .file-card {
    padding: 12px;
  }

  .file-info h4 {
    font-size: 15px;
  }

  .view-btn {
    padding: 6px 12px;
    font-size: 13px;
  }
}


.status-dot {
    font-size: 2.1rem;
    margin-right: 20px;
    margin-top: -10px;
    margin-bottom: -10px;
}
.status-btn {
    margin-left: 10px;
    padding: 5px 10px;
    font-size: 0.9rem;
    cursor: pointer;
}

.status-btn {
  background-color: #F0F2F5;  /* Light gray-blue */
  color: #11137D;             /* Your theme's deep blue for text */
  border: 1px solid #D1D5DB;  /* Subtle border */
  padding: 0.4rem 1rem;
  border-radius: 0.5rem;
  cursor: pointer;
  font-weight: 500;
  font-size: 0.9rem;
  transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
}

.status-btn:hover {
  background-color: #E2E8F0;  /* Slightly darker on hover */
  color: #0F172A;             /* Darker blue on hover */
}

.status-btn:active {
  transform: translateY(1px);
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
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/6-Rxq3Mdgno9OezARSiLhn9vj0qyZoAC.png" alt="Profile">
                        <div class="profile-info">
                            <div class="profile-name">
                                Matoshree Classes <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="profile-role">Admin</div>
                        </div>
                    </div> -->
                </div>
            </header>

            <section class="upload-section">
    <h1>Upload Notes Here</h1>
    <p class="upload-info">Please select the batch then upload the document*</p>

    <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-options">

        <div class="form-group">
            <label>Select Batch:</label>
            <select name="batch_id" required>
                <?php
                include "conn.php";
                $result = $conn->query("SELECT * FROM batches");
                echo "<option value=''>Select Batch</option>";
                while ($batch = $result->fetch_assoc()) {
                    echo "<option value='{$batch['name']}'>{$batch['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Select File:</label>
            <input type="file" name="file" required>
            
          </div>
          <br>
          <br>
          <div class="sub-btn">
              <button type="submit" name="submit" class="btn-secondary">Upload</button>
        </div>

    </form>

    <br><br>
</section>


            
            <script>
            function toggleSelection(selectedBtn) {
                document.querySelectorAll(".toggle-btn").forEach(btn => btn.classList.remove("active"));
                selectedBtn.classList.add("active");
            }
            </script>

<?php
// Database connection
include("conn.php");

// Fetch recently uploaded files
function getRecentlyUploadedFiles($conn, $limit = 6) {
    // Ensure limit is an integer
    $limit = (int)$limit;

    $sql = "SELECT `id`,`file_name`, `google_drive_link`, `batch_name`, `upload_timestamp`, `status`
    FROM file_uploads 
    ORDER BY upload_timestamp DESC 
    LIMIT ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    
    $result = $stmt->get_result(); // Only available with mysqlnd driver
    return $result->fetch_all(MYSQLI_ASSOC);
}
// Get the files
$recentFiles = getRecentlyUploadedFiles($conn);

// Split files into two columns for display
$column1 = array_slice($recentFiles, 0, ceil(count($recentFiles) / 2));
$column2 = array_slice($recentFiles, ceil(count($recentFiles) / 2));

// Function to format date
function formatDate($date) {
    return date('d/m/y', strtotime($date));
}
?>

<div class="recently-uploaded">
    <h2>Recently Uploaded</h2>
    
    <div class="files-grid">
        <!-- First Column -->
        <div class="files-column">
        <div class="file-cards">
    <?php foreach($column1 as $file): ?>
    <div class="file-card" id="file-<?php echo $file['id']; ?>">
        <div class="file-info">
            <h4><?php echo htmlspecialchars($file['file_name']); ?></h4>
            <span class="batch"><?php echo htmlspecialchars($file['batch_name']); ?></span>
        </div>
        <div class="file-actions">
            <span class="date"><?php echo formatDate($file['upload_timestamp']); ?></span>

            <!-- Status dot -->
            <span class="status-dot" style="color: <?php echo $file['status'] === 'active' ? 'green' : 'red'; ?>;">●</span>

            <!-- Toggle Button -->
            <button class="status-btn" onclick="toggleStatus(<?php echo $file['id']; ?>)">
                <?php echo $file['status'] === 'active' ? 'Deactivate' : 'Activate'; ?>
            </button>

            <!-- View Button -->
            <button class="view-btn" onclick="viewFile(<?php echo $file['id']; ?>, '<?php echo htmlspecialchars($file['google_drive_link']); ?>')">View File</button>
        </div>
    </div>
    <?php endforeach; ?>
</div>


        </div>

        <!-- Second Column -->
        <div class="files-column">
        <div class="file-cards">
    <?php foreach($column2 as $file): ?>
    <div class="file-card" id="file-<?php echo $file['id']; ?>">
        <div class="file-info">
            <h4><?php echo htmlspecialchars($file['file_name']); ?></h4>
            <span class="batch"><?php echo htmlspecialchars($file['batch_name']); ?></span>
        </div>
        <div class="file-actions">
            <span class="date"><?php echo formatDate($file['upload_timestamp']); ?></span>

            <!-- Status dot -->
            <span class="status-dot" style="color: <?php echo $file['status'] === 'active' ? 'green' : 'red'; ?>;">●</span>

            <!-- Toggle Button -->
            <button class="status-btn" onclick="toggleStatus(<?php echo $file['id']; ?>)">
                <?php echo $file['status'] === 'active' ? 'Deactivate' : 'Activate'; ?>
            </button>

            <!-- View Button -->
            <button class="view-btn" onclick="viewFile(<?php echo $file['id']; ?>, '<?php echo htmlspecialchars($file['google_drive_link']); ?>')">View File</button>
        </div>
    </div>
    <?php endforeach; ?>
</div>

        </div>
    </div>
</div>

<script>
function toggleStatus(fileId) {
    fetch('update_status.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'file_id=' + fileId
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            const fileCard = document.getElementById('file-' + fileId);
            const dot = fileCard.querySelector('.status-dot');
            const btn = fileCard.querySelector('.status-btn');

            if (data.new_status === 'active') {
                dot.style.color = 'green';
                btn.textContent = 'Deactivate';
            } else {
                dot.style.color = 'red';
                btn.textContent = 'Activate';
            }
        } else {
            alert('Failed to update status: ' + data.error);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Network error.');
    });
}

</script>

<script>
function viewFile(fileId, filePath) {
    // You can customize this function based on your needs
    // Option 1: Open in new window
    window.open(filePath, '_blank');
    
    // Option 2: Redirect to a view page
    // window.location.href = 'view_file.php?id=' + fileId;
    
    // Option 3: Open in modal (requires additional modal code)
    // openFileModal(filePath);
}
</script>
</body>
</html>

