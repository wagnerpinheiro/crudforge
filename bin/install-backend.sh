#!/bin/bash
#
# Script to install backend for the CRUDForge on Ubuntu 12.10
# author: Wagner Pinheiro
#
#define colors
NC='\e[0m' # No Color
red='\e[0;31m'
green='\e[0;32m'
yellow='\e[0;33m'
blue='\e[0;34m'
#go project root
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR/..
#install Git
sudo apt-get install git
echo -e "${yellow}Git installed${NC}"
#install dependencies
sudo apt-get install curl
#install LAMP Server
sudo apt-get install lamp-server^
echo -e "${yellow}LAMP installed${NC}"
#install composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
echo -e "${yellow}Composer installed, use it: composer${NC}"
cp app/config/parameters.yml.dist app/config/parameters.yml
composer install
app/console assets:install --symlink --relative
#post-install checklist
echo -e "${blue}\n----------------------------------------------"
echo -e "TO-DO:"
echo -e " 1. set mysql passowrd in app/config/parameters.yml"
echo -e " 2. create database: app/console doctrine:database:create"
echo -e " 3. update database schema: app/console doctrine:schema:update --force"
echo -e " 4. run demo server: app/console server:run"
echo -e "${NC}"
sleep 2
