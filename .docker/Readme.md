#Instal Docker
```curl -s https://get.docker.io/ubuntu/ | sudo sh```

#Instal docker-compose 
```sudo sh -c "curl -L https://github.com/docker/compose/releases/download/1.4.0/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose"```

#Add docker to group
```sudo usermod -a -G docker $USER```

#Start Daemon
```sudo service docker start```

#Reboot PC
```reboot```

#Build xsdev image
docker build -t xsdev .

#Setup docker compose
docker-compose up -d

#Setup hosts
127.0.0.1   xs.dev

#Setup files permission
Symfony: (Run from host) 
- sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
- sudo setfacl -dR -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
