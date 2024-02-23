#!/bin/bash

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
ORANGE='\033[0;33m'
NC='\033[0m'

cp .env.example .env &&
./vendor/bin/sail up -d &&
./vendor/bin/sail composer install &&
./vendor/bin/sail npm install &&
./vendor/bin/sail artisan key:generate &&
./vendor/bin/sail artisan storage:link &&
echo -e "\n ${GREEN}Starting Sail Containers, wait...${NC} \n" &&
sleep 10 &&
./vendor/bin/sail php artisan migrate &&
./vendor/bin/sail php artisan db:seed &&
./vendor/bin/sail yarn dev &&

echo -e "${GREEN}" &&
echo -e " -- API Routes List --" &&
echo -e "${NC}" &&
./vendor/bin/sail php artisan route:list --path=api &&

echo -e "${RED}" &&
echo -e "*************************" &&
echo -e "*****  ACCESS INFO  *****" &&
echo -e "*************************${GREEN}" &&
echo -e " - Access: ${ORANGE}localhost \n ${GREEN}- Login: ${ORANGE}admin@email.com \n ${GREEN}- Password: ${ORANGE}12345678 \n${GREEN}" &&
echo -e " -- Default Token --" &&
echo -e "${ORANGE}3in9X94Rmz7NLzsQpjhub7KFRhheplhVFDzQWGx9dAjGszopil9SGMZZollQ${RED}" &&
echo -e "*************************" &&
echo -e "*************************" &&
echo -e "${NC}" &&

echo -e "${RED}" &&
echo -e "*************************" &&
echo -e "${GREEN}Installation completed!!! ${RED}"
echo -e "*************************" &&
echo -e "${NC}" &&

echo -e "${YELLOW} That's all folks! ${NC}"
