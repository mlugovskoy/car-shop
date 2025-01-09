<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Учебный проект "Car Shop"

- PHP 8.2
- Laravel 11.x
- Node 22.12.0
- PostgreSQL 16
- Redis 7.2

## Этапы развертывания

1. Выполнить `npm i` и `composer i`
2. Скопировать файл .env.example в корневую директорию с названием `.env`
3. Создать локальную БД и заполнить соответствующие поля в `.env`, пример полей:<br>
    ### PostgreSQL
       DB_CONNECTION=pgsql
       DB_HOST=127.0.0.1
       DB_PORT=5432
       DB_DATABASE=crm
    ### Redis
       REDIS_CLIENT=pgsql
       REDIS_HOST=127.0.0.1
       REDIS_PASSWORD=null
       REDIS_PORT=6379
4. После создания БД нужно сгенерировать ключ `php artisan key:generate`
5. Выполнить две команды<br> `php artisan storage:link`<br>`php artisan migrate --seed`

## Запуск проекта

1. `npm run dev`
2. `php artisan serve`
3. Для авторизации использовать:<br>Логин: admin@example.com<br>Пароль: test
