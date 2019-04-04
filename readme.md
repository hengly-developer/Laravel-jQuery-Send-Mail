## Installing Composer

Composer Install

## Installing Laravel

composer global require laravel/installer

## Clone Project

git clone https://github.com/hengly-developer/Laravel-jQuery-Send-Mail.git

## Copy .env from .env.example

cp .env.example .env

## .env

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=example@gmail.com
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls

## Generating Key 

php artisan key:generate

## Run Laravel

php artisan serve 





