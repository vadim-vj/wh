1. Что такое PostgreSQL, его преимущества и краткая история

1. Основы архитектуры Postgres, структура файлов, утилиты

   - сервер + множество клиентов, пользователи, место хранения баз
   - конфигурационные файлы
   - `psql`, `{create|drop}db`, прочие

1. Основные определения реляционной теории, ключи и понятие целостности данных

   - таблица/отношение, запись/кортеж, поле/атрибут, заголовок и тело
   - потенциальный и первичный ключ, естественные и суррогатные, уникальность, `NULL`
   - три типа связей, примеры
   - целостность, внешние ключи, типы таблиц, каскадирование

1. Первые три нормальные формы, аномалии, денормализация, преимущества и недостатки

   - определение нормализации, ее необходимость, три аномалии, примеры
   - функциональная зависимость, определения НФ, примеры
   - денормализация, зачем нужна, примеры

1. Что такое SQL, подмножества языка, операции реляционной модели и теории множеств

   - DDL, DML, DCL, примеры команд каждого
   - операции выборки и проекции, отражение в SQL
   - кратко о `UNION` и остальных

1. SQL, лексическая структура языка

   - зависимость от регистра, двойные кавычки, пробелы
   - литералы (числа и строки), типы строк, авто-конкатенация
   - три способа приведения типов
   - приоритет операторов
   - комментарии

1. Базовые типы Postgres, `NULL`

   - числовые: целые, с плавающей точкой, с произвольной точностью, последовательные
   - символьные: три вида
   - дата-время: дата, время, дата+время, интервал
   - логический тип, `NULL`, особенности сравнения с последним
   - перечисления

1. Составные типы (массивы и JSON)

   - массивы в стиле Postgres и в стиле стандарта SQL
   - операторы и функции работы с массивами
   - два типа для JSON, их сравнение
   - операторы и функции работы с JSON

1. DDL, синтаксис

   - создание и удаление таблиц, базовый синтаксис
   - модификация таблиц, разные варианты

1. `SELECT`, части и порядок выполнения

   - перечисление частей в порядке выполнения
   - где можно использовать псевдонимы и где можно на них ссылаться
   - в каких частях можно использовать агрегатные функции
   - где можно использовать подзапросы разных типов

1. Команды изменения данных, `UPSERT`, `COPY`, каскадные операции

   - три команды, их синтаксис (включая копирование таблиц через `INSERT ... SELECT`)
   - `ON CONFLICT`, синтаксис и варианты
   - особенности массовых операций (индексы), синтаксис и особенности `COPY` (права и альтерантива)
   - виды каскадирования

1. Соединения таблиц, все виды. Операции теории множеств

   - перечисление всех `JOIN`-ов, альтернативы без них
   - ключевые слова `INNER`/`OUTER`, общее сравнение соединений
   - `UNION`/`INTERSECT`/`EXCEPT`, детали каждой (уникальность и количество дубликатов)

1. Группировка и агрегатные функции

   - когда выполняется, что может использоваться в `HAVING`
   - 5 основных агрегатных функций
   - особенности обработки `NULL` в столбцах

1. Подзапросы, условия в выборке (`IN`/`EXISTS`/`BETWEEN`), `CASE`

   - три типа подзапросов, где каждый может использоваться
   - замена подзапросов на соединения
   - сравнение `IN` с `EXISTS`
   - синтаксис `CASE`, где может использоваться

1. `ORDER BY`, `LIMIT ... OFFSET`, влияние индексов

   - когда и в каком порядке выполняется в запросе
   - алиасы и порядковые номера, направление сортировки
   - порядок сортировки для `NULL`-значений

1. Оконные функции

   - понятие раздела и оконного кадра (рамки)
   - полный синтаксис, отдельное определение окна, определение рамки
   - основные функции, примеры

1. Представления и временные таблицы, общие табличные выражения, наследование таблиц

   - общее понятие о представлениях, обычные/материализованные, синтаксис создания/удаления/обновления
   - синтаксис `WITH`, изменение данных в CTE, рекурсия
   - синтаксис `INHERITS`, выборки из родителя, ограничения

1. Основные встроенные функции общего назначения + библиотечные

   - `coalesce`/`nullif`, `greatest`/`least`
   - примеры функций: математических, строковых

1. Полнотекстовый поиск, регулярные выражения

   - `[I]LIKE`, синтаксис выражений
   - `SIMILAR TO`, синтаксис выражений
   - регулярные выражения POSIX, операторы и синтаксис

1. Хранимые процедуры и триггеры

   - базовый синтаксис функций на языке SQL, типы возвращаемых значений и аргументов
   - типы триггеров, синтаксис объявления, особенности

1. Общее понятие транзакции, ACID

   - определение транзакции
   - каждое из свойств ACID
   - SQL-синтаксис транзакций

1. Феномены и уровни изоляции транзакций в Postgres, блокировки

   - MVCC
   - список феноменов
   - перечисление уровней изоляции, список допустимых на них феноменов

1. Индексы, виды и использование

   - определение индекса, синтаксис создания
   - создаваемый по умолчанию тип, его структура

---

- VACUUM, очистка
- План запроса, команда `EXPLAIN`
- управление доступом + `GRANT`/`REVOKE`

---

# Задачи

---
