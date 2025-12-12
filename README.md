# Ecoride

## Contenue des dossier

* le dossiers bdd.Ecoride contiens des fichier eponymes contenant structures et données  
* Le dossier publique contient la vue navigateur qui renvoie les templates twig
* Le dossiers src renferme tout la logique du projet entité, controller etc...

Guide d'installation et de démarrage du projet Symfony `Ecoride`.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- MySQL 
- (Optionnel ) Symfony CLI (`symfony`)
- Node.js et `npm`  pour les assets front-end

Exécutez les commandes depuis la racine du projet : `cd /chemin/du/projet`.

## Installation

1. Installer les dépendances PHP :

```bash
composer install
```

2. Installer les dépendances JavaScript (si vous modifiez/compilez les assets) :

```bash
# avec npm
npm install
npm run dev


3. Configurer les variables d'environnement :

Copiez le fichier d'exemple et adaptez la valeur `DATABASE_URL` :

```bash
cp .env .env.local
# éditez .env.local et réglez DATABASE_URL
```

Exemples de `DATABASE_URL` :

```text
# MySQL
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/ecoride_db"

# SQLite (exemple)
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

## Créer la base de données et exécuter les migrations

Après avoir configuré `DATABASE_URL` :

```bash
# créer la base (si elle n'existe pas)
php bin/console doctrine:database:create

# exécuter les migrations
php bin/console doctrine:migrations:migrate
```


## Lancer le serveur

Symfony CLI :

```bash
symfony server:start 
# puis ouvrir http://127.0.0.1:8000
```


## Conseil d'usages 

- Pensez à configurer d'autres variables d'environnement (mailpit) dans `.env.local` si nécessaire.
- Si vous rencontrez des erreurs liées aux migrations ou à la base de données, vérifiez la valeur de `DATABASE_URL` et les droits d'accès de l'utilisateur DB.

- Exemple de trajets : 
 * Marseille - Paris 25/12/2025 places restante 2
 * Aix - Marseille 22/12/2025 places restante 3

- Exemple de user :
 * MaximilienpegasUS@hotmail.com mdp : 12345678