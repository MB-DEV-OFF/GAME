<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit();
}

$database = new Database();
$user = new User($database);

$user_id = $_SESSION['user_id'];
$profile = $user->getProfile($user_id);

if ($profile) {
    echo json_encode(['success' => true, 'user' => $profile]);
} else {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
}
?>
