# Etape 2 : Dynamic HTTP server with express.js

## Introduction

Dans cette étape on écrit une application web dynamique qui retourne en plus du contenu html des données. Pour cela nous utilisons Node.js qui effectue la communication http et qui va fournir des données json aux différents clients.

Ce dossier contient une image Docker faisant office de serveur pour lancer un site dynamique. On utilise un serveur apache httpd "dockerisé" servant du contenu dynamique.

## Contenu

Le dossier express-images contient un fichier Dockerfile pour build l'image Docker. On y trouve également un dossier src contenant le script javascript et les fichiers package indiquant les paquets nécessaires à installer à Node ainsi qu'un autre dossier nodes_modules contenant tous les paquets Node. 
Le script index.js génère un tableau contenant des informations sur des animaux. Le nombre d'animaux du tableau est généré aléatoirement entre 0 et 10. Les informations données sur les animaux sont l'espèce, l'année de naissance et le nom. Ces données aléatoire sont générées grâce à Chance qui est un générateur aléatoire de données définies. Pour pouvoir utiliser Chance on l'ajoute simplement au fichier package-lock.json.

 ## Dockerfile

 ```
FROM node:14.16.1
COPY src /opt/app
CMD ["node", "/opt/app/index.js"]
 ```

 On récupère tout d'abord l'image node de Docker hub dans sa version 14.16.1. On utilise une version stable de Node.js.  

 ## Installation/Utilisation

Se placer à la racine du dossier de l'image et construire l'image Docker  avec la commande :

`docker build -t res/express .` 

On peut ensuite lancer un conteneur :

```docker run -p 8080:3000 -d res/express```

On expose le port 8080 du conteneur sur le port 3000 de la machine locale pour pouvoir y accéder depuis la machine locale et pouvoir tester plus tard dans le navigateur.

 ## Adaptation

Par rapport à la vidéo de présentation on prend la version 14.16.1 de l'image Docker node et non 4.4 pour avoir une version plus récente de l'image.

 ## Tests

On ouvre un navigateur web et on entre :

``` localhost:8080``` 

Le tableau d'animaux s'affiche et quand on rafraîchit le tableau se remplit avec de nouvelles valeurs aléatoires. Le nombre d'animaux varie aussi aléatoirement entre 0 et 10. 

On entre dans le conteneur docker en fonctionnement  avec la commande :

```docker exec -it <nom_conteneur> /bin/bash```

puis on navigue jusqu'au dossier /opt/app pour modifier le fichier index.js avec nano. On rafraîchit ensuite la page statique dans le navigateur web et on vérifie que les modifications se font bien, ce qui est le cas. 

Pour pouvoir éditer des fichiers dans le conteneur qui run, on y installe nano une fois entré dans conteneur : 

```
apt-get update && \ 
   apt-get install -y nano
```

