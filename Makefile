init:
	cd ./../../../bitrix && COMPOSER=composer-bx.json composer install

create-module:
	cd ./../../../bitrix && php bitrix.php make:module
