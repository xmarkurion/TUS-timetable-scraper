run:
	php artisan serve

setup:
	npm install
	composer install
	php artisan storage:link
	php artisan migrate --force
