# 🚀 Roadmap & Améliorations futures

## Phase 1: MVP (✅ Complété)

- [x] Authentification (login/signup)
- [x] Page du jeu avec 4 images
- [x] Système de points
- [x] Niveaux infinis
- [x] Profil utilisateur
- [x] Classement global
- [x] Intégration Unsplash API

## Phase 2: Gameplay Avancé (👷 En cours)

- [ ] Système de vies/erreurs
- [ ] Timer par énigme
- [ ] Bonus (x2 points, indice gratuit)
- [ ] Malus (temps écourté)
- [ ] Streaks (victoires consécutives)
- [ ] Achievements/Badges
- [ ] Modes de jeu (Classic, Hardcore, Zen)

## Phase 3: Social Features

- [ ] Système d'amis
- [ ] Défis amis
- [ ] Chat en direct
- [ ] Partage scores
- [ ] Notifications
- [ ] Profils publics

## Phase 4: Contenu & Monétisation

- [ ] Packs d'énigmes (par catégorie)
- [ ] Campagnes (story)
- [ ] Event limités (saisonnier)
- [ ] Skins personnalisés
- [ ] Astore in-game
- [ ] Publicités (non-intrusive)

## Phase 5: Optimisations

- [ ] PWA (installable)
- [ ] Offline mode
- [ ] Synchronisation cloud
- [ ] Animations avancées
- [ ] Multtilangue (i18n)
- [ ] Analytics avancée

---

## Bugs à corriger

- [ ] Image Unsplash qui ne charge parfois
- [ ] Lag lors du changement de niveau
- [ ] Session timeout non géré
- [ ] Validation email réelle

---

## Performance

### À optimiser

- [ ] Cache leaderboard (5 min)
- [ ] Lazy load images
- [ ] Minify CSS/JS
- [ ] Compression GZIP
- [ ] CDN pour images
- [ ] Index BD supplémentaires

### Métriques visées

- Page load: < 2s
- Game load: < 1s
- Leaderboard: < 500ms
- API response: < 200ms

---

## Sécurité à renforcer

- [ ] Rate limiting (5 requests/sec)
- [ ] CSRF tokens
- [ ] Password reset token
- [ ] Session security (secure flag)
- [ ] Input validation plus strict
- [ ] HTTPS obligatoire

---

## Tech Debt

- [ ] Refactorer Game.php (trop gros)
- [ ] Ajouter unit tests
- [ ] Documentation code
- [ ] Utiliser traits pour code réutilisable
- [ ] Migration vers PDO (sécurité)
- [ ] Logging centralisé

---

## Infrastructure

- [ ] Docker setup
- [ ] CI/CD pipeline (GitHub Actions)
- [ ] Monitoring (Sentry, DataDog)
- [ ] Backup automatique
- [ ] Load testing
- [ ] Staging environment

---

## Expansion mobile

- [ ] App iOS (React Native)
- [ ] App Android (Java)
- [ ] Synchronisation cross-platform
- [ ] Push notifications
- [ ] Offline gameplay

---

## Données & Analytics

- [ ] Dashboard admin
- [ ] Statistiques gameplay
- [ ] Heatmap d'utilisation
- [ ] A/B testing framework
- [ ] User retention tracking
- [ ] Revenue analytics

---

## Community Features

- [ ] Forum de discussions
- [ ] Créateur de contenu
- [ ] User-generated énigmes
- [ ] Voting système
- [ ] Leaderboards régionaux
- [ ] Streaming (Twitch integration)

---

## Priorité d'implémentation

### 1. Critique (Semaine 1)
```
[ ] Tests de sécurité
[ ] Rate limiting
[ ] Better image loading
```

### 2. Important (Semaine 2-3)
```
[ ] Système de timer
[ ] Achievements
[ ] Bonus/Malus
```

### 3. Nice-to-have (Après)
```
[ ] Chat
[ ] PWA
[ ] Analytics avancée
```

---

## Estimations

| Feature | Effort | Impact |
|---------|--------|--------|
| Timer | 2h | Haute |
| Achievements | 4h | Moyenne |
| Friends | 8h | Haute |
| Chat | 6h | Basse |
| PWA | 4h | Moyenne |
| Mobile App | 40h | Critique |
| Skins | 6h | Basse |

---

## Notes

- L'API Unsplash peut être lente, considérer cache
- Mobile design nécessite optimisations
- Scaling BD avec +10k users
- Coûts Unsplash API à vérifier (free tier: 50 req/hour)

---

Dernière année à jour: 2024-03-10

**Discussional:** Pour des suggestions, créer une issue GitHub!
