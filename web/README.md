# MEDSI Survey (Drupal 10 demo)

Drupal 10 demo: Webform (опрос сотрудников) + отчёты + landing.

## Требования

- Docker + Docker Compose

## Старт

### 1) Запуск

```bash
docker compose up -d --build
2) Сайт
Landing: http://localhost:8080/home

Form: http://localhost:8080/webform/medsi_survey?company_token=test123

База данных
Дамп лежит в docker/db/init/01_dump.sql.

При первом запуске пустого volume MySQL сам импортирует дамп.

Полный сброс и переинициализация базы
docker compose down -v
docker compose up -d --build
```
