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

 On récpuère tout d'abord l'image node de Docker hub dans sa version 14.16.1. On utilise une version stable de Node.js.  

 ## Installation/Utilisation

 ## Adaptation

 ## Tests