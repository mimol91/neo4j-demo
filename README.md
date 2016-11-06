NEO4J-demo
=======

#### Description
Demo application showing difference between relational and graph database using social network as example,


#### Usage
* execute ` app/console doctrine:fixtures:load` to load fixtures or create it manually.
* use `http://localhost/person/` to create persons and their relation.
* use `http://localhost/select-related` to see how you can follow from one person to another
* use `http://localhost:7474/browser` to play with neo4j

#### Installation
* `cd .docker && docker-compose up` to create container.
* `composer install` to download backend dependencies.
* go to `http://localhost:7474/browser/` and setup neo4j credentials.
* `vim app/config/config_neo4.yml` to setup credentials.


#### Demo
![alt text](https://github.com/mimol91/neo4j-demo/blob/master/relation.png "Demo")

![alt text](https://github.com/mimol91/neo4j-demo/blob/master/neo4j.png "Demo")
