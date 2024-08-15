#https://www.strangebuzz.com/en/snippets/the-perfect-makefile-for-symfony

# Executables: vendors
PHP_CS_FIXER  = ./vendor/bin/php-cs-fixer
PHPSTAN       = ./vendor/bin/phpstan

# Executables: local only
SYMFONY_BIN   = symfony
DOCKER_COMP   = docker-compose

## —— Coding standards ✨ ——————————————————————————————————————————————————————
all-analyses: fixphp stan

fixphp: ## Fix files with php-cs-fixer
	@PHP_CS_FIXER_IGNORE_ENV=1 $(PHP_CS_FIXER) fix --allow-risky=yes

stan: ## Run PhpStan
	@$(PHPSTAN) analyse src

## —— Symfony binary 💻 ————————————————————————————————————————————————————————
sfstart: ## Stop the webserver
	@$(SYMFONY_BIN) server:start

sfstop: ## Stop the webserver
	@$(SYMFONY_BIN) server:stop

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
dkup: ## Start the docker hub (PHP,caddy,MySQL,redis,adminer,elasticsearch)
	$(DOCKER_COMP) up --detach

dkbuild: ## Builds the images (php + caddy)
	$(DOCKER_COMP) build --pull --no-cache

dkdown: ## Stop the docker hub
	$(DOCKER_COMP) down --remove-orphans