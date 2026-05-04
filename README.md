# SmartyBlog

Небольшой PHP-проект на `PHP-FPM + Nginx + MySQL + Smarty` с компиляцией `SCSS -> CSS`.

## Требования

- Docker
- Docker Compose (plugin `docker compose`)

## Быстрый старт

1. Поднять контейнеры:

```bash
docker compose up -d --build
```

2. Запустить watcher для SCSS (если не стартовал вместе с `up`):

```bash
docker compose up -d assets
```

3. Выполнить сидирование базы:

```bash
docker exec -it smarty_blog_php-fpm php src/bin/seed.php
```

4. Открыть приложение:

`http://localhost:8080`

## Структура сервисов

- `nginx` — web-сервер на `localhost:8080`
- `php` — приложение (`php-fpm`)
- `mysql` — база данных
- `assets` — сборка и watch для `SCSS`

## Где лежит фронт

- SCSS: `src/frontend/css/app.scss`
- Скомпилированный CSS: `src/frontend/css/app.css`
- Шаблоны Smarty: `src/frontend/templates`

## Если стили не обновляются

1. Проверить, что сервис `assets` запущен:

```bash
docker compose ps
```

2. Перезапустить watcher:

```bash
docker compose restart assets
```

3. Сделать hard refresh в браузере (`Ctrl+F5`).
