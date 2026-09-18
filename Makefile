.DEFAULT_GOAL := help

.PHONY: help
help: ## Show this help
	@echo "Usage: make <target>"
	@echo ""
	@echo "Targets:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN{FS=":.*?## "}{printf "  \033[36m%-18s\033[0m %s\n", $$1, $$2}'
# 	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'

.PHONY: up down logs shell drush composer reset

up: ## Start the Drupal stack
	./bootstrap.sh

down: ## Stop the Drupal stack
	docker compose down

logs: ## Show the logs of the Drupal stack
	docker compose logs -f

shell: ## Open a shell in the Drupal container
	docker compose exec drupal bash

drush: ## Run Drush commands in the Drupal container
	docker compose exec drupal vendor/bin/drush $(ARGS)

composer: ## Run Composer commands in the Drupal container
	docker compose exec drupal composer $(ARGS)

reset: ## ⚠️  Reset the Drupal stack (remove containers, volumes, and files)
	docker compose down -v
	rm -rf composer.json composer.lock web/sites/default/files
	./bootstrap.sh
