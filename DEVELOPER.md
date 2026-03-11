# 🛠️ Guide Développeur

## Convention de code

### PHP
- **PSR-12** pour le style
- **Namespaces** pour les classes
- **Type hints** encouragés (PHP 7.4+)

```php
<?php
namespace Game;

class MyClass {
    public function myMethod(string $param): bool {
        // code
    }
}
```

### JavaScript
- **ES6+** moderne
- **Camel Case** pour les variables
- **Snake_case** pour les clés JSON

```javascript
const loadGameStats = () => {
    // code
};
```

### Nommage des fichiers
- Classes: `PascalCase.php` → `User.php`, `Game.php`
- Fonctions: `camelCase.php` → `helpers.php`
- Pages: `lowercase.php` → `index.php`, `game.php`

---

## Architecture MVC-like

```
Model (src/)        ← Business logic
    ↓
Controller (api/)   ← API endpoints
    ↓
View (public/)      ← HTML/CSS/JS (frontend)
```

### Flux de requête

```
User Input (JS)
    ↓
AJAX Call (game.js)
    ↓
API Endpoint (api/checkAnswer.php)
    ↓
Game Class (src/Game.php)
    ↓
Database Update
    ↓
JSON Response
    ↓
JS Update DOM
```

---

## Ajouter une nouvelle fonctionnalité

### Exemple: Système de bonus

#### 1️⃣ Model (`src/Game.php`)
```php
public function applyBonus($user_id, $bonus_type) {
    // Logique du bonus
}
```

#### 2️⃣ API Endpoint (`api/applyBonus.php`)
```php
require_once '../src/Game.php';
$game = new Game($database);
$result = $game->applyBonus($_SESSION['user_id'], $_POST['bonus']);
echo json_encode($result);
```

#### 3️⃣ Frontend (`public/js/game.js`)
```javascript
function activateBonus(type) {
    fetch('../api/applyBonus.php', {
        method: 'POST',
        body: JSON.stringify({bonus: type})
    }).then(/* handle response */);
}
```

---

## Tests manuels

### Checklist avant release

- [ ] Créer compte utilisateur
- [ ] Se connecter
- [ ] Jouer 5 niveaux
- [ ] Vérifier score augmente
- [ ] Vérifier images chargent
- [ ] Consulter profil
- [ ] Vérifier classement
- [ ] Se déconnecter
- [ ] Test sur mobile

### Debug mode

Activer dans `config/config.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');
```

---

## Performance

### Optimisations faites
- ✅ Index BD sur usernames, emails
- ✅ Lazy loading des images
- ✅ Queries optimisées (LIMIT, SELECT spécifique)

### À améliorer
- ⏳ Cache pour le classement (Redis)
- ⏳ Pagination du leaderboard
- ⏳ Minification CSS/JS
- ⏳ Compression GZIP

---

## Sécurité

### Vulnérabilités évitées
- ✅ SQL Injection: `real_escape_string` + Prepared Statements
- ✅ XSS: `htmlspecialchars` sur les outputs
- ✅ CSRF: Sessions PHP natives

### À améliorer
```php
// À ajouter:
- CSRF Tokens
- Rate Limiting
- Password Reset Token
- 2FA (Two-Factor Auth)
- John/John Prevention
```

### Exemple CSRF Token

```html
<!-- Dans le formulaire -->
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?>">
```

```php
// Validation
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF validation failed');
}
```

---

## Déploiement

### Production Checklist

```bash
# 1. Vérifier config
- Modifier .env avec prod credentials
- Désactiver error_reporting
- Configurer HTTPS

# 2. Base de données
- Backup avant migration
- Vérifier permissions utilisateur BD

# 3. Sécurité
- Changer SECRET_KEY
- Activer HTTPS/SSL
- Configurer firewall

# 4. Performance
- Activer cache navigateur
- Minifier CSS/JS
- Optimiser images

# 5. Monitoring
- Logs erreurs (Sentry)
- Monitoring BD (Datadog)
- Alertes (Slack)
```

### Commandes déploiement

```bash
# Production
php -S 0.0.0.0:8000 -t public

# Meilleur: Nginx + PHP-FPM
# ou Apache + mod_php
```

---

## Structure BD Avancée

### Ajouter une table de stats

```sql
CREATE TABLE user_stats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    games_played INT DEFAULT 0,
    avg_time INT DEFAULT 0,
    longest_streak INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Migration depuis une BD existante

```php
// Créer un script de migration simple
$sql = file_get_contents('database/migrations/001_add_stats.sql');
$db->query($sql);
```

---

## Logs et debugging

### Sauvegarder les logs
```php
// Dans config/database.php
function log_error($message) {
    $log_file = __DIR__ . '/../logs/error.log';
    error_log("[" . date('Y-m-d H:i:s') . "] " . $message . "\n", 3, $log_file);
}
```

### Utiliser les logs
```php
log_error("User $user_id submitted answer: $answer");
```

---

## Contribution

### Processus

1. Fork le repo
2. Créer une branche: `git checkout -b feature/nom`
3. Commit les changes: `git commit -am 'Add feature'`
4. Push: `git push origin feature/nom`
5. Ouvrir Pull Request

### Style du commit

```
[TYPE] Description courte

Description longue si nécessaire
- Point 1
- Point 2

Fixes #123
```

Types: `[FEAT]`, `[FIX]`, `[DOCS]`, `[STYLE]`, `[REFACTOR]`, `[PERF]`, `[TEST]`

---

## Ressources utiles

- PHP Manual: https://www.php.net/manual/
- MySQL Docs: https://dev.mysql.com/doc/
- Unsplash API: https://unsplash.com/api
- MDN Web Docs: https://developer.mozilla.org/
- Security: https://owasp.org/

---

Dernière mise à jour: 2024-03-10
