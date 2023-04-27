<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Project Information
   - Backend RestApi (Contoh Sistem Antrean)

## Technology Stack
   - Laravel 9
   - Postgre
   - JWT

## Installation Guide

- clone https://github.com/mriyadi1945/Project-Klinik.git
- open console
- run: cd Project-Klinik
- run: cp .env.example .env
- Setup Database Connection : 
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=database_name
    DB_USERNAME=postgres
    DB_PASSWORD=database_password
    DB_SCHEMA=development
- run: composer update
- run: php artisan pgsql:createDB
- run: php artisan migrate
- run: php artisan key:generate
- run: php artisan jwt:secret
- run: php artisan serve

## Seeder (Create user)
change
- //\App\Models\Antriansoal::factory()->create([
- //'username' => 'testing',
- //'password' => Hash::make('123456'),
- // ]);
 
To
 
- \App\Models\Antriansoal::factory()->create([
- 'username' => 'testing',
- 'password' => Hash::make('123456'),
- ]);

run: php artisan db:seed

## Work with postman
- open directory collections
- import file Klinik.postman_collection into postman
- base_url : http://127.0.0.1:8000/api

## Question
- WhatsApp: https://wa.me/628174100212
- IG: https://www.instagram.com/_riyadimoch/

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
