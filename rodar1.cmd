composer install
composer dump-autoload
php bin/create_tables.php
php -S localhost:8000 -t public public/index.php