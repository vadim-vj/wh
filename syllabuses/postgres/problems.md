---
> Как в два столбца вывести зарплату сотрудника + среднюю зарплату его (сотрудника) отдела?

Использовав агрегатную функцию `avg()` в качестве оконной:

```sql
SELECT salary, avg(salary) OVER (PARTITION BY depname) FROM empsalary;
```
---
> Как в два столбца вывести зарплату сотрудника + ранг (`1`, `2`, etc.) его зарплаты относительно остальных в отделе?

Через специальную оконную функцию `dense_rank()`:

```sql
SELECT salary, dense_rank() OVER (PARTITION BY depname ORDER BY salary DESC) FROM empsalary;
```
