# Etape 3 : Reverse proxy with apache (static configuration)

## Introduction

L'objectif de cette étape est de mettre en place un reverse proxy. Le reverse proxy sera sous la forme d'un conteneur qui run provenant d'une image Docker apache.
Nous démarrerons 3 conteneurs : le serveur statique, le serveur dynamic et le reverse proxy. Les conteneurs statiques et dynamiques ne peuvent pas être atteint directement depuis l'extérieur de la machine Docker : le reverse proxy est l'unique point d'entrée de l'infrastructure.

## Contenu

Le dossier apache-reverse-proxy contient un dossier conf/sites-available avec deux fichiers de configuration qui seront copié dans l'image Docker (voir Dockerfile). Le fichier 000-default.conf contient la configuration générale de l'image Docker et le fichiers 001-reverse-proxy.conf indique la configuration du serveur reverse proxy.

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

 ## Adaptation

 ## Tests