
---
> Сгенерируйте матрицу для задачи коммивояжера

Матрица симметрична - `m[i][j] == m[j][i]`: расстояние между городами не зависит от порядка в паре. Значения на главной диагонали равны нулю: один и тот же город.

```python
import random

n = 3
matrix = [[0.0]*n for _ in range(n)]

for i in range(n):
    for j in range(i):
        matrix[i][j] = matrix[j][i] = random.uniform(1, 30)
```

---
> Как вернуть 10 последних строк из текстового файла?

Используя двустороннюю очередь фиксированной длины:

```python
import collections

with open('/home/localhost/Downloads/data.txt') as f:
    collections.deque(f, 10)
```

Здесь итератор можно не перебирать вручную, а сразу отдать его конструктору очереди.

---
> Напишите функции для чисел и операций такие, чтобы выполнялось
> 
> ```python
> assert one(add(five())) == 6
> assert five(add(one())) == 6
> ```

Через каррирование:

```python
def num(val, f=None):
    return f(val) if f else val

def one(f=None):
    return num(1, f)

def five(f=None):
    return num(5, f)

def add(val):
    return lambda x: x + val
```

---
> Напишите жадный алгоритм решения задачи о банкомате с лимитами

При кратных номиналах купюр:

```python
class ATM:
    def __init__(self, banknotes):
        self.banknotes = banknotes

    def get(self, amount):
        result = {}

        for nom, avail in self.banknotes.items():
            fit = min(amount // nom, avail)

            if fit > 0:
                result[nom] = fit
                amount -= fit * nom

                if amount == 0:
                    break
        else:
            raise Exception("Can't handle amount")

        return result

atm = ATM({1000: 10, 500: 20, 100: 100})
assert atm.get(1800) == {1000: 1, 500: 1, 100: 3}
assert atm.get(1300) == {1000: 1, 100: 3}
```
