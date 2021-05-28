# Etape 4 : AJAX requests with JQuery

## Introduction

L'objectif de cette étape est d'implémenter une requête Ajax à l'aide de la librairie JQuery. 

Des requête Ajax sont envoyé en arrière plan depuis un client vers le serveur dynamique pour récupérer des données et mettre à jour la page statique. Un élément de la page statique sera régulièrement mis à jour et son texte est remplacé par des informations aléatoires sur un animal, généré par un script javascript. Nous créons ainsi une injection Ajax dans la page statique. 

Par rapport aux étapes précédentes, le contenu de l'image php a été changé dans le but d'avoir un site dont la structure facilite les injections Jquery et donc plus simple à gérer.

## Contenu

On ajoute un nouveau script javascript pour générer aléatoirement un tableau d'animaux, tel que décrit dans l'étape 2. Ce script se trouve à l'emplacement /apache-php-image/content/js/animals.js. On ajoute simplement au script la fonction setInterval permettant de de charger de nouvelles données aléatoires toutes les deux secondes.

On modifie aussi la page html se trouvant à l'emplacement /apache-php-image/content/index.html pour y ajouter une référence au script au bas de la page :

```
<script src="js/animals.js"></script>
```

## Dockerfile

Les dockerfiles n'ont pas été modifiés par rapport aux autres étapes. 

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

Le script animals.js est légèrement différent car on ne reçoit pas les mêmes informations du serveur dynamique que dans la démonstration et qu'on ne l'injecte pas au même endroit dans la page html.

## Tests

On lance les trois conteneurs.

On ouvre un navigateur web et on entre pour charger le site statique :

``` demo.res.ch:8080/```

La page contenant le site statique se charge normalement et le contenu se charge toutes les 2 secondes avec de nouvelles données aléatoires pour les animaux. 