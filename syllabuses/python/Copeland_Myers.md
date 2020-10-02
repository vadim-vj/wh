### Copeland R., Myers J., Essential SQLAlchemy
<https://www.oreilly.com/library/view/essential-sqlalchemy-2nd/9781491916544/>

---

Код примеров: <https://github.com/oreillymedia/essential-sqlalchemy-2e>

#### Введение
- использует некий диалект SQL Expression Language
- использует паттерн Unit of Work
- выбор между Core и ORM зависит от требуемого функционала: нужны ли запросы/отчеты/выборки/статистика с сильной привязкой к структуре БД и высокой производительностью, или ориентация на Domain-Driven Design
- создание движка и подключение к базе: `sqlalchemy.create_engine('<connection-string>'[, params]).connect()	`

---

### I. Core

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
- `insert` строится на объекте класса `Table`: `ins = cookies.insert().values(...)`, параметрами идут `<имя-столбца>=<значение>`. Если привести к строке возвращенный объект (`print(str(ins))`), то будет показан реальный выполненный SQL. В этом SQL используются параметры-плейсхолдеры (`:column_name`) для правильного экранирования. `ins.compile().params` возвращает словарь с уже экранированными данными
- после подготовки идет выполнение вставки (с предварительной компиляцией запроса): `result = connection.execute(ins[, param=val, ...])`. Можно указать значения столбуов и здесь (это перекроет значения из `insert`), хотя такое используется и не часто. Можно даже передать массив записей. Первичный ключ вставленной записи: `result.inserted_primary_key`
- можно вызывать `insert` и как функцию верхнего уровня (а не метод объекта): `insert(cookies).values(...)`
- `select` строится так же: `connection.execute(select([cookies])).fetchall()`. Метод `.execute()` возвращает прокси (объект-обертка над курсором), из которого можно получить все записи через `.fetchall()`. SQL можно посмотреть так же, через приведение результата вызова `select()` к строке (``print(str(sel))``)
- прокси поддерживает оператор индекса (`result[N]`), а для каждой записи к столбцам можно обращаться по индексу, имени или через объект `Column`. Кроме того, сам объект-прокси является итератором, может использоваться, например, в циклах: `for recordin rp:`. Еще методы доступа на проксе: `.first()`, `.fetchone()`, `.scalar()` (один столбец одной записи), `.keys()` (список имен столбцов)
- общие советы:
  * используйте `first()` если нужна одна запись: это четче выражает намерения
  * предпочитайте итерирование `.fetchall()`-у и другим: это более эффективно в плане памяти
  * избегайте `.fetchone()`: он оставляет соединения открытыми, можно случайно забыть закрыть
  * не используйте часто `.scalar()`: он падает с ошибкой, если в выборке больше одной строчки с одним столбцом, и это часто не отлавливается при тестировании
- столбцы в выборках желательно ограничивать: `select([cookies.c.cookie_name, cookies.c.quantity])`
- упорядочивание: `s = select([...]).order_by(...)`, `s.order_by(desc(cookies.c.quantity))` (`from sqlalchemy import desc`) или `cookies.c.quantity.desc()`
- лимит: `s.limit(2)`
- функции (`from sqlalchemy.sql import func`): `select([func.sum(cookies.c.quantity)])`, и другие. Поддержка псевдонимов (`as`) - через `.label()`: `select([func.count(cookies.c.cookie_name).label('inventory_count')])`/`print(record.inventory_count)`
- фильтрация: `select([cookies]).where(cookies.c.cookie_name == 'chocolate chip')`, `select([cookies]).where(cookies.c.cookie_name.like('%chocolate%'))`
- `ClauseElement` - это как правило просто столбец в таблице. Класс поддерживает разные методы (вроде `.like()` из пред. примера): `.between()`, `.concat()`, `.is_(None)`, `.in_([])`, и т.д. Большинство этих методов есть в варианте с приставкой `not`
- `ClauseElement` поддерживает многие перегруженные операторы (как в примере с `.where()`), и их можно использовать везде, напр., `select([cookies.c.cookie_name, 'SKU-' + cookies.c.cookie_sku])`
- функция `cast()` приводит типы: `cast((cookies.c.quantity * cookies.c.unit_cost),Numeric(12,2)).label('inv_cost')])`
- "союзы" (conjunctions): `froms qlalchemy import and_, or_, not_; select([cookies]).where(and_(a,b))`. Вместо них можно использовать и перегруженные битовые операторы `&, |, ~` (но не рекомендуется). В обоих случаях получаются стандартные SQL-евские `AND`/`OR`/`NOT`
- `update()` аналогичен `insert()`-у (как глобальная функция и как метод), только еще может принимать `.where()` (какие строки обновлять)
- `delete()` тоже похож, только на нем, в отличие от `.insert()`/`.update()`, не нужно вызывать `.values()` (задавать значения-параметры). Возможен `.where()` (какие строки удалять)
- соединения: `.join()`/`.outerjoin()`, вызываются на объектах класса `Table`: `orders.join(users)`. В функцию `select_from()` можно подать сразу `join`, получится `SELECT ... FROM users JOIN orders ON`
- алиасы таблиц: `manager = employee_table.alias(['<optional-name>'])`
- агрегация: `select(...).group_by(<column>)`
- в цепочке вызовов можно использовать больше одной функции одного типа (напр., несколько `.where()`) - *chaining*
- можно выполнять и "сырые" (raw) SQL-запросы: `connection.execute("select * from orders").fetchall()`, `.where(text("username='cookiemon'"))`. Возвращается всё тот же объект `ResultProxy`

#### 3. Исключения и транзакции
- две самые частые ошибки (модуль `sqlalchemy.exc`):
  * `AttributeError` - доступ к несуществующему атрибуту, напр., столбцу в `ResultProxy`
  * `IntegrityError` - нарушение ограничений, напр., вставка неуникального значения в уникальный ключ
- обрабатывать ошибки можно стандартным способом - заключая `connection.execute()` в блок `try/except`. Хорошая практика - заключать в этот блок как можно меньше кода: захват неожидаемых ошибок, как правило, это не то что нужно
- транзакции - атомарные операции, всё или ничего. `transaction = connection.begin()` ---> действия с `connection` ---> `transaction.commit()`/`transaction.rollback()`. Можно, например, помещать `.commit()` в `try`, а `.rollback()` в `except`

#### 4. Тестирование
- имитирование (mock) запросов или моделей для тестов может быть трудным, и не приносить ощутимой выгоды. Поэтому обычно используют "тонкие" функции-обертки. В разделе рассматриваются функциональные тесты (при этом юзает `unittest`). (???) Ничего не понял.
- приложение и слой БД построены так, что в классе тестов можно подменить connection string, напр., на базу в памяти (`sqlite:///:memory:`) и тестировать на ней. Фикстурами загружаются данные. Ну то есть просто прогоняет на тестовой базе, причем тут обертки?
- при большом кол-ве кода, зависящем от результатов запроса (???), проще имитировать код SQLAlchemy. База в памяти всё равно создается, но mock-ается соединение (???)
- в тестовом классе добавляет методам декораторы `@mock.patch('app.dal.connection')`, отчего в метод начинает передаваться параметр - имитация соединения. Выставляет у этого соединения (у одного из запросов) фальшивый результат (`mock_conn.execute.return_value.fetchall.return_value = self.cookie_orders`), после чего вызов функций приложения начинает возвращать этот подмененный результат (из-за того, что в приложении используется соединение - параметр декоратора?)
- можно имитировать отдельные методы - `@mock.patch('app.select')`. (???) Тут опять не ясно

#### 5. Отображение (рефлексия)
- столбцы не задаются руками, а считываются из существующей базы. Для этого в конструкторе `Table` нужно указать параметры: `Table('Artist', metadata, autoload=True, autoload_with=engine)`. Схема после этого окажется в метаданных: `metadata.tables['<table-name>']`
- из-за того, что идет отображение одной таблицы за раз, и библиотека пытается не оставить метаданные в полуразобранном состоянии, внешние ключи в результат не попадают. Задает их вручную. После этого можно выполнять `join`-ы без указания ключей. Проверить `join` можно так: `str(artist.join(album)) --> 'artist JOIN album ON artist."ArtistId" = album."ArtistId"'`
- отображение базы целиком (так гораздо проще, чем по одной таблице): `metadata.reflect(bind=engine)`. После этого можно получать отдельные таблицы - `playlist = metadata.tables['Playlist']` - и использовать их в запросах
- в версии 1.0 нельзя отображать `CheckConstraint`, комментарии, триггеры, а также "client-side defaults" и "association between a sequence and a column" (?)

---

### II. ORM

#### 6. Задание схемы
- пользовательская модель должна наследоваться от `declarative_base()`, содержать поле `__tablename__`, содержать `Column`-атрибуты и атрибут(ы) первичного ключа
- `from sqlalchemy.ext.declarative import declarative_base`. Функция `declarative_base()` возвращает нужный базовый класс (`sqlalchemy.ext.declarative.api.DeclarativeMeta`), поэтому наследоваться нужно от ее результата: `Base = declarative_base(); classCookie(Base): ...`
- столбцы задаются как атрибуты класса: `classCookie(Base): \n\t cookie_id = Column(Integer(), primary_key=True)`
- ограничения тоже задаются как атрибут класса, кортеж: `__table_args__ = (ForeignKeyConstraint(...), CheckConstraint(...))`
- внешний ключ можно задавать и как свойство-ссылку на объект связанного класса: `from sqlalchemy.orm import relationship, backref; classOrder(Base): \n\t user =  relationship("User", backref=backref('orders', order_by=order_id))`
- пред. пример устанавливает отношение "one-to-many". Для "one-to-one" в параметрах `relationship()` нужно указать `uselist=False`
- для записи схемы (persist) нужен вызов на базовом классе (видимо, метаданные все уже заполнены): `Base.metadata.create_all(engine)`

#### 7. Работа с данными
- паттерн UnitOfWork + IdentityMap
- ORM в SQLAlchemy работает с базой через класс-фабрику `from sqlalchemy.orm import sessionmaker`, который подобен конфигурационным настройкам, и должен использоваться единожды, в глобальной области приложения: `engine = create_engine(...); Session = sessionmaker(bind=engine); session = Session()`. Он является и оберткой над транзакцией
- для вставки данных в БД: инстантиируем ORM-классы - `cc_cookie = Cookie(cookie_name='chocolate chip', ...)` и передаем их в объект сессии, созданный в пред. пункте - `session.add(cc_cookie); session.commit()`. Вызов `.commit()` физически пишет данные в базу (`.add()` == insert) и задает поле объекта - результирующий первичный ключ. `.commit()` выполняет транзакцию - вызывает `Engine:BEGIN --> Engine:INSERT --> Engine:COMMIT` (для вывода такой (отладочной) инфы нужно передать `echo=True` в `create_engine()`)
- вместо `.commit()` можно использовать `.flush()` - он не закрывает транзакцию, и модели можно продолжать использовать в рамках текущей сессии
- более быстрый метод `session.bulk_save_objects([c1,c2])` выполняет только один `INSERT` (с массивом записей), но он не прикрепляет объекты к сессии, не учитывает отношения между моделями, не триггерит события и прочее, и не устанавливает (новые) первичные ключи. Может пригодиться, например, при сохранении больших CSV-файлов в базу
- для получения всех записей из таблицы в метод сессии `.query()` нужно передать соответствующий класс: `session.query(Cookie).all()`. `.all()` возвращает список объектов, а по результату `.query()` можно итерировать: `for cookiein session.query(Cookie):`. Доступны и другие методы: `.first()`/`.one()`/`.scalar()`. Правила выбора такие же: предпочитать итерации `.all()`, предпочитать `.first()` `.one()`, не часто использовать `.scalar()`, выбирать только нужные столбцы
- последнее делается передачей только нужных свойств, не всего класса: `.query(Cookie.cookie_name, Cookie.quantity)`
- упорядочивание: `.query(Cookie).order_by(Cookie.quantity)`/`.order_by(desc(Cookie.quantity))`. Во втором случае можно писать и `Cookie.quantity.desc()`
- ограничение числа записей: либо срезы - `.query(Cookie)[:2]`, либо методом - `.query(Cookie).limit(2)`
- функции и лейблы: `session.query(func.count(Cookie.cookie_name).label('inventory_count')).first(); print(rec_count.inventory_count)`
- фильтрация: `session.query(Cookie).filter(Cookie.cookie_name == 'chocolate chip')`. Есть и метод `.filter_by(cookie_name='chocolate chip')`, в него передаются параметры вместо сравнений. В обоих поддерживается `Cookie.cookie_name.like('%chocolate%')`
- и вообще, всё это повторяет то что в Core, только вместо вызовов на `.select()` идут вызовы на `session.query()`. Дальше описываются операторы, `cast()`, "союзы"
- обновление (update) данных. Из всех объектов, привязанных к сессии (полученных через `.query()`) при `session.commit()` будут взяты их поля и записаны в БД. Так что просто менять свойства моделей. Можно даже не выбирать предварительно объекты, а обновлять прямо на объекте запроса: `query.update({Cookie.quantity: Cookie.quantity - 20})`. Метод `.update()` возвращает кол-во обновленных записей
- `.delete()` есть у сессии - `session.delete(<model-obj>)`, и у таблицы - `session.query(Cookie).delete()`
- обновление связанных сущностей происходит так же, по `.commit()`-у, если предварительно у моделей установить нужные свойства-объекты: `line2.order = o1; session.commit()`
- можно строить выборки на `join`-ах: `query.join(User).join(LineItem).join(Cookie).filter(...)`
- группировка: `query.outerjoin(Order).group_by(User.username)`
- в цепочке вызовов можно использовать больше одной функции одного типа - *chaining*
- "сырые" (raw) запросы: `from sqlalchemy import text; session.query(User).filter(text("username='cookiemon'"))`

#### 8. Сессия и исключения
- четыре состояния объектов-моделей:
  * Transient - объект не в сессии и не в базе (только что создан через конструктор)
  * Pending - модель добавлена через `.add()`, но еще не вызван `.flush()`
  * Persistent - и в сессии и в базе (`.commit()` уже вызван)
  * Detached - не в сессии, но запись в БД еще есть (отсоединение от сессии - `session.expunge(<obj>)`, напр., для присоединения к другой сессии (перенос данных между БД))
- сведения об объекте-модели: `from sqlalchemy import inspect;` и `getattr(inspect(<obj>), 'pending')` или `insp.transient`. Есть еще `inspect(...).modified` - флаг, что были изменены поля, и `inspect().attrs[N][.history.has_changes()|.value]`
- исключения (модуль `sqlalchemy.orm.exc`):
  * `MultipleResultsFound` - при вызове `.one()` на результате с несколькими строками (или ни одной записи)
  * `DetachedInstanceError` - попытка доступа до атрибута объекта-модели, не присоединенного к сессии (БД). У него в примере этот атрибут - объект-связь, поэтому загрузка отложенная, но выполнить запрос к связанной таблице на отсоединенном объекте нельзя. Не понятно, будет ли такое же исключение на обычном свойстве
  * прочие: `ObjectDeletedError`, `StaleDataError`, `ConcurrentModificationError` - говорят от различие данных между объектом, сессией и БД
- управляет исключениями стандартно, через `try/except`-блок
- приводит пример с `IntegrityError` (что-то со связями), запись сессии падает. Поэтому помещает `session.commit()` в блок `try`, а `session.rollback()` - в `except`

#### 9. Тестирование
- глава аналогична 4, только DAL (Database Access Layer) написан с использованием ORM. Декорирование тестовых методов идет с подменой (mock) сессии: `@mock.patch('app.dal.session')`

#### 10. Отображение (рефлексия) и Automap
- для отображения существующей БД используется `from sqlalchemy.ext.automap import automap_base; Base = automap_base()`. Создается движок, вытягиваются данные `Base.prepare(engine, reflect=True)`,и построенные классы оказываются в словаре `Base.classes` (напр., `Artist = Base.classes.Artist`)
- дальше использование стандартно, напр., `session.query(Artist)...`
- Automap создает связи (как? по внешним ключам?) в виде свойств с именем `<related_object>_collection`, напр., `for albumin artist.album_collection:`. Это (и прочие аспекты) поведение настраивается

---

### III. Alembic
- это тулза для изменения схемы БД (добавление/удаление таблиц, изменения столбцов и т.д.) и (программной) поддержки миграций

#### 11. Введение
- утилита командной строки, ставится как пакет Python - `pip3 install alembic`
- инциализация в папке: `$ alembic init[ migrations]` (аргумент команды - путь создаваемой подпапки, может быть любым, `migrations` - традиционное имя). Команда создает и файл `alembic.ini`
- внутри созданной подпаки лежат `env.py` (настройка и запуск `engine` при вызове консольной команды `$ alembic`), `script.py.mako` (шаблон миграции) и папка `versions`, которая будет хранить скрипты миграции
- настраивается всё через `alembic.ini` - там задается строка подключения
- в (автоматически) созданном `env.py` подключается приложение - `from app.db import Base; target_metadata = Base.metadata`: для миграций нужен базовый класс моделей, хранящий метаданные

#### 12. Создание миграций
- в пред. разделе инициализировалась среда. После этого хорошо начинать с пустой миграции: `$ alembic revision -m "Empty Init"`. Это создаст в папке `versions/` py-файл, напр., `8a8a9d067_empty_init.py`. В нем две функции, `upgrade()` и `downgrade()`, указание ветки миграции и зависимостей
- в этом файле подробный комментарий-заголовок, с указанным при создании сообщением и прочими деталями
- ветки (branch) в миграциях потому, что изменения в модели обычно должны идти вместе с миграциями (?)
- обновление до последней доступной версии: `$ alembic upgrade head`
- приводит пример - добавляет новую модель в приложение и запускает `$ alembic revision --autogenerate -m "..."` для (авто)генерации миграции. В новом файле появляется ссылка на пред. ревизию (`down_revision`), в функции `upgrade()` - код `op.create_table('...', ...)`, а в функции `downgrade()` - код `op.drop_table('...')`
- после этого, запуск `$ alembic upgrade head` создаст новую таблицу в БД
- Alembic может отслеживать не все изменения, напр., изменения имен таблицы/столбца, ограничения (constraints) без явных имен, изменения типов (вроде `ENUM`), которые не поддерживаются явно драйвером БД
- для обхода этих ограничений нужно создать пустую миграцию, и в функции `up`/`down` вписать нужные действия, напр., `op.rename_table('<old>', '<new>')`. Вообще, операций (`from alembic import op`) в объекте `op` довольно много. Хотя не все они работают на каждой БД, напр., SQLLite не поддерживает модификацию столбцов, и поэтому `.alter_column()` там не работает

#### 13. Управление
- `$ alembic current` выдает последнюю примененную к БД миграцию
- `$ alembic  history` выдает список всего из папки `versions/`
- откат: `$ alembic downgrade <revision>`
- принудительное указание текущей миграции: `$ alembic stamp 2e6a6cc63e9` (позволяет, напр., пропускать миграции). Команда должны выполняться для каждой конкретной БД
- генерация SQL: `$ alembic upgrade 34044511331:2e6a6cc63e9 --sql[ > file]`, выводит в `stdout`. Важно помнить о типе БД для генерации корректного SQL, и при необходимости менять `sqlalchemy.url` в `alembic.ini`

---

#### 14. Рецепты
- *гибридные атрибуты* (`from sqlalchemy.ext.hybrid import hybrid_property, hybrid_method`) - декораторы, меняющие поведение методов классов моделей. Будучи вызванными на классе (`Cookie.inventory_value < 10.00`) они возвращают свой код, трансформированный в SQL - `cookies.unit_cost * cookies.quantity < :param_1`. То же для методов, переданные параметры превращаются в `:<param>`. Будучи же вызванными на объекте, они выполняют свой Python-код, возвращая значение. Такое поведение нужно для использования, напр., в запросах: `.order_by(Cookie.inventory_value)`
- *ассоциативные прокси* (`from sqlalchemy.ext.associationproxy import association_proxy`) - в классе модели, для внешнего ключа, задается атрибут: `ingredients = relationship(...); ingredient_names = association_proxy('ingredients', '<attr-name>')`. Это вытянет массив атрибутов из связи, и не придется вычитывать сначала все объекты, а потом в цикле собирать значения их атрибутов. Для случаев, когда к этому списку вручную добавляется значение (при `.flush()` нужно создавать новую запись в БД), в зависимом классе должен быть объявлен конструктор с одним (`'<attr-name>'`) параметром. При этом нужно помнить о возможном дублировании записей в БД (ддобавление создаст новую запись, аналогичную существующей)
- интеграция с Flask (пакет `flask-sqlalchemy`). Подключение к приложению: `from flask.ext.sqlalchemy import SQLAlchemy; app = Flask(__name__); SQLAlchemy().init_app(app)`. Через стандартные механизмы конфигурирования Flask-а (напр., через классы) задается строка подключения к БД (`SQLALCHEMY_DATABASE_URI`). Из ранее инициализированного пакет приложения импортируется фабрика (`from app import db`) и от ее класса наследуются модели: `class Cookie(db.Model):`. Сессия при этом оказывается в объекте `db.session`. Также к классам моделей добавляется новый метод `Cookie.query.all()`, но автор не рекомендует его использовать, чтобы не путать с нативным методом `.query()`
- SQLAcodegen. Python-пакет, дает утилиту командной строки. Генерирует (в `stdout`) код моделей по БД. Аргумент запуска - строка подключения к БД: `sqlacodegen postgresql:///test[ --tables Artist,Track][ > db.py]` (с возможностью ограничивать список таблиц)

#### 15. Что дальше?
- документация на оф. сайте: <http://docs.sqlalchemy.org/en/latest/>
- тестирование SQLAlchemy с использованием PyTest, Part 1: <http://alextechrants.blogspot.com/2013/08/unit-testing-sqlalchemy-apps.html>, Part 2: <http://alextechrants.blogspot.com/2014/01/unit-testing-sqlalchemy-apps-part-2.html>
- неоф. список плагинов и расширений: <https://github.com/dahlia/awesome-sqlalchemy>
- внутренняя архитектура библиотеки: <http://www.aosabook.org/en/sqlalchemy.html>
- и прочие ссылки, напр., на презентации и видео [p.175]
