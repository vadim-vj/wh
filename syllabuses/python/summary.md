---

# Общее, `[common]`

Python - высокоуровневый мультипарадигменный язык, интерпретируемый, с динамической типизацией, автоматическим управлением памятью и автоматической же сборкой мусора. Кроссплаформенный, с открытым исходным кодом.

Поддерживает ООП. Синтаксис простой и лаконичный, подходит для быстрого прототипирования. Эталонная (референсная) имплементация - CPython, распространяется бесплатно. Большая стандартная библиотека (batteries included), плюс тесная интеграция с другими языками (вроде C/C++), что дает еще большее количество модулей-расширений. Язык имеет большое комьюнити.

Разработан в 89-91гг. Гвидо ван Россумом (BDFL), как потомок языка программирования ABC, способный к обработке исключений и взаимодействию с операционной системой Амёба. Версия 2.0 вышла в 2000г., а 3.0 - в 2008. Последняя на текущий момент поддерживаемая версия в ветке 2 - это v2.7. Активная в ветке 3 - это v3.8, и v3.9 на подходе. Развитием языка занимается некоммерческая организация Python Software Foundation (PSF), предложения изменений вносятся через спец. документы РЕР (Python Enhancement Proposals).

Философия языка, т.н. "Дзен Python", отражена в PEP20, который можно просмотреть вызвав `import this`.

---

# Интерпретатор, командная строка и среда, `[env]`

Интерпретатор компилирует исходники в (переносимый, быстро выполняемый) байт-код, скрипты хранит в памяти, а импортируемые модули пишет в папки `__pycache__/`, в виде файлов с расширениями `.python-38[.opt-N].pyc`. Перекомпиляция выполняется только если изменились файл с исходным кодом или версия интерпретатора. Байт-код выполняется на вирутальной машине Python (PVM), входящей в дистрибутив

Четыре режима выполнения кода интерпретатором:

```shell
$ python3 [-i]
$ python3 script.py
$ python3 -c '<command>'
$ python3 -m <module-name>
```

В первом случае интерпретатор читает код из `stdin` или переводится в интерактивный режим (REPL). В последнем выполняет указанный после `-m` модуль как скрипт (с `__name__ == '__main__'`), а если это пакет - то выполняет модуль `__main__.py` внутри этого пакета.

Вид и поведение REPL-а задаются параметрами из модуля `sys`: строками приглашения `sys.ps{1|2}` (`>>>`/`...`) и функцией отображения `sys.displayhook`, которая выглядит примерно так:

```python
import builtins

def displayhook(value):
    if value is not None:
        builtins._ = value
        print(repr(value))
```
Последний не-`None` результат, таким образом, записывается в переменную `_`. И строки приглашения, и `displayhook`, можно подменять.

Поведение интерпретатора модифицируется десятком опций и (часто) соответствующими им переменными окружения. Некоторые из них:

- `-B`/`PYTHONDONTWRITEBYTECODE` - не писать байткод в файлы
- `-I` - изолированный режим, включает `-E` - игнорировать все переменные среды, и `-s` - не добавлять директорию `site.USER_SITE` в `sys.path`
- `-S` - запрет импорта модуля `site`
- `O[O]` - удаление `assert`-ов, `__debug__`-зависимого кода и строк документации
- `-V` - вывод версии
- `-W` - управление предупреждениями
- `-x` -удаление shebang-строк
- `-h` - справка

Основные переменные среды:

- `PYTHONHOME` - префикс (путь к дереву инсталляции; как правило, `/usr`), указывающий на расположение интерпретатора и системных библиотек
- `PYTHONPATH` - расширяет `sys.path` - список мест поиска модулей. `sys.path` - это список строк, первая из которых пуста, или совпадает с текущеим каталогом (что одно и то же), а `PYTHONPATH` - разделенная двоеточиями строка каталогов (аналог `PATH`)
- `PYTHONSTARTUP` - скрипт, выполняющийся перед переходом в интерактивный режим

Рекомендуемый shebang для исполняемых скриптов:

```shell
#!/usr/bin/env python3
```

Управление виртуальными средами идет через модуль `venv`. Папка среды не обязана быть связанной с директорией исходного кода, более того, рекомендуется делать ее отдельной: это возможность иметь одну среду на несколько проектов. Стандартный порядок действий:

```shell
$ python3 -m venv <env-dir>
$ source <env-dir>/bin/activate
...
$ deactivate
```

В корне каталога `<env-dir>` создается файл `pyvenv.cfg`, по которому интерпретатор и определяет, что работа идет в виртуальной среде. В подкаталоге `bin/` создаются ссылки (или копии) на интерпретатор нужной версии. Таким образом, каталог среды хранит всю нужную информацию, и его уделание равно удалению виртуаьной среды.

Получение справки - встроенная функция `help()`. Для непустых строк она возвращает соответствующий раздел справки. Вызванная без аргументов, переводит REPL в режим справки. Кроме того, можно получить список методов через `dir()`, возможно, отсекая dunder-методы:

```python
[_ for _ in dir({}) if not _.startswith('__')]
```

---

# Лексическая структура языка, `[lexical]`

Язык регистр-чувствительный, это касается и ключевых слов и идентификаторов. Имена идентификаторов состоят из букв, цифр и подчеркивания, не могут начинаться с цифры, не могут содержать знаки препинания и прочие спец. символы. Длина не ограничена.

В именах идентификаторов допустим Юникод. В v2 Юникод может быть допустим только в строковых литералах и комментариях, и только если в первой или второй строке скрипта встречается директива (объявление) кодировки `# coding[:=]...`.

Код делится на логические строки, которые могут состоять из нескольких физических - завершающихся символом конца строки `\n`. Несколько физических строк объединяются в логическую если они заключены в скобки (круглые, квадратные или фигурные), или соединены обратным слешем (нерекомендуемый подход). Литералы строк на одной строке или в объединенных логических строках, конкатенируются автоматически.

Блок начинается с логической строки, оканчивающейся двоеточием `:`, - *заголовка*. *Тело* блока формируется отступами. Это могут либо пробелы либо табы, но не из смесь (`TabError`). Рекомендуемый отступ - 4 пробела. Использовать точку с запятой `;` для отделения инструкций не рекомендуется, лучше располагать каждую на новой строке.

Комментарии только однострочные (`#`), использовать тройные кавычки для имитации многострочных не рекомендуется.

В v3.8 35 ключевых слов, использовать их в качестве идентификатора запрещено (`SuntaxError`). Использовать имена встроенных функции для идентификаторов можно, но не рекомендуется.

Три специальных случая именования - лишь соглашения. Идентификаторы вида:

- `_*` - не предназначенные для импорта из модуля
- `__*__` - системные, т.н. "dunder"-идентификаторы
- `__*` - закрытые члены класса, автоматически искажаются интерпретатором (т.н. "name mangling")

Присваивания являются инструкциями, не возвращая таким образом свой левый операнд, и входить в выражения не могут (кроме присваиваний через walrus-оператор). Логические выражения вычисляются слева направо, по короткой цепи.

Стилистика кода описывается в PEP8

---

# Встроенные типы данных, `[builtin-types]`

Типизация языка *динамическая* - объявления не требуются, но *строгая* - на объекте можно выполнять только допустимые для его типа операции. Всё (кроме ключевых слов) является объектом, типы по сути те же классы. Получить тип объекта можно встроенной функцией `type()`.

Встроенные типы определены в модуле `builtins`, и доступны напрямую (импортируются неявно). Числа, строки (в том числе байтовые), синглеты, кортежи и `frozenset` - неизменяемые, а списки, словари, множества и `bytarray` могут модифицироваться in-place.

Числа представлены классами `int`, `float` и `complex`, эти типы приводятся друг к другу, всегда "расширяясь". Тип `int` может представлять целые числа неограниченного размера. Ограничения типа `float` можно посмотреть в кортеже `sys.float_info`; диапазон примерно `+/-e308`.

Можно использовать подчеркивание `_` в качестве разделителя разрядов. Буквы в литералах не чувствительны к регистру:

```python
10, 10_1, 0b10, 0o8, 0xff
.1_1, -4.5e-3
-2 + 2.3j
```

Символы `-`/`+` в записи - не часть литералов, это полноценные операторы, на которые распространяется приоритет. Конструкторы классов приводят строки к числам; `int()`, кроме того, принимает второй параметр - основание системы счисления. Обратный перевод - чисел в строки - возможен через встроенные функции `str()`, `bin()`, `oct()`, `hex()`

Четыре типа: `str`, `list`, `tuple`, и `bytes`, являются потомками `collections.abc.Sequence`, что дает доступ по индексу и/или срезу. В индексах и срезах допускаются отрицательные числа - они вычитаются из длины последовательности для приведения. Сами индексу удобно рассматривать как позиции *между* элементами.

Литералы строк - 4 вида кавычек, + `r''`- и `f''`-строки Юникода, и `b''` - байтовые строки. Внутри допускаются последовательности Юникода - 4-8 цифр после `\{u|U}`, или словесный код в `\N{...}`. Поведение управляющих символов (вроде `\n`) не зависит от типа кавычек.

Литерал кортежа определяется по запятой, скобки могут быть опущены:

```python
x = (1) # число
x = 1,  # кортеж
```

Литерал `{}` означает пустой словарь. Пустое множество, таким образом, литералом задано быть не может, и должно записываться как `set()`. Включения ("синтаксический сахар" для `map()`/`filter()`) же имеют схожий формат для всех коллекций:

```python
[x for x in ...]      # list
{x for x in ...}      # set
{x:y for x, y in ...} # dict
```

Конструкторы изменяемых коллекций, принимая итерируемый объект того же типа, возвращают его shallow-клон, а неизменяемых - ссылку на тот же объект:

```python
(id([]) == id(list([]))) == False
(id('abc') == id(str('abc'))) == True
```

Конструктор словаря, кроме того, может также принимать произвольное количество именованных аргументов, либо список пар (кортежей). В обоих случаях из этих аргументов формируется (новый) словарь. Словарь, как и остальные коллекции, итерируемый. По ключам.

Методы, специфичные для типа:

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

Отличие методов для строк:

```python
''.find('a') == -1
''.index('a') -> ValueError
```

Последовательности контролируют границы, при обращении по несуществующему индексу выбрасывается `IndexError`. То же и для словарей и множеств - попытка доступа до несуществующего ключа/элемента вызывает ошибку `KeyError`. Попытка доступа по значению (напр., в `.remove()`) до несуществующего элемента приводит `ValueError`.

---

# Регулярные выражения `[regexp]`