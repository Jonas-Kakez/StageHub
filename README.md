# StageHub

Plateforme web complète de gestion des stages académiques — Laravel 12, MySQL, Bootstrap 5.

## Fonctionnalités

- **Administrateur/Faculté** : validation entreprises, modération offres, gestion utilisateurs, départements, encadreurs, statistiques Chart.js
- **Entreprise** : inscription, offres de stage, candidatures, affectation stagiaires, évaluation
- **Étudiant** : recherche offres (domaine, compétence, localisation), candidatures, CV/lettre, rapport de stage
- **Département** : attribution encadreurs aux stagiaires
- **Encadreur** : suivi stagiaires, rapports, évaluation

## Stack technique

- Laravel 12
- MySQL
- Bootstrap 5
- Chart.js
- Notifications email + in-app

## Prérequis

- PHP 8.2+
- Composer
- MySQL 8+
- Extension PHP : pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo

## Installation rapide

```powershell
# 1. Créer la base MySQL
mysql -u root -e "CREATE DATABASE stagehub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Configurer .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 3. Exécuter le script d'installation
.\setup.ps1

# 4. Lancer le serveur
php artisan serve
```

Ouvrir http://localhost:8000

## Comptes de démonstration

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@stagehub.cd | password |
| Entreprise | entreprise@stagehub.cd | password |
| Étudiant | etudiant@stagehub.cd | password |
| Encadreur | encadreur@stagehub.cd | password |
| Département | departement@stagehub.cd | password |

## Structure MVC

```
app/
├── Http/Controllers/   # Contrôleurs par rôle (Admin, Entreprise, Etudiant...)
├── Models/             # User, Entreprise, Etudiant, OffreStage, Candidature...
├── Policies/           # Autorisations
├── Notifications/      # Notifications email
├── Services/           # NotificationService
database/migrations/    # Toutes les tables
resources/views/        # Vues Blade Bootstrap 5 (maquette StageHub)
routes/web.php          # Routes avec middleware role
```

## Entités principales

User, Entreprise, Etudiant, Departement, Encadreur, OffreStage, Candidature, Traitement, Affectation, RapportStage, Evaluation, AppNotification

## Localisation entreprises

Champs : adresse, ville, province, pays, latitude, longitude

## Licence

MIT
