<https://www.w3schools.com/python/python_ref_string.asp> и дальше

```python
from collections.abc import Sequence, MutableSequence

issubclass(str, Sequence) == True
issubclass(list, Sequence) == True
issubclass(tuple, Sequence) == True

Sequence.count(value) -> int
# выбрасывает `ValueError` если значение не найдено
Sequence.index(value, start=0, stop=None) -> int

issubclass(list, MutableSequence) == True
```

|             | `str`          | `list`    | `tuple` | `dict`   | `set`              |                                |
|-------------|----------------|-----------|---------|----------|--------------------|--------------------------------|
| подсчет     | `count`        | `count`   | `count` |          |                    |                                |
| поиск       | `index`/`find` | `index`   | `index` |          |                    | `ValueError`                   |
| добавление  |                | `append`  |         |          | `add`              |                                |
| вставка     |                | `insert`  |         |          |                    |                                |
| расширение  |                | `extend`  |         | `update` | `update`           |                                |
| удаление    |                | `remove`  |         |          | `remove`/`discard` | `remove` -> `{Value|Key}Error` |
| доступ      |                |           |         | `get`    |                    |                                |
| деструкция  |                | `pop`     |         | `pop`    | `pop`              | `{Index|Key}Error`             |
| копирование |                | `copy`    |         | `copy`   | `copy`             |                                |
| очистка     |                | `clear`   |         | `clear`  | `clear`            |                                |
| сортировка  |                | `sort`    |         |          |                    |                                |
| обращение   |                | `reverse` |         |          |                    |                                |

```python
''.find('a') == -1
''.index('a') -> ValueError
```
