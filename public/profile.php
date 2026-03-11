<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/User.php';
require_once __DIR__ . '/../src/Game.php';

// Rediriger si pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$database = new Database();
$user = new User($database);
$game = new Game($database);

$user_id = $_SESSION['user_id'];
$profile = $user->getProfile($user_id);
$stats = $game->getPlayerStats($user_id);
$leaderboard = $game->getLeaderboard(10);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - 4 Images 1 Mot</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="profile-container">
        <!-- Header -->
        <div class="game-header">
            <div class="header-left">
                <h1>🎮 4 Images 1 Mot</h1>
            </div>
            <div class="header-right">
                <a href="game.php" class="btn btn-primary">Jouer</a>
                <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>
        
        <!-- Profile Content -->
        <div class="profile-main">
            <!-- User Profile Card -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <span><?php echo strtoupper(substr($profile['username'], 0, 1)); ?></span>
                    </div>
                    <div class="profile-info">
                        <h2><?php echo htmlspecialchars($profile['username']); ?></h2>
                        <p><?php echo htmlspecialchars($profile['email']); ?></p>
                        <p class="member-since">Inscrit depuis <?php echo date('d/m/Y', strtotime($profile['created_at'])); ?></p>
                    </div>
                </div>
                
                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $profile['level']; ?></div>
                        <div class="stat-label">Niveau</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $profile['score']; ?></div>
                        <div class="stat-label">Score Actuel</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $profile['best_score']; ?></div>
                        <div class="stat-label">Meilleur Score</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $stats['completed_riddles'] ?? 0; ?></div>
                        <div class="stat-label">Énigmes Résolues</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $stats['total_attempts'] ?? 0; ?></div>
                        <div class="stat-label">Tentatives</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">
                            <?php 
                            $completion_rate = ($stats['total_attempts'] > 0) 
                                ? round(($stats['completed_riddles'] / $stats['total_attempts']) * 100) 
                                : 0;
                            echo $completion_rate;
                            ?>%
                        </div>
                        <div class="stat-label">Taux de Réussite</div>
                    </div>
                </div>
            </div>
            
            <!-- Leaderboard -->
            <div class="leaderboard-section">
                <h3>🏆 Classement des 10 Meilleurs</h3>
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Joueur</th>
                            <th>Niveau</th>
                            <th>Meilleur Score</th>
                            <th>Énigmes Résolues</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = 1;
                        foreach ($leaderboard as $player): 
                        ?>
                        <tr <?php echo ($player['username'] === $profile['username']) ? 'class="highlight"' : ''; ?>>
                            <td>
                                <?php 
                                if ($rank == 1) echo '🥇';
                                elseif ($rank == 2) echo '🥈';
                                elseif ($rank == 3) echo '🥉';
                                else echo $rank;
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($player['username']); ?></td>
                            <td><?php echo $player['level']; ?></td>
                            <td><?php echo $player['best_score']; ?></td>
                            <td><?php echo $player['total_wins']; ?></td>
                        </tr>
                        <?php 
                        $rank++;
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
