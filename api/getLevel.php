<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Game.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit();
}

$database = new Database();
$game = new Game($database);

$user_id = $_SESSION['user_id'];
$riddle = $game->getRandomRiddle();

echo json_encode($riddle);
?>
