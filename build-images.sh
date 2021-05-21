cd docker-images/apache-php-image
docker build -t res/apache_static .
cd ../apache-reverse-proxy
docker build -t res/apache_rp .
cd ../expressImage
docker build -t res/express .