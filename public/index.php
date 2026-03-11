<?php
require_once __DIR__ . '/../config/config.php';

// Rediriger si déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: game.php');
    exit();
}

$message = '';
$error = '';
$mode = 'login'; // login ou register

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../src/User.php';
    
    $database = new Database();
    $user = new User($database);
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'register') {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        
        if ($password !== $password_confirm) {
            $error = 'Les mots de passe ne correspondent pas!';
        } else if (strlen($password) < 6) {
            $error = 'Le mot de passe doit contenir au moins 6 caractères!';
        } else {
            $result = $user->register($username, $email, $password);
            if ($result['success']) {
                $message = 'Inscription réussie! Connectez-vous maintenant.';
                $mode = 'login';
            } else {
                $error = $result['message'];
                $mode = 'register';
            }
        }
    } else if ($action === 'login') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $result = $user->login($username, $password);
        if ($result['success']) {
            header('Location: game.php');
            exit();
        } else {
            $error = $result['message'];
            $mode = 'login';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4 Images 1 Mot - Jeu</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1>🎮 4 Images 1 Mot</h1>
            <p class="subtitle">Trouvez le mot avec 4 images!</p>
            
            <?php if ($message): ?>
                <div class="message success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div id="authForm">
                <!-- Formulaire de connexion -->
                <form id="loginForm" method="POST" class="<?php echo $mode === 'login' ? 'active' : 'hidden'; ?>">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <label for="login_username">Nom d'utilisateur</label>
                        <input type="text" id="login_username" name="username" required placeholder="Votre pseudo">
                    </div>
                    <div class="form-group">
                        <label for="login_password">Mot de passe</label>
                        <input type="password" id="login_password" name="password" required placeholder="Votre mot de passe">
                    </div>
                    <button type="submit" class="btn btn-primary">Connexion</button>
                    <p class="toggle-auth">Pas encore inscrit? <a href="#" onclick="toggleAuthForm()">S'inscrire</a></p>
                </form>
                
                <!-- Formulaire d'inscription -->
                <form id="registerForm" method="POST" class="<?php echo $mode === 'register' ? 'active' : 'hidden'; ?>">
                    <input type="hidden" name="action" value="register">
                    <div class="form-group">
                        <label for="register_username">Nom d'utilisateur</label>
                        <input type="text" id="register_username" name="username" required placeholder="Choisissez un pseudo">
                    </div>
                    <div class="form-group">
                        <label for="register_email">Email</label>
                        <input type="email" id="register_email" name="email" required placeholder="votre@email.com">
                    </div>
                    <div class="form-group">
                        <label for="register_password">Mot de passe</label>
                        <input type="password" id="register_password" name="password" required placeholder="Min 6 caractères">
                    </div>
                    <div class="form-group">
                        <label for="register_password_confirm">Confirmer le mot de passe</label>
                        <input type="password" id="register_password_confirm" name="password_confirm" required placeholder="Répétez le mot de passe">
                    </div>
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                    <p class="toggle-auth">Déjà inscrit? <a href="#" onclick="toggleAuthForm()">Se connecter</a></p>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/auth.js"></script>
</body>
</html>
