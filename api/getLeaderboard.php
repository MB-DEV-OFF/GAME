<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Game.php';

$database = new Database();
$game = new Game($database);

$leaderboard = $game->getLeaderboard(15);

echo json_encode(['success' => true, 'leaderboard' => $leaderboard]);
?>
