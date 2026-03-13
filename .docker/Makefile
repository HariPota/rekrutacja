include docker.mk

.PHONY: init install yarn-dev db-init

## init	:	Initialize project (create SQLite DB, install deps, build assets).
init: db-init install yarn-dev

## install	:	Run composer install and yarn install.
install:
	@echo "Running composer install for $(PROJECT_NAME)..."
	@docker exec $(PROJECT_NAME)_php composer install
	@echo "Running yarn install for $(PROJECT_NAME)..."
	@docker exec $(PROJECT_NAME)_php yarn install

## db-init	:	Create SQLite database and vehicles table.
db-init:
	@echo "Initializing SQLite database for $(PROJECT_NAME)..."
	@docker exec $(PROJECT_NAME)_php init-db.sh

## yarn-dev	:	Build frontend assets.
yarn-dev:
	@echo "Building frontend assets for $(PROJECT_NAME)..."
	@docker exec $(PROJECT_NAME)_php yarn dev
