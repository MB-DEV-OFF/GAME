<?php
require_once __DIR__ . '/../config/database.php';

class Game {
    private $db;
    private $categories = ['ANIMALS', 'FRUITS', 'NATURE', 'SPORTS', 'FOOD', 'TECHNOLOGY'];
    private $words = [
        'ANIMALS' => ['ELEPHANT', 'LION', 'TIGER', 'BEAR', 'WOLF', 'EAGLE', 'DOLPHIN', 'PENGUIN'],
        'FRUITS' => ['BANANA', 'ORANGE', 'STRAWBERRY', 'WATERMELON', 'GRAPE', 'LEMON', 'MANGO'],
        'NATURE' => ['MOUNTAIN', 'RIVER', 'FOREST', 'OCEAN', 'SUNSET', 'FLOWER', 'BUTTERFLY'],
        'SPORTS' => ['FOOTBALL', 'BASKETBALL', 'TENNIS', 'SWIMMING', 'CYCLING', 'RUNNING'],
        'FOOD' => ['PIZZA', 'BURGER', 'SUSHI', 'PASTA', 'CHOCOLATE', 'CHEESE'],
        'TECHNOLOGY' => ['COMPUTER', 'PHONE', 'ROBOT', 'CAMERA', 'DRONE', 'LAPTOP']
    ];
    
    public function __construct($database) {
        $this->db = $database->getConnection();
    }
    
    // Générer un nouveau niveau avec 4 images aléatoires
    public function generateLevel($user_id = null) {
        try {
            // Sélectionner une catégorie aléatoire
            $category = $this->categories[array_rand($this->categories)];
            
            // Sélectionner un mot aléatoire de la catégorie
            $words = $this->words[$category];
            $word = $words[array_rand($words)];
            
            // Créer des URLs Unsplash pour chaque lettre du mot
            $images = [];
            for ($i = 0; $i < 4; $i++) {
                $images[] = 'https://images.unsplash.com/photo-' . uniqid() . '?w=300&h=300&fit=crop';
            }
            
            return [
                'success' => true,
                'level' => [
                    'word' => $word,
                    'category' => $category,
                    'images' => $images,
                    'hint' => $this->generateHint($word),
                    'difficulty' => $this->calculateDifficulty($user_id)
                ]
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    // Vérifier la réponse
    public function checkAnswer($user_id, $answer, $correct_word, $riddle_id = null) {
        $user_id = intval($user_id);
        $answer = strtoupper(trim($answer));
        $correct_word = strtoupper(trim($correct_word));
        
        $is_correct = ($answer === $correct_word);
        
        // Calculer les points
        $points = 0;
        if ($is_correct) {
            $points = 10 + rand(0, 20); // 10 à 30 points
        }
        
        // Sauvegarder la tentative
        if ($riddle_id) {
            $this->saveAttempt($user_id, $riddle_id, $is_correct);
        }
        
        return [
            'success' => true,
            'correct' => $is_correct,
            'points' => $points,
            'message' => $is_correct ? 'Bravo! Bonne réponse!' : 'Mauvaise réponse, essaye encore!'
        ];
    }
    
    // Sauvegarder une tentative
    private function saveAttempt($user_id, $riddle_id, $was_correct) {
        $user_id = intval($user_id);
        $riddle_id = intval($riddle_id);
        $completed = $was_correct ? 1 : 0;
        
        $sql = "INSERT INTO user_progress (user_id, riddle_id, completed, attempts) 
                VALUES ($user_id, $riddle_id, $completed, 1)
                ON DUPLICATE KEY UPDATE 
                attempts = attempts + 1, 
                completed = $completed,
                completed_at = " . ($was_correct ? "NOW()" : "completed_at");
        
        return $this->db->query($sql);
    }
    
    // Générer un indice
    private function generateHint($word) {
        $length = strlen($word);
        $revealed = ceil($length / 2);
        $hint = substr($word, 0, $revealed);
        $hint .= str_repeat('*', $length - $revealed);
        return $hint;
    }
    
    // Calculer la difficulté selon le niveau du joueur
    private function calculateDifficulty($user_id) {
        if (!$user_id) return 1;
        
        $user_id = intval($user_id);
        $sql = "SELECT level FROM users WHERE id = $user_id";
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return intval($user['level']);
        }
        
        return 1;
    }
    
    // Récupérer les énigmes de la base
    public function getRandomRiddle() {
        $sql = "SELECT id, word, category, image1_url, image2_url, image3_url, image4_url, hint 
                FROM riddles ORDER BY RAND() LIMIT 1";
        
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $riddle = $result->fetch_assoc();
            return [
                'success' => true,
                'riddle' => [
                    'id' => $riddle['id'],
                    'word' => $riddle['word'],
                    'images' => [
                        $riddle['image1_url'],
                        $riddle['image2_url'],
                        $riddle['image3_url'],
                        $riddle['image4_url']
                    ],
                    'hint' => $riddle['hint']
                ]
            ];
        }
        
        // Générer une énigme si aucune en BD
        return $this->generateLevel();
    }
    
    // Obtenir les statistiques d'un joueur
    public function getPlayerStats($user_id) {
        $user_id = intval($user_id);
        
        $sql = "SELECT 
                    u.level, 
                    u.score, 
                    u.best_score, 
                    u.total_wins,
                    COUNT(DISTINCT up.id) as total_attempts,
                    COUNT(DISTINCT CASE WHEN up.completed = 1 THEN up.id END) as completed_riddles
                FROM users u
                LEFT JOIN user_progress up ON u.id = up.user_id
                WHERE u.id = $user_id
                GROUP BY u.id";
        
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    // Obtenir le classement
    public function getLeaderboard($limit = 10) {
        $limit = intval($limit);
        
        $sql = "SELECT username, level, score, best_score, total_wins 
                FROM users 
                ORDER BY best_score DESC, level DESC, total_wins DESC 
                LIMIT $limit";
        
        $result = $this->db->query($sql);
        $leaderboard = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $leaderboard[] = $row;
            }
        }
        
        return $leaderboard;
    }
}
?>
