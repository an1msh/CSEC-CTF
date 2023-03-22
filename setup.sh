#!/bin/bash

sudo apt-get update
sudo NEEDRESTART_MODE=a apt-get install -y snapd
sudo snap install docker
sudo docker build -t csecctf .
sudo docker run -t -p 80:80 csecctf
