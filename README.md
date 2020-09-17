# Money Transfer demo 

When you find any errors please report, Thank you :)

## Prerequisites

Install [Docker](https://www.docker.com/docker-ubuntu).
and [docker-compose](https://docs.docker.com/compose/install/)

### Start virtual environment


Boot the Docker (containers also will be run)

    make install
    
Run containers
   
    make up

Check that docker is running    
    
    docker ps | grep superproject

or

    docker-compose ps
    
Show all available commands for Make

    make

Execute tests

    make tests

Endpoint URL

    http://localhost:8880/
    
All Available API Endpoints on 

    http://localhost:8880/api/doc    

Database connection

    host:port/database: localhost:54320/superproject
    login: dev
    password: dev

Tests database connection

    host:port/database: localhost:54319/superproject_test
    login: test
    password: test

    
Add host mapping to localhost (if you like needed)    
    
    sudo vim /etc/hosts
    127.0.0.1       superproject.lo  # add this

### Auth
``X-API-TOKEN`` is mandatory header for all tracking requests. You can get it by login or register endpoints

### Swagger
Swagger is available on ``http://localhost:8880/api/doc  ``
There is all available endpoints with sample data. You can test API directly from there
        
        
## XDebug
To use XDebug tool in backend project you should replace *LOCAL_IP* variable in .env file for your local ip address
