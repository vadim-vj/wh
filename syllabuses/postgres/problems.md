
---
> Поиск дубликатов - вывести все строки, у которых несколько одинаковых полей. Требуется вывести только дублирующиеся поля

Простая группировка и подсчет:

```sql
SELECT sal, deptno FROM emp GROUP BY sal, deptno HAVING count(*) > 1;
```

`DISTINCT` здесь не нужен: группировка и так приводит к уникальным значениям.

---
> Поиск дубликатов - вывести все строки, у которых несколько одинаковых полей. Требуется вывести все поля

С подзапросом, через `IN`:

```sql
SELECT * FROM emp WHERE (sal, deptno) IN (
  SELECT sal, deptno FROM emp GROUP BY sal, deptno HAVING count(*) > 1
);
```

Возможны варианты: через кореллированный подзапрос с `=` и `EXIST`, через `JOIN`, через поздзапрос с оконной функцией.

---
> Как в задаче поиска дубликатов заменить вложенный подзапрос в `IN` на `JOIN`?

Практически прямой заменой. Соединять нужно также с подзапросом, он остается тем же. Из-за уникальности значений дубликатов в нем, `JOIN` просто оставляет все строки, имеющие пары, и дополнительных условий не нужно:

```sql
SELECT * FROM emp JOIN (
  SELECT sal, deptno FROM emp GROUP BY sal, deptno HAVING count(*) > 1
) AS t USING (sal, deptno);
```

---
> Поиск дубликатов - вывести только уникальные строки

Первый способ опирается на факт, что существует уникальное числовое `id`-поле, а второй более общий:

```sql
SELECT min(empno), sal, deptno FROM emp GROUP BY sal, deptno;

SELECT * FROM (
  SELECT *, row_number() OVER (PARTITION BY sal, deptno) FROM emp
) AS t WHERE row_number = 1;
```

---
> Поиск дубликатов - удалить все не-уникальные строки

Как и с выборкой:

```sql
DELETE FROM emp WHERE empno NOT IN (
  SELECT min(empno) FROM emp GROUP BY sal, deptno
);
```

Есть более сложный (и общий) вариант, с использованием `DELETE ... USING` + подзапроса с оконной функцией:

```sql
DELETE FROM emp USiNG (
  SELECT empno, row_number() OVER (PARTITION BY sal, deptno) FROM emp
) AS t WHERE emp.empno = t.empno AND t.row_number > 1;
```

---
> Как в два столбца вывести зарплату сотрудника + среднюю зарплату его (сотрудника) отдела?

Использовав агрегатную функцию `avg()` в качестве оконной:

```sql
SELECT salary, avg(salary) OVER (PARTITION BY depname) FROM empsalary;
```

Берется раздел по номеру отдела, без упорядочивания (полное среднее, не скользящее).

---
> Функции рангов часто нужны без группировки, но всегда с упорядочиванием

- `OVER(PARTITION BY deptno)` будет означать "ранг внутри отдела"
- `OVER()` будет означать "ранг внутри всей организации"

В обоих случаях будет `OVER ([...] ORDER BY sal)`.

```
val | row_number | rank | dense_rank
--- | ---------- | ---- | ----------
  1 |          1 |    1 |          1
  1 |          2 |    1 |          1
  2 |          3 |    3 |          2
  2 |          4 |    3 |          2
  3 |          5 |    5 |          3
  3 |          6 |    5 |          3
```

`rank()` дает номер первой строки в группе. Обе функции рангов могут выполнятся и на окне без сортировки (`OVER ()`), но тогда они всегда возвращают `1`.

---
> Как в два столбца вывести зарплату сотрудника + ранг (`1`, `2`, etc.) его зарплаты относительно остальных в отделе?

Через специальную оконную функцию `dense_rank()`:

```sql
SELECT
  salary,
  dense_rank() OVER (PARTITION BY depname ORDER BY salary DESC)
FROM empsalary;
```

Здесь важно упорядочивание внутри раздела, иначе `dense_rank()` всегда возвращает `1`.

---
> Решение задачи вида "найти `N`-нный элемент в таблице зависит от `N`

- для второго элемента есть варианты через `DISTINCT` + `LIMIT 1 OFFSET 1`, и через `max()`
- для произвольного - более универсальный способ через подзапрос с оконной функцией `dense_rank()`

---
> Как найти значение второй максимальной зарплаты в таблице?

Т.к. агрегатную функцию `max()` нельзя совмещать с другими столбцам в списке `SELECT`-а, то так мы можем найти лишь значение самой большой зарплаты:

```sql
SELECT max(sal) FROM emp WHERE sal < (SELECT max(sal) FROM emp);
```

Через `ORDER BY + LIMIT[ + OFFSET]` можно выбрать все столбцы, но мы получим лишь одну строку, если одинаковых вторых окладов несколько:

```sql
SELECT * FROM emp WHERE sal < (SELECT max(sal) FROM emp) ORDER BY sal DESC LIMIT 1;
SELECT * FROM emp ORDER BY sal DESC OFFSET 1 LIMIT 1;
```

Выбрать все столбцы и все строки с одинаковым окладом можно через общее решение - через подзапрос с оконной функцией:

```sql
SELECT * FROM (
  SELECT *, dense_rank() OVER (ORDER BY sal DESC) FROM emp
) AS t WHERE t.dense_rank = 2;
```

---
> Как найти пятый по величине оклад в таблице?

Через подзапрос с оконной функцией:

```sql
SELECT * FROM (
  SELECT * dense_rank() OVER (ORDER BY sal DESC) FROM emp
) AS sub WHERE dense_rank = 5;
```

- здесь важно брать в качестве раздела всю таблицу, то есть не указывать `PARTITION BY`
- направление сортировки может быть и восходящим, если нужно пятый с начала

---
> Как одним запросом вычислить сумму всех отрицательных и положительных значений в столбце?

Через `CASE`, или его аналог для агрегатных функций в PostgreSQL - `FILTER`:

```sql
SELECT
  sum(x) FILTER (WHERE x > 0) AS pos,
  sum(x) FILTER (WHERE x < 0) AS neg
FROM (VALUES (2),(-2),(4),(-4),(-3),(0),(2)) AS tmp(x);
```

```
 pos | neg
-----+-----
   8 |  -9
```

---
> Дана таблица `tbl` и поля `nmbr` со следующими значениями:
> `1, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1, 0, 1`
> 
> Написать запрос, чтобы установить `2` вместо `0` и установить `3` вместо `1`

Указать `CASE` прямо после `=`:

```sql
update TBL set Nmbr = case when Nmbr = 0 then 2 else 3 end;
```

---
> Как из таблицы выбрать все записи c четными `ID`? А с нечетными?

Воспользоваться оператором остатка от деления:

```sql
SELECT * FROM emp WHERE empno % 2 = 0;
SELECT * FROM emp WHERE empno % 2 <> 0;
```

---
> Как получить последний `id` без использования функции `max()`? С функцией `max()`?

```sql
SELECT DISTINCT id FROM some_table ORDER BY id DESC LIMIT 1;
SELECT max(id) FROM some_table;
```

---
> Дана таблица с парами "дата"-"сумма". Как вычислить сумму всех сумм, предшествующих каждой дате?

Т.н. "скользящая" сумма:

```sql
SELECT date, total, sum(total) OVER (ORDER BY date) FROM some_table;
```

`ORDER BY` в `OVER()` задает оконный кадр. Все агрегатные функции, используемые в качестве оконных, учитывают оконный фрейм, так что суммирование идет только до текущего значения, а не по всему разделу (совпадающему здесь со всей таблицей).


---
> Как найти максимальную зарплату каждого отдела? Как при этом вывести название отдела вместо его ID?

```sql
SELECT deptno, max(sal) FROM emp GROUP BY deptno;
```

Для вывода названия нужен `JOIN`, и обязательно внешний - иначе отделы без сотрудников не попадут в вывод:

```sql
SELECT dname, max(sal) FROM emp RIGHT JOIN dept USING (deptno) GROUP BY dname;
```

---
> Вывести всех сотрудников, принятых на работу между определенными датами

С использованием `BETWEEN`:

```sql
SELECT * FROM emp WHERE hiredate BETWEEN '1981-01-01' AND '1981-07-01';
```

---
> Напишите SQL запрос, чтобы найти сотрудника, чья зарплата равна или превышает 2000

```sql
SELECT * FROM emp WHERE sal >= 2000;
```

---
> Напишите SQL запрос, чтобы найти имя сотрудника, чье имя начинается с "M"

```sql
SELECT * FROM emp WHERE ename LIKE 'M%';
```

---
> Напишите запрос, ищущий по имени сотрудника, независимо от регистра

```sql
SELECT * FROM emp WHERE upper(ename) LIKE '%LL%';
```

---
> Как вывести всех сотрудников, являющихся менеджерами?

Соединение таблицы самой с собой:

```sql
SELECT DISTINCT m.ename FROM emp e, emp m WHERE e.mgr = m.empno;
SELECT m.ename, e.ename FROM emp e, emp m WHERE e.mgr = m.empno;
```

Второй вариант выводит их подчиненных вторым столбцом.

---
> Как вывести всех сотрудников, не являющихся менеджерами?

Предикат `ON e.empno = m.mgr` ~ "является чьим-то менеджером". Если он не выполняется, то внешнее соединение справа дописывает `NULL`-строку:

```sql
SELECT e.* FROM emp e LEFT JOIN emp m ON e.empno = m.mgr WHERE m.empno IS NULL;
```

---
> Как найти все строки в одной таблице, присутствующие в другой?

Если нужны лишь значения совпадающих столбцов (`<cols> = (ename, job, sal)`), то через `INTERSECT`:

```sql
SELECT * FROM v INTERSECT SELECT ename, job, sal FROM emp;
```

Если нужны и остальные столбцы, то через `INNER JOIN` или `IN` + выборка `<cols>` из второй таблицы:

```sql
SELECT emp.* FROM emp JOIN v USING (ename, job, sal);
SELECT emp.* FROM emp WHERE (ename, job, sal) IN (SELECT DISTINCT * FROM v);
```

Таким образом, `INNER JOIN` эквивалентен `IN`

---
> Как найти все отделы, в которых нет сотрудников?

Задача эквивалента "Как найти все строки в одной таблице, которых нет в другой?".

Если нужны лишь значения совпадающих столбцов (`<cols> = deptno`), то через `EXCEPT`:

```sql
SELECT deptno FROM dept EXCEPT SELECT deptno FROM emp;
```

Если нужны и остальные столбцы, то через анти-джоин или `NOT IN` + выборка `<cols>` из второй таблицы:

```sql
SELECT dept.* FROM dept LEFT JOIN emp USING (deptno) WHERE emp.deptno IS NULL;
SELECT dept.* FROM dept WHERE deptno NOT IN (SELECT DISTINCT deptno FROM emp);
```

Таким образом, анти-джоин (`LEFT JOIN` + `IS NULL`) эквивалентен `NOT IN`

---
> Как удалить все записи, не имеющие пары в другой таблице?

`NOT EXISTS` + кореллированный подзапрос в `WHERE`:

```sql
DELETE FROM ... WHERE NOT EXISTS (SELECT ... t1.deptno = t2.deptno)
```

---
> Как найти самую часто встречающуюся зарплату в таблице (моду)?

Два вложенных селекта - сначал группировка с подсчетом, потом ранжирование, после чего получение первого:

```sql
SELECT * FROM (
  SELECT *, dense_rank() OVER (ORDER BY count DESC) FROM (
    SELECT sal, count(*) FROM emp GROUP BY sal
  ) AS tmp
) AS tmp WHERE dense_rank = 1;
```

Здесь важен порядок сортировки при вычислении ранга - `ORDER BY count DESC`. Если взять `ASC`, то будут выбраны самые редко встречающиеся зарпллаты.

Альтернативный вариант (?):

```sql
SELECT sal, count(*) FROM emp GROUP BY sal
  HAVING count(*) >= all(SELECT count(*) FROM emp GROUP BY sal);
```
