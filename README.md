# 1. InfraHTTP

## 1.1. Introduction

...

Chaque image est décrite plus précisément dans un fichier markdown situé a la racine du dossier de l'image : 

- [Image statique](docker-images/apache-php-image/apache-static.md)
- [Image dynamique](docker-images/expressImage/express-dynamic.md)
- [Image serveur reverse proxy](docker-images/apache-reverse-proxy/apache-reverse-proxy.md)

## 1.2. Features

En utilisant les 3 images que nous avons developpé notre interrface permet : 

- D'offrir un site statique, qui peut être hebergé sur un ou plusieurs serveurs afin de repartir la charge
- D'offrir un site qui fournit du contenu dynamique. Ce site est actuellement utilisé dans le site static pour rafraichir continuellement la page. 
- D'offrir un serveur reverse proxy, qui est capable de faire du load-balancing sur les différents serveurs disponibles, avec une implémentation en forme de sticky-session pour les serveurs statiques et round-robin pour les serveurs dynamiques.
- D'offrir une structure complétement modulable, qui peut être personalisée pour satifaire différents besoins.

## 1.3. Installation/Utilisation

Les instructions suivantes permettent de créer les différentes images que nous proposons, puis de lancer 2 containers a partir de l'image static, 2 à partir de l'image dynamic et un container qui sert de reverse_proxy. Si vous souhaitez avoir plus de serveurs d'un certain type, changer le host du site, changer le contenu d'un des deux sites,... lisez la documentation qui se trouve dans les fichiers md de chaque image.

Pour build les 3 images de l'infrastructure, il faut exécuter le script build-images :

```bash
./build-images.sh
``` 

Puis en exécutant le script start_containers vous pourrez lancer les 4 containers statiques et dynamiques de l'infrastructure : 

```bash
./start_containers.sh
```

Il ne suffit plus qu'à lancer le container du reverse proxy pour que l'infrastructure soit fonctionnelle. 

## 1.4. Structure
## 1.5. Tests effectués
## 1.6 Adaptation par rapport a la donnée