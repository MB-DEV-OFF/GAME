#!/bin/bash

# Script d'installation du jeu 4 Images 1 Mot

echo "🎮 Installation du jeu 4 Images 1 Mot"
echo "======================================="
echo ""

# Vérifier PHP
echo "✓ Vérification de PHP..."
if ! command -v php &> /dev/null; then
    echo "✗ PHP n'est pas installé!"
    exit 1
fi
echo "  PHP version: $(php -v | head -n 1)"

# Vérifier MySQL
echo "✓ Vérification de MySQL..."
if ! command -v mysql &> /dev/null; then
    echo "✗ MySQL n'est pas installé!"
    exit 1
fi
echo "  MySQL installation détectée"

# Copier le fichier .env
echo "✓ Configuration de l'environnement..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "  Fichier .env créé. Veuillez le configurer avec vos paramètres."
else
    echo "  Fichier .env existe déjà"
fi

# Créer la base de données
echo "✓ Création de la base de données..."
read -p "  Utilisateur MySQL (défaut: root): " db_user
db_user=${db_user:-root}

read -sp "  Mot de passe MySQL: " db_password
echo ""

mysql -u "$db_user" -p"$db_password" < database/schema.sql 2>/dev/null
if [ $? -eq 0 ]; then
    echo "  Base de données créée avec succès!"
else
    echo "✗ Erreur lors de la création de la base de données"
    echo "  Assurez-vous que les identifiants MySQL sont corrects"
    exit 1
fi

# Définir les permissions
echo "✓ Configuration des permissions..."
chmod -R 755 public/
chmod -R 777 public/images/ 2>/dev/null

echo ""
echo "✅ Installation terminée!"
echo ""
echo "📝 Prochaines étapes:"
echo "  1. Éditez le fichier .env avec vos paramètres"
echo "  2. Obtenez une clé API sur https://unsplash.com/oauth/applications"
echo "  3. Lancez le serveur: php -S localhost:8000 -t public"
echo "  4. Accédez à http://localhost:8000"
echo ""
