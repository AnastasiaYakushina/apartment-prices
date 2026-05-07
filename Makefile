install:
	composer install
	cp -n .env.example .env || true
	php artisan key:generate --ansi
	touch database/database.sqlite
	php artisan migrate --force

lint:
	composer exec phpcs -- --standard=PSR12 routes tests app

test:
	php artisan test