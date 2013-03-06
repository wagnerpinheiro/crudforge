#!/bin/bash
#Git
sudo apt-get install git
#LAMP Server
sudo apt-get install lamp-server^
#MongoDB
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv 7F0CEB10
sudo sh -c 'echo "deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen" > /etc/apt/sources.list.d/10gen.list'
sudo apt-get update
sudo apt-get install mongodb-10gen
echo -e 'TO-DO: Configure mongodb in /etc/mongodb.conf'
