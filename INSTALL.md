# Installation
Follow the steps for a regular Symfony existing project setup:
https://symfony.com/doc/current/setup.html#setting-up-an-existing-symfony-project
- Clone the project
```
  git clone ...
```
- Install dependencies
```
  composer install
```
- Configure database options in .env (SQLite is active by default)
- Run migrations
```
  php bin/console doctrine:migrations:migrate
``` 
- Install npm dependencies
```
  npm install --dev-save
```
- Run encore 
```
  npm run encore dev
```
