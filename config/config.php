<?php
// Configuration générale
define('BASE_URL', 'http://localhost/GAME/public/');
define('API_URL', 'http://localhost/GAME/api/');

// Configuration base de données
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'game_4images');

// Configuration API Unsplash
define('UNSPLASH_API_KEY', getenv('UNSPLASH_API_KEY') ?: '');
define('UNSPLASH_BASE_URL', 'https://api.unsplash.com');

// Configuration session
define('SESSION_TIMEOUT', 3600); // 1 heure
define('SESSION_SECRET', getenv('SESSION_SECRET') ?: 'secret_key');

// Activer les erreurs (à désactiver en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
