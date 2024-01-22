SHELL=/bin/bash

.PHONY: help
.PHONY: build
.PHONY: check
.PHONY: cloc
.PHONY: test
.PHONY: coverage

help:
	@echo "make build	Builds the project from scratch"
	@echo "make check	Checks the project for coding standards"
	@echo "make cloc	Count lines of source code in the project"
	@echo "make test	Executes PHPUnit tests"
	@echo "make coverage	Executes PHPUnit tests with code coverage"

build:
	@composer install

check:
	@./bin/php-cs-fixer fix

cloc:
	@cloc ./src ./tests

test:
	@./bin/phpunit

coverage:
	@XDEBUG_MODE=coverage ./bin/phpunit --coverage-html=coverage
