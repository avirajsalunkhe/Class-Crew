<?php
// upload.php
require_once 'auth.php';
require_once 'drive_service.php';

session_start();

$auth = new GoogleAuth($pdo);
$driveService = new DriveService($pdo);

// Check authentication
if (!$auth->isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate inputs
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error');
        }
        
        if (empty($_POST['batch_name'])) {
            throw new Exception('Batch name is required');
        }
        
        $file = $_FILES['file'];
        $batchName = trim($_POST['batch_name']);
        
        // Validate file size (e.g., max 100MB)
        $maxSize = 100 * 1024 * 1024; // 100MB
        if ($file['size'] > $maxSize) {
            throw new Exception('File size exceeds maximum limit');
        }
        
        // Validate file type (customize as needed)
        $allowedTypes = [
            'image/jpeg', 'image/png', 'image/gif',
            'application/pdf', 'text/plain',
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('File type not allowed');
        }
        
        // Upload to Google Drive
        $result = $driveService->uploadFile(
            $file['tmp_name'],
            $file['name'],
            $file['type'],
            $_SESSION['user_email'],
            $_SESSION['user_google_id'],
            $batchName
        );
        
        if ($result['success']) {
            $response = [
                'success' => true,
                'message' => 'File uploaded successfully',
                'file_id' => $result['file_id'],
                'shareable_link' => $result['shareable_link']
            ];
        } else {
            throw new Exception($result['error']);
        }
        
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

// Return JSON response for AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="file"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #4285f4; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #3367d6; }
        .message { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .file-list { margin-top: 30px; }
        .file-item { padding: 10px; border: 1px solid #ddd; margin: 5px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>File Upload System</h1>
    
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>! 
       <a href="logout.php">Logout</a>
    </p>
    
    <?php if ($response['message']): ?>
        <div class="message <?php echo $response['success'] ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($response['message']); ?>
            <?php if ($response['success'] && isset($response['shareable_link'])): ?>
                <br><a href="<?php echo $response['shareable_link']; ?>" target="_blank">View File</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="batch_name">Batch Name:</label>
            <input type="text" id="batch_name" name="batch_name" required 
                   value="<?php echo isset($_POST['batch_name']) ? htmlspecialchars($_POST['batch_name']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="file">Select File:</label>
            <input type="file" id="file" name="file" required>
        </div>
        
        <button type="submit">Upload File</button>
    </form>
    
    <div class="file-list">
        <h2>Your Uploaded Files</h2>
        <?php
        $userFiles = $driveService->getUserFiles($_SESSION['user_email']);
        if (empty($userFiles)): ?>
            <p>No files uploaded yet.</p>
        <?php else: ?>
            <?php foreach ($userFiles as $file): ?>
                <div class="file-item">
                    <strong><?php echo htmlspecialchars($file['file_name']); ?></strong><br>
                    Batch: <?php echo htmlspecialchars($file['batch_name']); ?><br>
                    Uploaded: <?php echo $file['upload_timestamp']; ?><br>
                    <a href="<?php echo htmlspecialchars($file['google_drive_link']); ?>" target="_blank">View File</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>