CREATE DATABASE IF NOT EXISTS game_4images;
USE game_4images;

-- Table utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    level INT DEFAULT 1,
    score INT DEFAULT 0,
    best_score INT DEFAULT 0,
    total_wins INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table énigmes/niveaux
CREATE TABLE IF NOT EXISTS riddles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    word VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image1_url VARCHAR(500) NOT NULL,
    image2_url VARCHAR(500) NOT NULL,
    image3_url VARCHAR(500) NOT NULL,
    image4_url VARCHAR(500) NOT NULL,
    hint VARCHAR(255),
    difficulty INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table progression utilisateur
CREATE TABLE IF NOT EXISTS user_progress (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    riddle_id INT NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    attempts INT DEFAULT 0,
    time_spent INT DEFAULT 0,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (riddle_id) REFERENCES riddles(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_riddle (user_id, riddle_id)
);

-- Table sessions
CREATE TABLE IF NOT EXISTS sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45),
    user_agent VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Index pour performance
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_riddles_category ON riddles(category);
CREATE INDEX idx_user_progress_user ON user_progress(user_id);
CREATE INDEX idx_sessions_token ON sessions(session_token);

-- Données initiales d'énigmes
INSERT INTO riddles (word, category, image1_url, image2_url, image3_url, image4_url, hint, difficulty) VALUES
('APPLE', 'FRUITS', 'https://images.unsplash.com/photo-1560806887-1295cbd153f3?w=500', 'https://images.unsplash.com/photo-1560806887-1295cbd153f3?w=500', 'https://images.unsplash.com/photo-1560806887-1295cbd153f3?w=500', 'https://images.unsplash.com/photo-1560806887-1295cbd153f3?w=500', 'Fruit rouge classique', 1),
('CAT', 'ANIMALS', 'https://images.unsplash.com/photo-1574158622682-e40e69881006?w=500', 'https://images.unsplash.com/photo-1574158622682-e40e69881006?w=500', 'https://images.unsplash.com/photo-1574158622682-e40e69881006?w=500', 'https://images.unsplash.com/photo-1574158622682-e40e69881006?w=500', 'Animal domestique miaule', 1),
('TREE', 'NATURE', 'https://images.unsplash.com/photo-1511379938547-c1f69b13d835?w=500', 'https://images.unsplash.com/photo-1511379938547-c1f69b13d835?w=500', 'https://images.unsplash.com/photo-1511379938547-c1f69b13d835?w=500', 'https://images.unsplash.com/photo-1511379938547-c1f69b13d835?w=500', 'Grand végétal avec branches', 1);
