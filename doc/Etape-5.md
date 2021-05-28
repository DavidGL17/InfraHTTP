# Etape 5 : Dynamic reverse proxy configuration

## Introduction

Dans cette étape nous augmentons le serveur reverse-proxy de l'étape 3 pour que la configuration du site se fasse dynamiquement au lancement du container contenant le reverse proxy.

## Contenu

Nous avons rajouté au dossier de l'image du serveur reverse proxy le fichier [apache2-foreground](../docker-images/apache-reverse-proxy/apache2-foreground). Ce fichier est exécuté lors du setup de l'image depuis laquelle nous nous basons, soit dans notre cas php:7.4-apache. Dans ce fichier, nous avons rajouté au début quelques commandes qui nous permettent d'appeler php sur le fichier [config-template.php](../docker-images/apache-reverse-proxy/template/config-template.php), ce qui va générer la configuration de site 001-reverse-proxy.conf et la mettre dans /etc/apache2/sites-available. Ceci permet de rendre la génération du fichier de configuration du site dynamique.

Dans le fichier de [config php](../docker-images/apache-reverse-proxy/template/config-template.php) (voir ci-dessous), nous avons fait en sorte de récupérer la valeur de deux variables globales du système dans deux variable, et d'injecter ces deux variables à la place des adresses ip qui étaient auparavant codées en dures. Les deux variables globales utilisées sont crées lors du lancement du container en utilisant l'option `-e GLOBAL_VARIABLE=value`. En utilisant cette option, nous pouvons donc donner dynamiquement l'adresse ip de nos 2 serveurs sans avoir a l'encoder en dur.

```php
<?php
   $static_app = getenv('STATIC_APP');
   $dynamic_app = getenv('DYNAMIC_APP');
?>

<VirtualHost *:80>
         ServerName demo.res.ch

         ProxyPass '/api/animals/' 'http://<?php print "$dynamic_app"?>/'
         ProxyPassReverse '/api/animals/' 'http://<?php print "$dynamic_app"?>/'

         ProxyPass '/' 'http://<?php print "$static_app"?>/'
         ProxyPassReverse '/' 'http://<?php print "$static_app"?>/'
</VirtualHost>
```

## Dockerfile

```dockerfile
FROM php:7.4-apache

RUN apt-get update && \ 
   apt-get install -y nano

COPY apache2-foreground /usr/local/bin/
COPY template /var/apache2/templates
COPY conf/ /etc/apache2

RUN a2enmod proxy proxy_http
RUN a2ensite 000-* 001-*
```
Le dockerfile n'a pas beaucoup changé par rapport à l'étape 3. Nous avons changé la version de l'image php/apache de base est sommes passés à la 7.4, car la 7.2 posait quelques soucis avec le fichier apache2-foreground. Nous avons aussi rajouté la ligne `COPY apache2-foreground /usr/local/bin/` qui permet d'ajouter le fichier apache2-foreground. Nous avons aussi rajouté la ligne `COPY template /var/apache2/templates` qui permet de charger le template php qui génerera la page de configuration du site fois appelé

## Installation/Utilisation

Se placer dans les 3 dossiers des images et lancer dans chacun la commande associé pour build les images

- Dans le dossier apache-php-image lancer `docker build -t res/apache_static .`
- Dans le dossier apache-reverse-proxy lancer `docker build -t res/apache_rp .`
- Dans le dossier expressImage lancer `docker build -t res/express .`

Puis lancer le serveur statique et dynamique en utilisant les commandes suivantes

```bash
docker run -d --name apache_static1 res/apache_static
docker run -d --name express1 res/express
```

Puis, après avoir vérifié les adresses ip des deux serveurs lancés en utilisant la commande `docker inspect container_name | grep -i ipaddr`, de lancer la commande suivante (remplacer les adresses ip par celles qui correspondent si-besoin)

```bash
docker run -d --name apache_rp -e STATIC_APP=172.17.0.2:80 -e DYNAMIC_APP=172.17.0.3:3000 -p 8080:80 res/apache_rp
```

## Adaptation

Nous avons du prendre un version plus récente de l'image php par rapport à celle donnée dans la vidéo, ce qui fait que nous avons aussi du prendre le fichier apache2-foreground correspondant, dont le contenu de base avait lui aussi légèrement changé par rapport à la version de la vidéo.

## Tests

Pour tester cette configuration, nous avons refait les même teste que lors de [l'étape 3](Etape-3.md) pour vérifier que nous pouvions bien accéder aux deux serveurs avec les bonnes adresses.

Puis nous avons lancé la commande `docker exec -it apache_rp /bin/bash` pour aller observer l'état du fichier 001-reverse-proxy.conf dans le dossier /etc/apache2/sites-enabled et confirmer qu'il avait bien été réecrit par notre commande php et activé par le serveur apache.