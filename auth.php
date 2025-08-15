<?php
// auth.php
require_once 'vendor/autoload.php';
require_once 'config.php';

// ✅ Safely start session:
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class GoogleAuth {
    private $client;
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->client = new Google_Client();
        $this->client->setClientId(GOOGLE_CLIENT_ID);
        $this->client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $this->client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $this->client->addScope('email');
        $this->client->addScope('profile');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
    }
    
    public function getAuthUrl() {
        return $this->client->createAuthUrl();
    }
    
    public function handleCallback($code) {
        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($code);
            
            if (isset($token['error'])) {
                throw new Exception('Error fetching access token: ' . $token['error']);
            }
            
            $this->client->setAccessToken($token);
            
            // Get user info
            $oauth2 = new Google_Service_Oauth2($this->client);
            $userInfo = $oauth2->userinfo->get();
            
            // Store session
            $sessionId = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + $token['expires_in']);
            
            $stmt = $this->pdo->prepare("
                INSERT INTO user_sessions (session_id, user_email, user_google_id, access_token, refresh_token, expires_at) 
                VALUES (?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                access_token = VALUES(access_token),
                refresh_token = VALUES(refresh_token),
                expires_at = VALUES(expires_at)
            ");
            
            $stmt->execute([
                $sessionId,
                $userInfo->email,
                $userInfo->id,
                $token['access_token'],
                $token['refresh_token'] ?? null,
                $expiresAt
            ]);
            
            $_SESSION['session_id'] = $sessionId;
            $_SESSION['user_email'] = $userInfo->email;
            $_SESSION['user_google_id'] = $userInfo->id;
            
            return true;
            
        } catch (Exception $e) {
            error_log('OAuth callback error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function isAuthenticated() {
        if (!isset($_SESSION['session_id'])) {
            return false;
        }
        
        $stmt = $this->pdo->prepare("SELECT * FROM user_sessions WHERE session_id = ? AND expires_at > NOW()");
        $stmt->execute([$_SESSION['session_id']]);
        
        return $stmt->fetch() !== false;
    }
    
    public function logout() {
        if (isset($_SESSION['session_id'])) {
            $stmt = $this->pdo->prepare("DELETE FROM user_sessions WHERE session_id = ?");
            $stmt->execute([$_SESSION['session_id']]);
        }
        
        session_destroy();
    }
}
?>
