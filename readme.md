#### Проект многопользовательской браузерной игры

Стек технологий
- nginx,
- mysql, redis
- php 7, laravel framework
- twitter bootstrap 3, jquery, node + socket.io

Проект разбит на модули ('app\Modules\')
Изначально использовалась ОРМ Eloquent, но со временем от неё отказался.
Сейчас работа с персист. данными идет через DAO

Схема БД находится в файле 'database\sql\init.sql'
