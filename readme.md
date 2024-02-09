# Ressource relationnel API

Il s'agit de l'api du projet ressource relationnel 

## Pré-requis

* Composer 
* PHP 8.2
* Symfony CLI

## Initialisation

```bash
composer install --ignore-platform-req=ext-sodium
```
```bash
php bin/console doctrine:database:create
```
```bash
php bin/console d:m:m
```
```bash
php bin/console make:migration
```
```bash
php bin/console d:m:m
```
```bash
php bin/console doctrine:fixtures:load
```
```bash
php bin/console lexik:jwt:generate-keypair
```
```bash
symfony server:start -d
```

### Local environment 

Copié coller le fichier ".env" et renommé le fichier copié en ".env.local" modifié l'addresse de la base de donné en fonction de votre environnement

## Utilisation

En allant sur la page 127.0.0.1:8000/api vous retrouverez l'entiereté des route API afin de les tester

## Auteur 

Major team
