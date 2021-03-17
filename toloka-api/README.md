# Yandex.Toloka API

Несложное REST-приложение на основе [aiohttp-фреймворка](https://docs.aiohttp.org/en/stable/). В качестве коннектора к PostgreSQL используется пакет [asyncpg](https://magicstack.github.io/asyncpg/current/). API взято отсюда: <https://yandex.ru/dev/toloka/doc/>

Примеры JSON-ответов:

- <https://toloka-api.herokuapp.com/projects>
- <https://toloka-api.herokuapp.com/projects?status=ARCHIVED>
- <https://toloka-api.herokuapp.com/pools>

---

- Дамп базы (Postgres): [dump.sql](dump.sql)
- Основной файл приложения: [app.py](app.py)
- Инициализация приложения: [tlkapi/common.py](tlkapi/common.py)

Внутри:

- Абстрактный класс endpoin-ов: [tlkapi/router/abstract,py](tlkapi/router/abstract,py)
- Абстрактный класс DB-сущностей: [tlkapi/db/abstract.py](tlkapi/db/abstract.py)
- Немного тестов: [tlkapi/tests/abstract.py](tlkapi/tests/abstract.py), [tlkapi/tests/projects.py](tlkapi/tests/projects.py)

Скрипты запуска:

- сервера: [run_locally](run_locally)
- тестов: [run_tests](run_tests)
