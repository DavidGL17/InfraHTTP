# Etape 1 : Image Apache static

## Introduction 

Ce dossier contient une image Docker faisant office de serveur pour lancer un site statique. On utilise un serveur apache httpd "dockerisé" servant du contenu statique. La structure du site se trouve dans le dossier content et est modifiable par l'utilisateur. Toute modification à l'extérieur du dossier content n'impactera pas l'image php, sauf sur le fichier Dockerfile.  

## Contenu

Le dossier apache-php-images contient un fichier Dockerfile pour build l'image Docker et un dossier content modifiable qui contient la structure du site web statique. Le site statique est tiré du site : https://startbootstrap.com/themes/landing-pages avec le thème suivant : https://startbootstrap.com/theme/agency . 
 Dans ce sous-dossier content on retrouve la page web principale index.html et des sous-dossiers contenant les images, les feuilles de style CSS et les scripts javascript se trouvant sur cette page web. 

 ## Dockerfile

 Le dockerfile est le suivant :

```
FROM php:7.2-apache
COPY content/ /var/www/html/
```

On récupère tout d'abord l'image php apache de Docker hub dans sa version 7.2 qui contient un serveur apache déjà configuré pour gérer des pages php. 
On copie ensuite le contenu du dossier content décrit ci-dessus contenant les informations liées au site statique dans le dossier /var/www/html/ de l'image Docker. 

## Installation/Utilisation

Se placer à la racine du dossier de l'image et construire l'image Docker  avec la commande :

`docker build -t res/apache_static .` 

On peut ensuite lancer un conteneur :

```docker run -p 8080:80 -d res/apache_static```

On expose le port 8080 du conteneur sur le port 80 de la machine locale pour pouvoir y accéder depuis la machine locale et pouvoir tester plus tard dans le navigateur.


## Adaptation

Par rapport à la vidéo de présentation on prend la version 7.2 et non 5.6 de l'image Docker php pour avoir la version la plus récente de l'image. 

## Tests

On ouvre un navigateur web et on entre :

``` localhost:8080``` 

La page se charge normalement. 

On entre dans le conteneur docker en fonctionnement  avec la commande :

```docker exec -it <nom_conteneur> /bin/bash```

puis on navigue jusqu'au dossier var/www/html pour modifier le fichier index.html avec nano. On rafraîchit ensuite la page statique dans le navigateur web et on vérifie que les modifications se font bien, ce qui est le cas. 

Pour pouvoir éditer des fichiers dans le conteneur qui run, on y installe nano une fois entré dans conteneur : 

```
apt-get update && \ 
   apt-get install -y nano
```

