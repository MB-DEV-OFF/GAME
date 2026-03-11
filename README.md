# 4 Images 1 Mot - Jeu Web Interactif

Un jeu "4 Images 1 Mot" moderne avec des niveaux infinis, profil utilisateur, et classement global!

## 🎮 Caractéristiques

- ✅ **Authentification** - Système de login/inscription sécurisé
- 🎯 **Niveaux infinis** - Énigmes générées aléatoirement
- 📊 **Profil utilisateur** - Progression et statistiques
- 🏆 **Classement global** - Compétition entre joueurs
- 🖼️ **API Unsplash** - 4 images aléatoires par énigme
- 🎹 **Clavier virtuel** - Contrôle au clic ou clavier
- 📱 **Design responsif** - Compatible mobile et desktop

## 📋 Prérequis

- **PHP** 7.4+ 
- **MySQL** 5.7+
- **Apache** avec mod_rewrite activé
- **cURL** (pour l'API Unsplash)

## 🚀 Installation

### 1. Cloner le repo
```bash
cd /workspaces/GAME
```

### 2. Créer la base de données
```bash
mysql -u root < database/schema.sql
```

### 3. Configurer les variables d'environnement
```bash
cp .env.example .env
# Éditer .env avec vos paramètres
```

**Dans `.env`, configurer:**
```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=votre_mot_de_passe
DB_NAME=game_4images
UNSPLASH_API_KEY=votre_clé_api_unsplash
```

### 4. Obtenir une clé API Unsplash
1. Aller sur https://unsplash.com/oauth/applications
2. Créer une nouvelle application
3. Copier la clé d'accès
4. Ajouter dans `.env`

### 5. Lancer le serveur PHP
```bash
cd public
php -S localhost:8000
```

Accédez à: http://localhost:8000

## 📁 Structure du projet

```
GAME/
├── config/
│   ├── config.php          # Configuration générale
│   └── database.php        # Connexion BD
├── src/
│   ├── User.php           # Gestion utilisateurs
│   ├── Game.php           # Logique du jeu
│   └── UnsplashAPI.php    # Intégration Unsplash
├── api/
│   ├── getLevel.php       # Récupère un niveau
│   ├── checkAnswer.php    # Vérifie la réponse
│   ├── getProfile.php     # Profil utilisateur
│   └── getLeaderboard.php # Classement
├── public/
│   ├── index.php          # Page connexion/inscription
│   ├── game.php           # Page du jeu
│   ├── profile.php        # Page profil
│   ├── logout.php         # Déconnexion
│   ├── css/
│   │   └── style.css      # Styles
│   ├── js/
│   │   ├── auth.js        # Authentification JS
│   │   └── game.js        # Logique du jeu JS
│   └── images/            # Cache des images
├── database/
│   └── schema.sql         # Schéma BD
├── .env.example           # Variables d'env exemple
├── .htaccess              # Config Apache
└── README.md              # Ce fichier
```

## 🎮 Fonctionnement du jeu

### Page de connexion
- S'inscrire avec username, email, mot de passe
- Se connecter avec username et mot de passe
- Sessions sécurisées avec PHP

### Page du jeu
- **4 images** générées aléatoirement via Unsplash
- **Clavier virtuel** ou input texte
- **Indice** révélant partiellement le mot
- **Score** augmente avec chaque bonne réponse
- **Niveaux** augmentent avec la progression

### Page profil
- Statistiques personnelles
- Score actuel et meilleur score
- Taux de réussite
- Classement global
- Historique de progression

## 🔒 Sécurité

- ✅ Mots de passe hachés (bcrypt)
- ✅ Sessions PHP sécurisées
- ✅ Protection contre SQL injection
- ✅ Validation des entrées
- ✅ CSRF tokens (à ajouter si nécessaire)

## 🎯 Améliorations futures

- 🌍 Modes multijoueurs en temps réel
- 🎵 Catégories de musique/film
- 🏅 Badges et succès
- 💬 Système de chat
- 📈 Graphiques de progression
- 🌙 Mode sombre
- 🌐 Multilingue

## 📝 Licence

Voir fichier LICENSE

## 👨‍💻 Auteur

Créé avec ❤️ pour les amateurs de jeux

---

**Questions ou bugs?** Ouvrez une issue sur GitHub!
