# Money Transfer demo 

When you find any errors please report, Thank you :)

##Installation

Install [Docker](https://www.docker.com/docker-ubuntu).
and [docker-compose](https://docs.docker.com/compose/install/)


Boot the Docker (containers also will be run)

    make install
    
Run containers
   
    make up

Populate database with test data
 
    make db


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

    
Add host mapping to localhost (if you like needed)    
    
    sudo vim /etc/hosts
    127.0.0.1       superproject.lo  # add this

### Auth
``X-API-TOKEN`` is mandatory header for all tracking requests. You can get it by login or register endpoints

### Swagger
Swagger is available on ``http://localhost:8880/api/doc  ``
There is all available endpoints with sample data. You can test API directly from there
        
        
### XDebug
To use XDebug tool in backend project you should replace *LOCAL_IP* variable in .env file for your local ip address


## OAUTH2 
Application uses oauth2 to validate request via API.

You can use HARDCODED Access Token 

``Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxOGIyMDBlZmY0NzFiN2JlNmEwZTUwOWZjZDIzY2VkNCIsImp0aSI6IjYwNzYxY2RmMzA5ZDg4YmE5YzRiZjdlYTlkZmQxYjA1ZmY5NjU3MzViYTVmZDgzMDc4ODIzMGM1NWNkZGE0ZmViNTI4NWIyMDMwMmEyYWFlIiwiaWF0IjoxNjAwMzc1NTU4LCJuYmYiOjE2MDAzNzU1NTgsImV4cCI6MTYwMTY3MTU1Nywic3ViIjoiY2FybG9zQHRlc3QuY29tIiwic2NvcGVzIjpbInRyYW5zZmVyIl19.mIz3bOwpCdzSfg1pnvKxoTafZWJoHqOovc8g6LS8V5fWJk7XXockY6zx9GNMU-c6qnUUz7Nqj6srWZBAr9AMjwZ5VO-IihHYLU7tzvAc7HYyas_ESS_-SBXa50YUG5rNsoVUH4j3lj79UwiR8U2GQPMefzY0nrBLTqOdy_MXmQfz7yawv1d-PhznrWee56bNiFcxVQZ4mBoJDfKFi3SEYkPDpPHTbcX2We0LzFf_tOpYM45rwr8zET-z3efA63x3jHyUvCWuUZHLrgOkF1AMX73ORlnk1n5r2uTGhvX0cFSGx7dtUZA5XN_6lslkzkaRp72f1ikU1WqXuk_olOQR2Q``

or create new one

To get *Access Token* please do following request

    curl --location --request POST 'http://localhost:8880/token?client_id=36b1757c73bceccfc265f45e7aa246a5&client_secret=682e455f14274269883a6a5d4e218c9a2e2dad7171988ad14f838210b6b63bc2b16b5e510a90c2598cdf6bf384630c7f01e9fa40a6b15a009fe842ad890bb8db&response_type=code&scope=transfer' \
    --header 'x-api-key: adf51226795afbc4e7575ccc124face7' \
    --form 'client_id=18b200eff471b7be6a0e509fcd23ced4' \
    --form 'client_secret=f7ba095db223ceef80df096da87cdfd3ba4457a2c30915d76333789e6981705754166d1faec216843178a5cc5a60aaf8576fa167611032fc03c7f7746bfb9d87' \
    --form 'grant_type=password' \
    --form 'username=carlos@test.com' \
    --form 'password=test'
    

## API

Currently available 2 REST endpoints : Transfer Money and Check Balance

### Transfer Money API

    curl --location --request POST 'http://localhost:8880/payment-api/transfer/{{WALLET ID FROM }}/{{WALLET ID TO}}/{{AMOUNT, float value}} \
    --header 'x-api-key: adf51226795afbc4e7575ccc124face7' \
    --header 'Content-Length: 0' \
    --header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxOGIyMDBlZmY0NzFiN2JlNmEwZTUwOWZjZDIzY2VkNCIsImp0aSI6IjYwNzYxY2RmMzA5ZDg4YmE5YzRiZjdlYTlkZmQxYjA1ZmY5NjU3MzViYTVmZDgzMDc4ODIzMGM1NWNkZGE0ZmViNTI4NWIyMDMwMmEyYWFlIiwiaWF0IjoxNjAwMzc1NTU4LCJuYmYiOjE2MDAzNzU1NTgsImV4cCI6MTYwMTY3MTU1Nywic3ViIjoiY2FybG9zQHRlc3QuY29tIiwic2NvcGVzIjpbInRyYW5zZmVyIl19.mIz3bOwpCdzSfg1pnvKxoTafZWJoHqOovc8g6LS8V5fWJk7XXockY6zx9GNMU-c6qnUUz7Nqj6srWZBAr9AMjwZ5VO-IihHYLU7tzvAc7HYyas_ESS_-SBXa50YUG5rNsoVUH4j3lj79UwiR8U2GQPMefzY0nrBLTqOdy_MXmQfz7yawv1d-PhznrWee56bNiFcxVQZ4mBoJDfKFi3SEYkPDpPHTbcX2We0LzFf_tOpYM45rwr8zET-z3efA63x3jHyUvCWuUZHLrgOkF1AMX73ORlnk1n5r2uTGhvX0cFSGx7dtUZA5XN_6lslkzkaRp72f1ikU1WqXuk_olOQR2Q'
    
Be aware that do to this operation you need know both wallets ids (check in db) and have auth code
Be aware that you can transfer money only from user, who logged in by auth2

*Hint* Wallets id of carlos@test.com by fixtures stores in table wallets for 3rd and 4th position from top

### Get Balance

    curl --location --request POST 'http://localhost:8880/payment-api/balance/{{WALLET ID }} \
    --header 'x-api-key: adf51226795afbc4e7575ccc124face7' \
    --header 'Content-Length: 0' \
    --header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxOGIyMDBlZmY0NzFiN2JlNmEwZTUwOWZjZDIzY2VkNCIsImp0aSI6IjYwNzYxY2RmMzA5ZDg4YmE5YzRiZjdlYTlkZmQxYjA1ZmY5NjU3MzViYTVmZDgzMDc4ODIzMGM1NWNkZGE0ZmViNTI4NWIyMDMwMmEyYWFlIiwiaWF0IjoxNjAwMzc1NTU4LCJuYmYiOjE2MDAzNzU1NTgsImV4cCI6MTYwMTY3MTU1Nywic3ViIjoiY2FybG9zQHRlc3QuY29tIiwic2NvcGVzIjpbInRyYW5zZmVyIl19.mIz3bOwpCdzSfg1pnvKxoTafZWJoHqOovc8g6LS8V5fWJk7XXockY6zx9GNMU-c6qnUUz7Nqj6srWZBAr9AMjwZ5VO-IihHYLU7tzvAc7HYyas_ESS_-SBXa50YUG5rNsoVUH4j3lj79UwiR8U2GQPMefzY0nrBLTqOdy_MXmQfz7yawv1d-PhznrWee56bNiFcxVQZ4mBoJDfKFi3SEYkPDpPHTbcX2We0LzFf_tOpYM45rwr8zET-z3efA63x3jHyUvCWuUZHLrgOkF1AMX73ORlnk1n5r2uTGhvX0cFSGx7dtUZA5XN_6lslkzkaRp72f1ikU1WqXuk_olOQR2Q'
    
## Improvements
For technical part:
1. Cover Code with Unit Tests + Cover Bad Use case for integration tests
1. Test db on big data and tune it 
1. Improve DTO mechanism
1. Add more logging logic
1. Add test database to run integrtions tests
1. Refactoring : check typo, duplicates, combine code, split by interfaces handlers and service

For Business Part
1. Implement correct validation mechanism for all special cases
1. Add more custom exceptions + format frontend response
1. Implement transactions type: commission,refund,overdraft and etc
1. Implement Deposit Service and ExchangeService
1. Add possibility to assign several rules for wallet
