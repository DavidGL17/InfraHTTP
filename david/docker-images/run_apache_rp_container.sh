# Sets up 2 servers of each type (static and dynamic) and a rp server that handles connections to both

docker run -d --name apache_static1 res/apache_php
docker run -d --name apache_static2 res/apache_php
docker run -d --name express1 res/express
docker run -d --name express2 res/express

docker run -d --name apache_rp -e STATIC_APP1=172.17.0.2:80 -e STATIC_APP2=172.17.0.3:80 -e DYNAMIC_APP1=172.17.0.4:3000 -e DYNAMIC_APP2=172.17.0.5:3000 -p 8080:80 res/apache_rp