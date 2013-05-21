#!/bin/bash
#
# Script to remove generated CRUD
# author: Wagner Pinheiro
#
#go project root
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR/..
DOC="$1"
rm src/Crudforge/CrudforgeBundle/Entity/"$DOC".ph
rm src/Crudforge/CrudforgeBundle/Controller/"$DOC"Controller.php
rm src/Crudforge/CrudforgeBundle/Form/"$DOC"Type.php
rm src/Crudforge/CrudforgeBundle/Resources/views/$DOC/*
rm src/Crudforge/CrudforgeBundle/Tests/Controller/"$DOC"ControllerTest.php