<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $id;
    private $username;
    private $email;
    private $level;
    private $score;
    private $best_score;
    private $db;
    
    public function __construct($db) {
        $this->db = $db->getConnection();
    }
    
    // Créer un nouvel utilisateur
    public function register($username, $email, $password) {
        if ($this->userExists($username, $email)) {
            return ['success' => false, 'message' => 'Utilisateur ou email déjà existant'];
        }
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);
        
        $sql = "INSERT INTO users (username, email, password, level, score, best_score) 
                VALUES ('$username', '$email', '$hashed_password', 1, 0, 0)";
        
        if ($this->db->query($sql)) {
            $this->id = $this->db->insert_id;
            $this->username = $username;
            $this->email = $email;
            $this->level = 1;
            $this->score = 0;
            $this->best_score = 0;
            return ['success' => true, 'message' => 'Inscription réussie'];
        }
        
        return ['success' => false, 'message' => 'Erreur lors de l\'inscription'];
    }
    
    // Connexion utilisateur
    public function login($username, $password) {
        $username = $this->db->real_escape_string($username);
        
        $sql = "SELECT id, username, email, password, level, score, best_score FROM users WHERE username = '$username'";
        $result = $this->db->query($sql);
        
        if (!$result || $result->num_rows === 0) {
            return ['success' => false, 'message' => 'Utilisateur non trouvé'];
        }
        
        $user = $result->fetch_assoc();
        
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Mot de passe incorrect'];
        }
        
        $this->id = $user['id'];
        $this->username = $user['username'];
        $this->email = $user['email'];
        $this->level = $user['level'];
        $this->score = $user['score'];
        $this->best_score = $user['best_score'];
        
        // Créer la session
        $_SESSION['user_id'] = $this->id;
        $_SESSION['username'] = $this->username;
        $_SESSION['email'] = $this->email;
        $_SESSION['level'] = $this->level;
        
        return ['success' => true, 'message' => 'Connexion réussie', 'user' => [
            'id' => $this->id,
            'username' => $this->username,
            'level' => $this->level,
            'score' => $this->score
        ]];
    }
    
    // Vérifier si utilisateur existe
    private function userExists($username, $email) {
        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);
        
        $sql = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
        $result = $this->db->query($sql);
        
        return $result && $result->num_rows > 0;
    }
    
    // Obtenir le profil utilisateur
    public function getProfile($user_id) {
        $sql = "SELECT id, username, email, level, score, best_score, total_wins, created_at 
                FROM users WHERE id = " . intval($user_id);
        
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    // Mettre à jour le score et le niveau
    public function updateProgress($user_id, $points) {
        $user_id = intval($user_id);
        
        $sql = "UPDATE users SET score = score + $points WHERE id = $user_id";
        
        if ($this->db->query($sql)) {
            // Vérifier si le joueur a complété 10 énigmes
            $sql_wins = "SELECT COUNT(*) as wins FROM user_progress 
                         WHERE user_id = $user_id AND completed = 1";
            $wins_result = $this->db->query($sql_wins);
            $wins = $wins_result->fetch_assoc()['wins'];
            
            if ($wins % 5 == 0) {
                // Augmenter le niveau tous les 5 énigmes complétées
                $new_level = intval($wins / 5) + 1;
                $sql_level = "UPDATE users SET level = $new_level, total_wins = $wins WHERE id = $user_id";
                $this->db->query($sql_level);
            }
            
            return true;
        }
        
        return false;
    }
    
    // Sauvegarde du meilleur score
    public function updateBestScore($user_id, $new_score) {
        $user_id = intval($user_id);
        $new_score = intval($new_score);
        
        $sql = "UPDATE users SET best_score = GREATEST(best_score, $new_score) WHERE id = $user_id";
        return $this->db->query($sql);
    }
    
    // Setter/Getter
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getLevel() { return $this->level; }
    public function getScore() { return $this->score; }
    public function getBestScore() { return $this->best_score; }
}
?>
