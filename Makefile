install:
	bash ./init.sh

uninstall:
	./vendor/bin/sail down --rmi all -v

sail-up:
	./vendor/bin/sail up -d

sail-down:
	./vendor/bin/sail down

mariadb:
	./vendor/bin/sail mariadb

mysql:
	./vendor/bin/sail mysql

composer-install:
	./vendor/bin/sail composer install

npm-install:
	./vendor/bin/sail npm install

migrate:
	./vendor/bin/sail artisan migrate

db-seed:
	./vendor/bin/sail artisan db:seed

npm-run-dev:
	./vendor/bin/sail npm run dev

key-generate:
	./vendor/bin/sail artisan key:generate

.PHONY: install uninstall sailup saildown mariadb mysql composer-install npm-install migrate db-seed npm-run-dev key-generate

