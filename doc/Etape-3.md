# Etape 3 : Reverse proxy with apache (static configuration)

## Introduction

L'objectif de cette étape est de mettre en place un reverse proxy. Le reverse proxy sera sous la forme d'un conteneur qui run provenant d'une image Docker apache.

Nous démarrerons 3 conteneurs : le serveur statique, le serveur dynamic et le reverse proxy. Les conteneurs statiques et dynamiques ne peuvent pas être atteint directement depuis l'extérieur de la machine Docker : le reverse proxy est l'unique point d'entrée de l'infrastructure.

## Contenu

Le dossier apache-reverse-proxy contient un dockerfile et un dossier conf/sites-available avec deux fichiers de configuration qui seront copié dans l'image Docker (voir Dockerfile). Le fichier 000-default.conf contient la configuration générale de l'image Docker et le fichiers 001-reverse-proxy.conf indique la configuration du serveur reverse proxy.

## Dockerfile

Le dockerfile est le suivant : 

```
FROM php:7.2-apache

COPY conf/ /etc/apache2

RUN a2enmod proxy proxy_http  
RUN a2ensite 000-* 001-* 
```

On récupère tout d'abord l'image php apache de Docker hub dans sa version  7.2 qui contient un serveur apache déjà configuré pour gérer des pages php.
On copie ensuite le contenu du dossier conf contenant qui contient la configuration générale et du serveur reverse proxy dans le dossier /etc/apache2 de l'image Docker.

Le premier RUN active dans le conteneur les modules apache nécessaires au bon fonctionnement du serveur reverse proxy.
Le deuxième RUN active dans le conteneur tous les fichiers dans /etc/apache2/sites-available qui commencent par 000- ou 001- soit les fichiers de configuration générale et ceux du serveur reverse proxy.   


 ## Installation/Utilisation

 On s'assure qu'il n'y a aucun autre conteneur actif pour qu'au lancement des conteneurs qui vont suivre la distributions des adresse IP se fasse correctement tel que marqué dans le fichier de configuration. 
 
Dans un premier temps, on lance un conteneur de l'image Docker contenant le serveur statique :

```docker run -d res/apache_static```

On lance ensuite un conteneur de l'image Docker contenant le serveur dynamique :

```docker run -d res/express```

On se place à la racine du dossier de l'image Docker du serveur reverse proxy et on construit l'image avec la commande suivante :

`docker build -t res/apache_rp .` 

Enfin, on lance un conteneur de l'image Docker du serveur reverse proxy :

```docker run -p 8080:80 -d res/apache_rp```

On expose le port 8080 du conteneur sur le port 80 de la machine locale pour pouvoir y accéder depuis la machine locale et pouvoir tester plus tard dans le navigateur.

Nous avons donc maintenant trois conteneurs lancés. 

## Adaptation

Par rapport à la vidéo de présentation on prend la version 7.2 et non 5.6 de l'image Docker php pour avoir la version la plus récente de l'image. 

## Tests

On lance les trois conteneurs.

On ouvre un navigateur web et on entre pour charger le site statique :

``` demo.res.ch:8080/```

La page contenant le site statique se charge normalement.

Pour charger le contenu dynamique on entre :

``` demo.res.ch:8080/api/animals/```

Le tableau contenant un nombre aléatoire d'animaux se charge et les données ainsi que la taille du tableau varie aléatoirement quand on recharge la page.

Etant donné que les ports des serveurs statiques et dynamiques n'ont pas été exposés, on ne peut pas y accéder directement et on doit obligatoirement passer par le serveur reverse proxy.

Cette configuration est fragile car dès lors qu'on expose les ports des conteneurs des serveurs statiques et dynamiques, on peut de nouveau y accéder directement via un navigateur web comme aux étapes 1 et 2. 