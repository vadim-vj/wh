### Copeland R., Myers J., Essential SQLAlchemy
<https://www.oreilly.com/library/view/essential-sqlalchemy-2nd/9781491916544/copyright-page01.html>

---

Код примеров: <https://github.com/oreillymedia/essential-sqlalchemy-2e>

#### Введение
- использует некий диалект SQL Expression Language
- использует паттерн Unit of Work
- выбор между Core и ORM зависит от требуемого функционала: нужны ли запросы/отчеты/выборки/статистика с сильной привязкой к структуре БД и высокой производительностью, или ориентация на Domain-Driven Design
- создание движка и подключение к базе: `sqlalchemy.create_engine('<connection-string>'[, params]).connect()	`

### 1. Core

#### 1. Схема и типы
- в этом разделе рассматриваются объекты `Table` (user-defined), содержащие описание столбцов и их атрибутов
- в SQLAlchemy 4 категории типов: generic, SQL standard, vendor specific, user defined
- generic-типы определены в `sqlalchemy.types` (и вынесены на верхний уровень), это обобщения, не зависящие от типа БД. Примеры: `Boolean` = Python:`bool`, SQL:`BOOLEAN`/`SMALLINT`, `BigInteger` = Python:`int`, SQL:`BIGINT`. Полная таблица [p.2]
- конструкторы типов имеют разные аргументы, хорошо бы их помнить
- в том же `sqlalchemy.types` определены и стандартные типы. Их можно использовать, например, когда дженериков недостаточно. Для различения они пишутся целиком большими буквами (напр., `CHAR`, `NVARCHAR`)
- аналогично стандартным записываются вендорные. Они хранятся в `sqlalchemy.dialects`. Пример: `from sqlalchemy.dialects.postgresql import JSON`
- большинство нужных классов вытащено на верхний уровень (уровень пакета): `from sqlalchemy import Table, Column, Integer, Numeric, String, ForeignKey`
- *метаданные* можно рассматривать как каталог таблиц + опциональные данные о движке и подключении. Информация о таблицах хранится как словарь в поле `tables`. перед использованием нужно инстантиировать объект: `from sqlalchemy import MetaData; metadata = MetaData(); metadata.tables`
- создание таблицы - через класс `Table` и объект метаданных: `cookies = Table('cookies', metadata,  Column('cookie_id', Integer(), primary_key=True), Column('cookie_name', String(50), index=True), ...)`
- помимо тех аргументов, что в примере выше, столбцы поддерживают еще `nullable`, `unique`, `default`, `onupdate` (значение - функция, не вызов функции. Напр., `onupdate=datetime.now`)
- три наиболее важных ограничения: `from sqlalchemy import PrimaryKeyConstraint, UniqueConstraint, CheckConstraint`. Инициализируются с именем столбца и названием ограничения, напр., `PrimaryKeyConstraint('user_id', name='user_pk')` или `CheckConstraint('unit_cost >= 0.00', name='unit_cost_positive')`
- индексы: `from sqlalchemy import Index`. Аналог примера выше (`index=True`): `Index('ix_cookies_cookie_name', 'cookie_name')`
- внешние ключи: `from sqlalchemy import ForeignKey`, `Table('...', metadata, Column('...', ForeignKey('<other-table-name>.<that-table-key>'))`
- индексы, ключи и ограничения можно задавать и отдельно, вне вызовов конструктора `Table()`, напр., `ForeignKeyConstraint(['order_id'], ['orders.order_id'])`
- после определения всех таблиц и их полей данные оказываются в объекте `metadata` и таблицы можно создавать физически (persist): `metadata.create_all(engine)`. Существующие таблицы перезаписаны не будут, вызов `create_all()` безопасен. Но лучше использовать миграции (см. ниже)

#### 2. Работа с данными
- 

### 2. ORM

### 3. Alembic
