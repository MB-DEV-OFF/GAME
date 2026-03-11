# 📡 Documentation API

## Endpoints disponibles

### 🎮 GET `/api/getLevel.php`
Récupère une énigme aléatoire

**Authentification:** Requise (session)

**Réponse:**
```json
{
  "success": true,
  "riddle": {
    "id": 1,
    "word": "APPLE",
    "images": [
      "https://images.unsplash.com/...",
      "https://images.unsplash.com/...",
      "https://images.unsplash.com/...",
      "https://images.unsplash.com/..."
    ],
    "hint": "Fruit r* *****"
  }
}
```

---

### ✅ POST `/api/checkAnswer.php`
Vérifie une réponse

**Authentification:** Requise (session)

**Body:**
```json
{
  "answer": "APPLE",
  "correct_word": "APPLE",
  "riddle_id": 1
}
```

**Réponse (succès):**
```json
{
  "success": true,
  "correct": true,
  "points": 25,
  "message": "Bravo! Bonne réponse!"
}
```

**Réponse (erreur):**
```json
{
  "success": true,
  "correct": false,
  "points": 0,
  "message": "Mauvaise réponse, essaye encore!"
}
```

---

### 👤 GET `/api/getProfile.php`
Récupère le profil utilisateur

**Authentification:** Requise (session)

**Réponse:**
```json
{
  "success": true,
  "user": {
    "id": 1,
    "username": "john_doe",
    "email": "john@example.com",
    "level": 5,
    "score": 450,
    "best_score": 1200,
    "total_wins": 25,
    "created_at": "2024-03-10 10:30:00",
    "updated_at": "2024-03-10 15:45:00"
  }
}
```

---

### 🏆 GET `/api/getLeaderboard.php`
Récupère le classement

**Authentification:** Non requise

**Réponse:**
```json
{
  "success": true,
  "leaderboard": [
    {
      "username": "ProPlayer",
      "level": 20,
      "score": 5000,
      "best_score": 8500,
      "total_wins": 150
    },
    ...
  ]
}
```

---

## Classes PHP

### `User` - `/src/User.php`

```php
// Authentification
User::register($username, $email, $password)
User::login($username, $password)

// Profil
User::getProfile($user_id)

// Progression
User::updateProgress($user_id, $points)
User::updateBestScore($user_id, $score)
```

### `Game` - `/src/Game.php`

```php
// Énigmes
Game::getRandomRiddle()
Game::generateLevel($user_id)

// Vérification
Game::checkAnswer($user_id, $answer, $correct_word, $riddle_id)

// Statistiques
Game::getPlayerStats($user_id)
Game::getLeaderboard($limit)
```

### `UnsplashAPI` - `/src/UnsplashAPI.php`

```php
// Images
UnsplashAPI::getRandomImages($query, $count)
UnsplashAPI::getImagesByCategory($category)
UnsplashAPI::cacheImage($imageUrl, $filename)
```

---

## Fonctions JavaScript

### `game.js`

```javascript
// Initialisation
loadGameStats()           // Charge profil utilisateur
loadNewLevel()            // Récupère une énigme
setupEventListeners()     // Configure clavier + boutons

// Gameplay
submitAnswer()            // Soumet la réponse
checkAnswer()             // Vérifie réponse (via API)
addLetterToInput(letter)  // Ajoute une lettre
deleteLastLetter()        // Supprime dernière lettre
clearAnswerInput()        // Efface input

// UI
showHint()                // Affiche indice
showMessage(msg, type)    // Affiche message
updateScoreDisplay()      // Met à jour score
displayImages(urls)       // Affiche 4 images
```

### `auth.js`

```javascript
toggleAuthForm()          // Bascule login/register
```

---

## Codes d'erreur

| Code | Message | Cause |
|------|---------|-------|
| 401 | Non authentifié | Session expirée ou non connecté |
| 400 | Données manquantes | Champs vides ou invalides |
| 500 | Erreur serveur | Problème BD ou API Unsplash |

---

## Exemples cURL

### Vérifier une réponse
```bash
curl -X POST http://localhost:8000/../api/checkAnswer.php \
  -H "Content-Type: application/json" \
  --cookie "PHPSESSID=abc123" \
  -d '{
    "answer": "APPLE",
    "correct_word": "APPLE",
    "riddle_id": 1
  }'
```

### Récupérer le classement
```bash
curl http://localhost:8000/../api/getLeaderboard.php
```

---

## Codes de réponse HTTP

- **200** - Succès
- **400** - Erreur client (données invalides)
- **401** - Non authentifié
- **500** - Erreur serveur

---

## Notes de sécurité

- ✅ Mots de passe SHA256 (bcrypt)
- ✅ SQL Injection prévenue (prepared statements)
- ✅ XSS prévenue (htmlspecialchars)
- ⚠️ À ajouter: Rate limiting, CSRF tokens, HTTPS

---

Dernière mise à jour: 2024-03-10
