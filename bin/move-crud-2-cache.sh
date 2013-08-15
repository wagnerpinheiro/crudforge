#!/bin/bash
#
# Script to move generated CRUD to cache
# author: Wagner Pinheiro
#
#go project root
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR/..
DOC="$1"
CRUD_USER_ID="$2"

mkdir app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Entity -p
mkdir app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Controller -p
mkdir app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Form -p
mkdir app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Resources/views/$DOC/ -p
mkdir app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Tests/Controller -p

mv src/Crudforge/CrudforgeBundle/Entity/"$DOC".php app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Entity/
mv src/Crudforge/CrudforgeBundle/Controller/"$DOC"Controller.php app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Controller/
mv src/Crudforge/CrudforgeBundle/Form/"$DOC"Type.php app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Form/
mv src/Crudforge/CrudforgeBundle/Resources/views/$DOC/* app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Resources/views/$DOC/
mv src/Crudforge/CrudforgeBundle/Tests/Controller/"$DOC"ControllerTest.php app/cache/CrudforgeBundle/"$CRUD_USER_ID"/Tests/Controller/"$DOC"ControllerTest.php