# Projet_3_Currency-Converter
 
Projet 3 de la formation "Développeur Multimedia" à l'Ecole Multimedia.

Pour démarrer le projet, entrer les commandes suivantes :
    * Ouvrir un terminal dans le dossier currency-converter du dossier api :
        - npm install
        - php artisan migrate:fresh (Afin d'ajouter les tables à votre base de données. Bien penser à modifier le fichier .env en indiquant les infos de votre base)
        - php artisan db:seed --class=AdminSeeder (afin d'ajouter 1 administrateur à la base de données, permettant de tester les fonctionnalités du site)
        - php artisan db:seed --class=CurrencySeeder (Pour ajouter 3 devises à la base de données)
        - php artisan db:seed --class=PairSeeder (Pour ajouter 6 paires à la base de données)
        - php artisan serve (Permet de déployer l'api en local)
    
    * Ouvrir un deuxième terminal dans le dossier MoneyValue du dossier admin :
        - npm install
        - npm run dev (Permet de lancer l'interface administrateur en local)

Pour se connecter en tant qu'admin :

    nom : john
    mot de passe : password
