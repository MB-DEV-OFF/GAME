# ⚡ Prochaines étapes - Action immédiate

Ton jeu est prêt! Voici exactement quoi faire maintenant:

## 📋 Checklist d'action (ordre d'exécution)

### ✅ ÉTAPE 1: Configuration (5 min)

```bash
cd /workspaces/GAME

# 1a. Copier le fichier d'environnement
cp .env.example .env

# 1b. Éditer .env (remplacer les valeurs)
nano .env

# Remplacer:
# DB_USER=root (ou votre utilisateur)
# DB_PASSWORD=votre_mot_de_passe
# UNSPLASH_API_KEY=votre_clé_ici
```

### ✅ ÉTAPE 2: Obtenir clé Unsplash API (2 min)

1. Aller sur: https://unsplash.com/api/applications
2. Créer "New Application"
3. Accepter les conditions
4. Copier la **Access Key**
5. Coller dans `.env` → `UNSPLASH_API_KEY=`

### ✅ ÉTAPE 3: Créer la base de données (1 min)

```bash
# Vérifier que MySQL est lancé
mysql --version

# Créer BD et tables
mysql -u root -p < database/schema.sql

# Entrer votre mot de passe quand demandé
```

### ✅ ÉTAPE 4: Lancer le serveur (instant!)

```bash
# À partir du dossier GAME
php -S localhost:8000 -t public

# Devrait afficher:
# Server running at http://localhost:8000
```

### ✅ ÉTAPE 5: Accéder au jeu

Ouvrir navigateur:
```
http://localhost:8000
```

Vous devriez voir la page de login! 🎉

---

## 🧪 Test manuel

1. **S'inscrire**
   - Username: `testuser`
   - Email: `test@example.com`
   - Password: `password123`
   - Submit → Vous êtes inscrit! ✅

2. **Se connecter**
   - Username: `testuser`
   - Password: `password123`
   - Submit → Vous êtes connecté! ✅

3. **Jouer**
   - 4 images apparaissent
   - Cliquez sur les lettres ou tapez
   - Appuyez sur "Soumettre"
   - Devrait dire "Bonne réponse" ou "Mauvaise" ✅

4. **Voir profil**
   - Cliquez "Profil" en haut
   - Vous voyez vos stats
   - Classement avec autres joueurs ✅

---

## 🐛 Si ça ne fonctionne pas

### Erreur: "Erreur de connexion BD"
```bash
# Vérifier credentials dans .env
# Vérifier MySQL lancé: mysql -u root -p
# Vérifier BD créée: mysql -u root -p -e "SHOW DATABASES;"
# Refaire: mysql -u root -p < database/schema.sql
```

### Erreur: "Images noires/cassées"
```bash
# Vérifier clé Unsplash dans .env invalide
# Vérifier internet connecté
# Vérifier Unsplash API working: https://unsplash.com/api/applications
```

### Erreur: "Page blanche"
```bash
# Vérifier PHP version: php -v (besoin 7.4+)
# Vérifier curl activé: php -m | grep curl
# Vérifier erreurs: tail -f logs/error.log
```

### Erreur: "Port 8000 déjà utilisé"
```bash
# Utiliser port différent:
php -S localhost:8001 -t public
# Puis accéder: http://localhost:8001
```

---

## 📱 Tester sur téléphone

1. **Trouver IP locale**
   ```bash
   ipconfig getifaddr en0  # Mac
   # ou
   hostname -I             # Linux
   ```
   Exemple: `192.168.1.100`

2. **Lancer serveur accessible**
   ```bash
   php -S 0.0.0.0:8000 -t public
   ```

3. **Sur téléphone (même WiFi)**
   ```
   http://192.168.1.100:8000
   ```

---

## 🎮 Premiers pas de gameplay

1. **Première énigme**
   - Vous voyez 4 images
   - Avez un indice (ex: "Apple f****")
   - Tapez "APPLE" (majuscules ou minuscules)
   - ✅ Bonne réponse → +25 points

2. **Progression**
   - Score augmente
   - Niveau augmente tous les 5 succès
   - Meilleur score sauvegardé

3. **Classement**
   - Vous gagnez places
   - Compétition avec autres joueurs
   - Badges (prochainement)

---

## 🎯 Maintenant que le jeu fonctionne

### Option 1: Jouer et tester
```
Pas besoin de rien faire, c'est bon!
Rejoignez le jeu et amusez-vous 🎮
```

### Option 2: Ajouter vos énigmes
```bash
# Éditer database/schema.sql
# Ajouter des INSERT INTO riddles

INSERT INTO riddles VALUES (
    NULL, 'PIZZA', 'FOOD', 
    'url1', 'url2', 'url3', 'url4',
    'Italian dish', 1
);
```

### Option 3: Personnaliser
```bash
# Changez les couleurs dans public/css/style.css
:root {
    --primary: #FF6B6B;    # Votre couleur
    ...
}
```

### Option 4: Déployer en production
```bash
# Voir: DEVELOPER.md et README.md
# Guide complet pour AWS/Heroku/etc
```

---

## 📚 Ressources d'apprentissage

Si vous voulez modifier/améliorer le jeu:

1. **API Documentation**
   - Voir: `API.md`
   - Endpoints PHP expliqués
   - Exemples cURL

2. **Architecture**
   - Voir: `DEVELOPER.md`
   - Comment ajouter features
   - Conventions de code

3. **Code Source**
   - Voir: `src/`, `api/`, `public/`
   - Code commenté et clair
   - Facile à comprendre

---

## 🚀 Étapes suivantes (long terme)

Après avoir testé le jeu:

- [ ] Ajouter plus d'énigmes en BD
- [ ] Personnaliser couleurs/logo
- [ ] Tester avec 10+ utilisateurs
- [ ] Ajouter système de bonus
- [ ] Ajouter achievements
- [ ] Déployer en production
- [ ] Marketing & promouvoir
- [ ] Recueillir feedback utilisateurs
- [ ] Ajouter nouvelles features
- [ ] Monétiser (aucun paywall actuellement)

---

## 💬 Besoin d'aide?

1. **Problème courant?** → Voir section "Si ça ne fonctionne pas" ☝️
2. **Question API?** → Voir `API.md`
3. **Veux ajouter feature?** → Voir `DEVELOPER.md`
4. **Veux améliorer?** → Voir `TODO.md` pour idées

---

## ✅ Récapitulatif rapide

```console
cd /workspaces/GAME
cp .env.example .env
# Éditer .env avec credentials et Unsplash key
mysql -u root -p < database/schema.sql
php -S localhost:8000 -t public
# Ouvrir http://localhost:8000 → JOUER! 🎮
```

---

**Vous êtes prêt à jouer! Amusez-vous bien! 🚀**

*Questions? Consulter le README.md pour documentation complète.*
