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
#
#install Git
sudo apt-get install git
echo -e "${yellow}Git installed${NC}"
#install LAMP Server
sudo apt-get install lamp-server^
echo -e "${yellow}LAMP installed${NC}"
#install MongoDB
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv 7F0CEB10
sudo sh -c 'echo "deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen" > /etc/apt/sources.list.d/10gen.list'
sudo apt-get update
sudo apt-get install mongodb-10gen
echo -e "${yellow}MongoDB installed${NC}"
#install composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
echo -e "${yellow}Composer installed, use it: composer${NC}"
#post-install checklist
echo -e "${blue}\n----------------------------------------------"
echo -e "TO-DO:"
echo -e " [] Configure mongodb in /etc/mongodb.conf\n"
echo -e "${NC}"
sleep 2
