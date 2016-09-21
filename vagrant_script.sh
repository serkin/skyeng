#!/bin/bash

# Updating repository

sudo apt-get -y update

sudo apt-get install -y git mc

# Installing MySQL

sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password \"''\""
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password \"''\""
sudo apt-get -y install mysql-server php5-mysql

mysql -uroot -e "create database yii2basic;"
mysql -uroot -e "ALTER DATABASE yii2basic CHARACTER SET utf8 COLLATE utf8_general_ci;"

# Installing PHP
sudo apt-get -y install php5 php5-mcrypt

# Installing Composer

php -r "readfile('https://getcomposer.org/installer');" | php
mv composer.phar /usr/local/bin/composer

composer global require "fxp/composer-asset-plugin:*"

# cd /vagrant
# /usr/local/bin/composer install


sudo sed -i 's/127.0.0.1/0.0.0.0/g' /etc/hosts

cd /tmp
wget https://files.phpmyadmin.net/phpMyAdmin/4.6.4/phpMyAdmin-4.6.4-english.tar.gz
tar -zxf phpMyAdmin-4.6.4-english.tar.gz
# cd phpMyAdmin-4.6.4-english/
