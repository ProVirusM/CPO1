## Отборочный этап на чемпионат России

## Наш проект работает по адресу `http://185.221.213.154:8080`

## Первый чек поинт

1. Ссылка на дизайн макета в Figma https://www.figma.com/design/2P8ySbVgW19w3a4MyF0eV0/Хакатон-ФСП.-Ноябрь-2024?node-id=1-3&node-type=frame&t=oZleahV35ovRcKjT-0
2. Ссылка на гугл дискх архитектуры решения проекта https://drive.google.com/file/d/1AMcT4AANK3kmTWbqst4nt1GcIuB6xlKv/view

## Иструкция по запуску проекта для разработичков, в самом низу инструкция для жюри

## Frontend

Для запуска или установки Vue 3 требуется Node.js версии 18+ https://nodejs.org/en/
Если запуск происходит в первый раз, то нужно будет собрать проект, если уже файлы есть, инструкция ниже

## Для разработки

1. Заходим в папку frontend `cd frontend`
2. Устанавливаем зависимости с помощью команды `npm install`
3. Запускам проект с помщоью команды `npm run dev`
4. Готово, фронт запущен

## Для деплоя

1. Пишем команду `npx vite build`
2. Затем фронт будет помещен в папку `/backend/app/public/dist`
3. Теперь наш фронт будет точкой входа для нашего приложения `http://localhost:8080`

## Backend

1. Заходим в папку backend `cd backend`
2. Запускаем docker службу
3. Создаем образ `docker build -t <название образа> .`
4. Запускаем контейнер `docker compose -p <название контейнера> up -d`
5. Сервер запущен
6. Установка Symfony
7. Заходим в контейнер php `docker exec -it <Название контейнера> /bin/bash`
8. Прописываем команду `composer install`

## В папке postgres лежит файл дампа базы данных, который нужно выполнить

1. Чтобы зайти внутрь контейнера с базой данных введем команду `docker exec -it <Название контейнера> /bin/bash`
2. После попадания внутрь контейнера подключаемся к базе данных `psql -H postgres-db -U user -d fsp-postgres`
3. Выполняем скрипт с базой данных `\i dump/<название файла.sql>`
4. Сделать дамп `pg_dump -U user fsp-postgres > dump.sql`
5. Готово база данных создана и заполнена!

## заметки

Установка

1. Создаем Symfony проект `composer create-project symfony/skeleton:"7.1.*" .`
2. Создаем Docktrine ORM `composer require symfony/orm-pack`
3. Для того чтобы сгенерировать ключ `php bin/console lexik:jwt:generate-keypair`

<h1>Инструкция по запуску проекта для жюри </h1>

1. Клонируем проект
2. Заходим в папку backend `cd backend`
3. Собираем контейнер `docker compose -p <название контейнера> up -d`
4. Заходим в контейнер с php `docker exec -it <Название контейнера> /bin/bash`
5. Устанавливаем зависимости `composer install`
6. Генерируем ключи для JWT `php bin/console lexik:jwt:generate-keypair`
7. Теперь заходим в Postgres контейнер `docker exec -it <Название контейнера> /bin/bash`
8. Подключаемся к БД `psql -H postgres-db -U user -d fsp-postgres`
9. Выполняем скрипт создания БД `\i dump/<название файла.sql>`
10. Готово, проект у вас доступен по адресу `http://localhost:8080`

<h1>Если возникают вопросы по настройке или запуску проекта, обращаться в тг `https://t.me/Kn1gor`</h1>
