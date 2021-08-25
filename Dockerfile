FROM php:7.4-apache

# first time to run
# docker build -t my-php-app .
# docker run -d -p 3000:80 --name running-php-app my-php-app

# run
# docker start running-php-app

# $ wget http://localhost:3000/
# ps> Invoke-WebRequest http://localhost:3000/

# stop
# docker stop running-php-app

# remove forever
# docker rm running-php-app
# docker rmi my-php-app

# show container ip
# docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' running-php-app

COPY ./src /var/www/html
EXPOSE 80