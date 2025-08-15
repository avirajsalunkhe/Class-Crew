<?php
// drive_service.php
require_once 'vendor/autoload.php';
require_once 'config.php';

class DriveService {
    private $service;
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        
        // Initialize Google Drive service with service account
        $client = new Google_Client();
        $client->setAuthConfig(GOOGLE_SERVICE_ACCOUNT_FILE);
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        
        $this->service = new Google_Service_Drive($client);
    }
    
    public function uploadFile($filePath, $fileName, $mimeType, $userEmail, $userGoogleId, $batchName) {
        try {
            // Create file metadata
            $fileMetadata = new Google_Service_Drive_DriveFile([
                'name' => $fileName,
                'parents' => GOOGLE_DRIVE_FOLDER_ID ? [GOOGLE_DRIVE_FOLDER_ID] : null
            ]);
            
            // Upload file
            $content = file_get_contents($filePath);
            $file = $this->service->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart'
            ]);
            
            // Make file publicly readable (optional)
            $permission = new Google_Service_Drive_Permission([
                'role' => 'reader',
                'type' => 'anyone'
            ]);
            $this->service->permissions->create($file->id, $permission);
            
            // Generate shareable link
            $shareableLink = "https://drive.google.com/file/d/{$file->id}/view";
            
            // Save to database
            $stmt = $this->pdo->prepare("
                INSERT INTO file_uploads (user_email, user_google_id, file_name, google_drive_file_id, google_drive_link, batch_name, file_size, mime_type) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $fileSize = filesize($filePath);
            $stmt->execute([
                $userEmail,
                $userGoogleId,
                $fileName,
                $file->id,
                $shareableLink,
                $batchName,
                $fileSize,
                $mimeType
            ]);
            
            return [
                'success' => true,
                'file_id' => $file->id,
                'shareable_link' => $shareableLink,
                'database_id' => $this->pdo->lastInsertId()
            ];
            
        } catch (Exception $e) {
            error_log('Drive upload error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function getUserFiles($userEmail, $batchName = null) {
        $sql = "SELECT * FROM file_uploads WHERE user_email = ?";
        $params = [$userEmail];
        
        if ($batchName) {
            $sql .= " AND batch_name = ?";
            $params[] = $batchName;
        }
        
        $sql .= " ORDER BY upload_timestamp DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>