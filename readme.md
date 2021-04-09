## Online Blood Bank Management System
This Project has been developed for searching blood online.

## Installation of pre-requisites

1. Xampp or Lampp ( PHP 7.3.27 | Apache 2.4.46 | Mariadb 10.4.18 ) 
2. Composer 

## Install & Run Xampp
* Download & Install [Xampp 7.3.27 / PHP 7.3.27](https://www.apachefriends.org/xampp-files/7.3.27/xampp-windows-x64-7.3.27-1-VC15-installer.exe)

* Run `Apache` & `Mysql` from xampp-control

## Install Composer
* Download the leatest version of [composer](https://getcomposer.org/download/)

* Add both php & composer on path variable

## Setup database
* Open phpMyadmin from {baseurl}/phpmyadmin

* Open create a new database: `bloodbank`

* Open `Privileges` and add a new User Account e.g: username: testdbuser, pass: 123456 

* open cmd/terminal, clone the project, go to the project repo, then
* copy from .env.examples to .env
```sh
cp .env.example .env
```

* set `DB_DATABASE`, `DB_USERNAME` & `DB_PASSWORD` according to the created database before.


## Setup & Run project
* update & install composer
```sh
composer update
composer install
```

* Generate key for Laravel's Enrypter
```sh
php artisan key:generate
```

* migrate database
```sh
php artisan migrate
```

* run the project 
```sh
php artisan serve
```