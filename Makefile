# $(1) file name
define copy_dist_file
	@if ! test -f $(1); then (cp $(1).dist $(1) && echo 'Copied $(1) file'); fi
endef

init:
	@echo "Initializing project..."
	@make start
	@make setup
	@echo "Initialization completed!"

start:
	@echo "Starting project..."
	docker-compose up -d

stop:
	@echo "Stopping project..."
	docker-compose stop

setup:
	@echo "Setup project..."
	docker exec -it audioteka-php composer install
	@make migrate
	@make load-fixtures

migrate:
	@echo "Migrating database..."
	docker exec -it audioteka-php  bin/console doctrine:m:m -n

cache:
	@echo "Clearing cache..."
	docker exec -it audioteka-php bin/console cache:clear
	docker exec -it audioteka-php bin/console c:c --env=test
	docker exec -it audioteka-php bin/console c:c --env=prod

load-fixtures:
	@echo "Clearing cache..."
	docker exec -it audioteka-php bin/console doctrine:fixtures:load -n

test:
	@echo "Clearing cache..."
	docker exec -it audioteka-php bin/phpunit