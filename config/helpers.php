<?php
/**
 * Helper pour les sessions et l'authentification
 */

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCurrentUsername() {
    return $_SESSION['username'] ?? null;
}

function requireLogin() {
    if (!isUserLoggedIn()) {
        header('Location: ' . BASE_URL . 'index.php');
        exit();
    }
}

function redirectIfLoggedIn() {
    if (isUserLoggedIn()) {
        header('Location: ' . BASE_URL . 'game.php');
        exit();
    }
}

function logout() {
    session_destroy();
    header('Location: ' . BASE_URL . 'index.php');
    exit();
}

function setFlash($message, $type = 'info') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function hasFlash() {
    return isset($_SESSION['flash']);
}
?>
