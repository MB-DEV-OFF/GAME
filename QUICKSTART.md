# 🎮 Démarrage Rapide - 4 Images 1 Mot

## ⚡ En 5 minutes

### 1️⃣ Configuration de la base de données

```bash
# Créer la BD et les tables
mysql -u root -p < database/schema.sql
```

### 2️⃣ Configuration de l'environnement

```bash
# Copier .env
cp .env.example .env

# Éditer .env
nano .env
```

Remplir:
```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=votre_mot_de_passe
DB_NAME=game_4images
UNSPLASH_API_KEY=YOUR_KEY_HERE
```

### 3️⃣ Obtenir une clé Unsplash

1. Aller: https://unsplash.com/oauth/applications
2. Créer "New Application"
3. Copier **Access Key**
4. Coller dans `.env` → `UNSPLASH_API_KEY`

### 4️⃣ Lancer le serveur

```bash
cd GAME
php -S localhost:8000 -t public
```

### 5️⃣ Accéder au jeu

Ouvrir: http://localhost:8000

## 📂 Architecture rapide

```
GAME/
├── config/          ← BD et config
├── src/             ← Classes PHP (User, Game, UnsplashAPI)
├── api/             ← Endpoints JSON
├── public/          ← Interface web (HTML/CSS/JS)
└── database/        ← Schéma SQL
```

## 🎮 Flux du jeu

```
Login → Game Page → 4 Images + Keyboard → Submit Answer
                         ↓
                    ✅ Correct → +Points → Next Level
                    ❌ Wrong → Reveal Answer → Next Level
                         ↓
                    Profile → Stats + Leaderboard
```

## 🔑 Mots clés importantes

### Backend (PHP)
- **User::login()** - Authentification
- **Game::getRandomRiddle()** - Récupère énigme
- **Game::checkAnswer()** - Vérifie réponse
- **UnsplashAPI** - Images aléatoires

### Frontend (JS)
- **loadNewLevel()** - Charge un nouveau niveau
- **submitAnswer()** - Soumet la réponse
- **setupEventListeners()** - Clavier + boutons

### Base de données
- **users** - Profils joueurs
- **riddles** - Énigmes (word + 4 images)
- **user_progress** - Progression par énigme

## 🛠️ Troubleshooting

| Problème | Solution |
|----------|----------|
| "Erreur de connexion BD" | Vérifier `.env` credentials |
| "Images noires" | Vérifier clé Unsplash API |
| "Login ne fonctionne pas" | Vérifier sessions PHP activées |
| "Niveau ne charge pas" | Vérifier `api/getLevel.php` console |

## 📝 Personnalisation

### Ajouter des énigmes
```php
// Dans database/schema.sql, INSERT INTO riddles
INSERT INTO riddles VALUES (
    NULL, 'MOT', 'CATEGORIE', 
    'url1', 'url2', 'url3', 'url4', 
    'Indice', 1
);
```

### Changer les couleurs
Éditer `public/css/style.css` variables CSS:
```css
:root {
    --primary: #6366f1;      /* Couleur principale */
    --secondary: #8b5cf6;    /* Secondaire */
    ...
}
```

### Ajouter des catégories
Éditer `src/Game.php`:
```php
private $categories = [
    'ANIMALS', 'FRUITS', 'NATURE', 'SPORTS', 'FOOD', 
    'TECHNOLOGY', 'MUSIC', 'CINEMA'  // ← Ajouter
];
```

## 🚀 Avant le Production

```
✅ Tester avec plusieurs utilisateurs
✅ Vérifier sécurité (SQL injection, XSS)
✅ Ajouter HTTPS
✅ Rate limiting sur les APIs
✅ Backup régulier BD
✅ Monitoring des erreurs
✅ Optimiser les images
```

## 📞 Support

Pour des questions, consulter:
- `README.md` - Documentation complète
- `src/` - Code source commenté
- `api/` - Endpoints disponibles

---

**Bon jeu! 🎉**
