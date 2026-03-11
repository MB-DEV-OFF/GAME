<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Game.php';
require_once __DIR__ . '/../src/User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit();
}

// Récupérer JSON du body
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['answer']) || !isset($input['correct_word'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit();
}

$database = new Database();
$game = new Game($database);
$user = new User($database);

$user_id = $_SESSION['user_id'];
$answer = $input['answer'];
$correct_word = $input['correct_word'];
$riddle_id = $input['riddle_id'] ?? null;

// Vérifier la réponse
$result = $game->checkAnswer($user_id, $answer, $correct_word, $riddle_id);

// Mettre à jour la progression de l'utilisateur
if ($result['success'] && $result['correct']) {
    $user->updateProgress($user_id, $result['points']);
    
    // Mettre à jour le meilleur score
    $profile = $user->getProfile($user_id);
    if ($profile) {
        $user->updateBestScore($user_id, $profile['score'] + $result['points']);
    }
}

echo json_encode($result);
?>
