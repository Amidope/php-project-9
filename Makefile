PORT ?= 8000
start:
	PHP_CLI_SERVER_WORKERS=5 php -S 0.0.0.0:$(PORT) -t public
dump:
	composer dump-autoload
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src
lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src