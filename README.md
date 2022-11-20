# Админка Kolesa Upgrade

## Требования 
* php v8.1
* Composer
* MySQL

## Запуск
1. Загрузить зависимости с помощью Composer
  1. composer update(если Composer установлен в ввиде пакета) | php composer update(если Composer был просто загружен в директорию с проектом)
2. Поднять MySQL сервер, создать базу данных для проекта и создать в ней таблицы при помощи файла миграций(query.sql)
3. Заполнить конфигурационный файл для подключения проекта к базе данных
4. Запустить проект на веб-сервере
    * Запуск проекта на встроенном php сервере - php localhost:port
