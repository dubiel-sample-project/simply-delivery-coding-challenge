SHELL := /bin/bash
SYMFONY = bin/console
PHPUNIT = bin/phpunit

tests:
	@$(SYMFONY) doctrine:database:drop --force --env=test || true
	@$(SYMFONY) doctrine:database:create --env=test
	@$(SYMFONY) doctrine:migrations:migrate -n --env=test
	@$(SYMFONY) doctrine:fixtures:load -n --env=test
	@$(PHPUNIT) $@
.PHONY: tests