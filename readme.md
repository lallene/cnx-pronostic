# ⚽ CNX Pronostic FIFA 2026™

Plateforme de pronostics football avec :
- Classement temps réel
- Gamification XP
- Système de badges
- Duels entre joueurs
- Classement par services
- Coefficients de difficulté des matchs
- Administration complète des matchs et résultats

---

# 🚀 Installation complète du projet

## 1. Cloner le projet

```bash
git clone https://github.com/lallene/cnx-pronostic.git
```

---

## 2. Entrer dans le dossier

```bash
cd cnx-pronostic/application
```

---

## 3. Installer les dépendances PHP

```bash
composer install
```

---

## 4. Installer les dépendances Node.js

```bash
npm install
```

---

## 5. Copier le fichier .env

```bash
cp .env.example .env
```

Windows :

```bash
copy .env.example .env
```

---

# ⚙️ Configuration .env

Modifier :

```env
APP_NAME=CNX-Pronostic
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1/cnx-pronostic.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=football_prediction
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 6. Générer la clé Laravel

```bash
php artisan key:generate
```

---

## 7. Créer la base de données

Créer une base :

```txt
football_prediction
```

dans :
- phpMyAdmin
- MySQL Workbench
- HeidiSQL
- etc.

---

## 8. Lancer les migrations

```bash
php artisan migrate
```

---

# 🌱 Seeders

## 9. Créer les admins

```bash
php artisan db:seed --class=AdminSeeder
```

---

## 10. Créer les équipes

```bash
php artisan db:seed --class=TeamSeeder
```

---

## 11. Générer les matchs FIFA 2026

```bash
php artisan db:seed --class=WorldCup2026MatchSeeder
```

---

## 12. Générer les utilisateurs

```bash
php artisan db:seed --class=UserSeeder
```

## 12. attribuer les avatars

```bash
php artisan db:seed --class=UserAvatarSeeder
```

```bash
php artisan db:seed --class=UserSeeder
```

---

## 13. Générer les pronostics automatiques

```bash
php artisan db:seed --class=PredictionSeeder
```

---

## 14. Générer les résultats

```bash
php artisan db:seed --class=ResultatSeeder
```

---

# 🏆 Recalcul des scores

## 15. Rebuild du classement

```bash
php artisan scores:rebuild
```

---

# 🎨 Assets Frontend

## 16. Compiler les assets

Développement :

```bash
npm run dev
```

Production :

```bash
npm run prod
```

---

# ▶️ Lancer le projet

## 17. Démarrer Laravel

```bash
php artisan serve
```

---

# 🔗 URLs importantes

## Accueil

```txt
http://127.0.0.1:8000
```

## Guide utilisateur

```txt
/guide
```

## Classement

```txt
/classement
```

## Duels

```txt
/duels
```

## Administration

```txt
/admin
```

---

# 🎮 Fonctionnalités principales

## ⚽ Pronostics

- Pronostics avant les matchs
- Match nul disponible
- Modification avant coup d’envoi

---

## 🏆 Classement

- Classement général
- Classement par service
- Classement live
- Scores pondérés

---

## 🔥 Coefficients

Les matchs importants rapportent plus :

| Type | Coefficient |
|---|---|
| Standard | x1 |
| Difficile | x2 |
| Gros choc | x3 |
| Finale | x5 |

---

## ⚡ XP & Gamification

- XP gagnés sur les bons pronostics
- Niveaux
- Streaks
- Badges
- Historique

---

## ⚔️ Duels

- Défis entre collègues
- Mise XP
- Jackpot
- Historique des combats

---

# 🏅 Badges disponibles

- 🎯 Premier Pronostic
- 🔥 Hot Streak
- ⚡ Master Predictor
- 🏆 Elite Predictor
- 👑 Legend
- 🥇 Top 1
- ⚔️ Duel Winner
- 💀 Risk Taker
- 🚀 XP Hunter
- 🧠 Football Analyst
- 🌍 World Champion
- 🎖️ Veteran

---

# 🛠️ Technologies utilisées

## Backend

- Laravel 8
- PHP 8
- MySQL

## Frontend

- Blade
- Bootstrap
- jQuery
- DataTables
- AJAX

## Gamification

- XP system
- Live ranking
- Badges
- Streaks
- Weighted scoring

---

# 📦 Commandes utiles

## Vider le cache

```bash
php artisan optimize:clear
```

---

## Relancer les scores

```bash
php artisan scores:rebuild
```

---

## Réinitialiser la base

```bash
php artisan migrate:fresh --seed
```

---

# 👨‍💻 Auteur

Développé par :

**Cedric Lallene**
Concentrix • Game Changer • FIFA World Cup 2026™

---

# 📄 Licence

Projet privé interne Concentrix.