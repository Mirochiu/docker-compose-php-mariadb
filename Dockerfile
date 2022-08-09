FROM php:7.4-apache

ENV DEBIAN_FRONTEND noninteractive
ENV TZ Asia/Taipei

RUN apt-get update \
  && apt-get install -yq tzdata \
  && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
  && dpkg-reconfigure -f noninteractive tzdata

RUN docker-php-ext-install -j$(nproc) mysqli
RUN apt-get clean

EXPOSE 80