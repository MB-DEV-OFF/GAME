<?php
require_once __DIR__ . '/../config/config.php';

// Rediriger si pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
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
    <div class="game-container">
        <!-- Header -->
        <div class="game-header">
            <div class="header-left">
                <h1>🎮 4 Images 1 Mot</h1>
            </div>
            <div class="header-center">
                <div class="score-display">
                    <span class="score-label">Score:</span>
                    <span class="score-value" id="currentScore">0</span>
                </div>
                <div class="level-display">
                    <span class="level-label">Niveau:</span>
                    <span class="level-value" id="currentLevel">1</span>
                </div>
            </div>
            <div class="header-right">
                <a href="profile.php" class="btn btn-secondary">Profil</a>
                <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>
        
        <!-- Game Area -->
        <div class="game-main">
            <!-- Images Grid -->
            <div class="images-grid">
                <div class="image-container" id="img1">
                    <img id="image1" src="" alt="Image 1">
                </div>
                <div class="image-container" id="img2">
                    <img id="image2" src="" alt="Image 2">
                </div>
                <div class="image-container" id="img3">
                    <img id="image3" src="" alt="Image 3">
                </div>
                <div class="image-container" id="img4">
                    <img id="image4" src="" alt="Image 4">
                </div>
            </div>
            
            <!-- Controls -->
            <div class="game-controls">
                <div class="hint-box">
                    <button id="hintBtn" class="btn btn-info">💡 Indice</button>
                    <span id="hintText" class="hint-text"></span>
                </div>
                
                <div class="answer-input">
                    <input type="text" id="answerInput" placeholder="Écrivez votre réponse..." autocomplete="off">
                    <button id="submitBtn" class="btn btn-primary">Soumettre</button>
                </div>
                
                <div class="keyboard">
                    <div class="keyboard-row">
                        <button class="key" data-letter="A">A</button>
                        <button class="key" data-letter="B">B</button>
                        <button class="key" data-letter="C">C</button>
                        <button class="key" data-letter="D">D</button>
                        <button class="key" data-letter="E">E</button>
                        <button class="key" data-letter="F">F</button>
                    </div>
                    <div class="keyboard-row">
                        <button class="key" data-letter="G">G</button>
                        <button class="key" data-letter="H">H</button>
                        <button class="key" data-letter="I">I</button>
                        <button class="key" data-letter="J">J</button>
                        <button class="key" data-letter="K">K</button>
                        <button class="key" data-letter="L">L</button>
                    </div>
                    <div class="keyboard-row">
                        <button class="key" data-letter="M">M</button>
                        <button class="key" data-letter="N">N</button>
                        <button class="key" data-letter="O">O</button>
                        <button class="key" data-letter="P">P</button>
                        <button class="key" data-letter="Q">Q</button>
                        <button class="key" data-letter="R">R</button>
                    </div>
                    <div class="keyboard-row">
                        <button class="key" data-letter="S">S</button>
                        <button class="key" data-letter="T">T</button>
                        <button class="key" data-letter="U">U</button>
                        <button class="key" data-letter="V">V</button>
                        <button class="key" data-letter="W">W</button>
                        <button class="key" data-letter="X">X</button>
                    </div>
                    <div class="keyboard-row">
                        <button class="key" data-letter="Y">Y</button>
                        <button class="key" data-letter="Z">Z</button>
                        <button id="deleteBtn" class="key delete">⌫ Suppr</button>
                        <button id="clearBtn" class="key delete">✕ Effacer</button>
                    </div>
                </div>
                
                <div id="resultMessage" class="result-message"></div>
            </div>
        </div>
    </div>
    
    <script src="js/game.js"></script>
</body>
</html>
