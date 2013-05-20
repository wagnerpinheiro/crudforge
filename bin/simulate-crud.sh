#!/bin/bash
#
# Script to simulate crud
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
read -p "Digite a senha do usuario root do mysql: " SENHA
sed -i "s/database_password\:.*/database_password\: $SENHA/g" app/config/parameters.yml
echo -e "${yellow}Aperte ENTER nas proximas perguntas ate o ponto que o servidor estiver rodando na porta 8000${NC}"
app/console doctrine:database:create
app/console doctrine:generate:entity --entity=CrudforgeBundle:Simulation --fields='title:string(255) body:text' --format=annotation
app/console doctrine:schema:update --force
app/console generate:doctrine:crud --entity=CrudforgeBundle:Simulation --format=annotation --with-write --no-interaction
echo -e "${red}Abra o seu navegador no endereco: http://localhost:8000/simulation${NC}"
app/console server:run

# @todo: rodar depois de encerrar o server
# clear simulation
rm src/Crudforge/CrudforgeBundle/Entity/Simulation.php
rm src/Crudforge/CrudforgeBundle/Controller/SimulationController.php
rm src/Crudforge/CrudforgeBundle/Form/SimulationType.php
rm src/Crudforge/CrudforgeBundle/Resources/views/Simulation/*
rm src/Crudforge/CrudforgeBundle/Tests/Controller/SimulationControllerTest.php

exit 0

# simula atualizacao
rm src/Crudforge/CrudforgeBundle/Entity/Simulation.php
app/console doctrine:generate:entity --entity=CrudforgeBundle:Simulation --fields='title:string(255) body:text username:string(60)' --format=annotation
app/console doctrine:schema:update --force
rm src/Crudforge/CrudforgeBundle/Controller/SimulationController.php
rm src/Crudforge/CrudforgeBundle/Form/SimulationType.php
rm src/Crudforge/CrudforgeBundle/Resources/views/Simulation/*
rm src/Crudforge/CrudforgeBundle/Tests/Controller/SimulationControllerTest.php
app/console generate:doctrine:crud --entity=CrudforgeBundle:Simulation --format=annotation --with-write --no-interaction


#outros
#gera getters e setters
app/console doctrine:generate:entities Crudforge/CrudforgeBundle/Entity/Document