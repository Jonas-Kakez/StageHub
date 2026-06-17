# StageHub - Script d'installation

Write-Host "=== StageHub - Installation ===" -ForegroundColor Cyan

# Vérifier PHP
$php = Get-Command php -ErrorAction SilentlyContinue
if (-not $php) {
    Write-Host "PHP non trouvé. Installation via winget..." -ForegroundColor Yellow
    winget install --id PHP.PHP.8.3 -e --accept-package-agreements --accept-source-agreements
    $env:Path = [System.Environment]::GetEnvironmentVariable("Path","Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path","User")
}

# Vérifier Composer
$composer = Get-Command composer -ErrorAction SilentlyContinue
if (-not $composer) {
    Write-Host "Composer non trouvé. Téléchargement..." -ForegroundColor Yellow
    Invoke-WebRequest -Uri "https://getcomposer.org/installer" -OutFile "composer-setup.php" -UseBasicParsing
    php composer-setup.php
    Remove-Item composer-setup.php
    $composerCmd = "php composer.phar"
} else {
    $composerCmd = "composer"
}

# Installer dépendances
Write-Host "Installation des dépendances..." -ForegroundColor Green
if ($composerCmd -eq "composer") {
    composer install --no-interaction
} else {
    php composer.phar install --no-interaction
}

# Configuration .env
if (-not (Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    Write-Host ".env créé depuis .env.example" -ForegroundColor Green
}

# Générer clé
php artisan key:generate --force

# Créer la base de données MySQL (optionnel)
Write-Host "Assurez-vous que MySQL est lancé et que la base 'stagehub' existe." -ForegroundColor Yellow
Write-Host "CREATE DATABASE stagehub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" -ForegroundColor Gray

# Migrations et seeders
php artisan migrate --seed --force

# Lien storage
php artisan storage:link

Write-Host ""
Write-Host "=== Installation terminée ! ===" -ForegroundColor Green
Write-Host ""
Write-Host "Comptes de démonstration (mot de passe: password):" -ForegroundColor Cyan
Write-Host "  Admin:       admin@stagehub.cd"
Write-Host "  Entreprise:  entreprise@stagehub.cd"
Write-Host "  Étudiant:    etudiant@stagehub.cd"
Write-Host "  Encadreur:   encadreur@stagehub.cd"
Write-Host "  Département: departement@stagehub.cd"
Write-Host ""
Write-Host "Lancer le serveur: php artisan serve" -ForegroundColor Yellow
Write-Host "URL: http://localhost:8000" -ForegroundColor Yellow
