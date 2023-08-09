#!/bin/bash

docker build -t php_application .
sleep 3
docker stop $(docker ps -a -q); docker rm $(docker ps -a -q)
sleep 3
docker-compose up -d
