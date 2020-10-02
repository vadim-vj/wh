- <https://github.com/heykarimoff/solid.python>
- <https://blog.byndyu.ru/2009/10/solid.html>

---
> Что такое *SOLID*?

Акроним, означающий 5 основных принципов ООП и проектирования:

- *принцип единственной ответственности* (SRP, single responsibility principle)
- *принцип открытости/закрытости* (OCP, open–closed principle)
- *принцип подстановки Лисков* (LSP, Liskov substitution principle)
- *принцип разделения интерфейса* (ISP, interface segregation principle)
- *принцип инверсии зависимостей* (DIP, dependency inversion principle)

---
> Что означает *S* в SOLID?

*Принцип единственной ответственности*, SRP (single responsibility principle) - каждый класс должен иметь одну ответственность. Как писал Мартин, "классы должны иметь одну и только одну причину для изменений".

---
> Приведите примеры нарушения SRP

- класс отчета, имеющий как методы составления отчета (`.get{Header|Data|Footer}()`), так и методы его отображения (`.to{Print|HTML|XML}()`)
- класс модели, который имеет как геттеры/сеттеры, так и методы работы с базой данных

Вообще, чаще всего приводят примеры смешения бизнес-логики и работы с БД.

---
> Какой принцип ООП, как считается, нарушает паттерн ActiveRecord?

SRP, принцип единственной ответственности. Класс ActiveRecord содержит как логику работы с данными (геттеры/сеттеры), так и работу с БД (чтение/запись).

Вообще, нарушение этим паттерном SR-принципа считается спорным: как сам по себе объект, реализующий ActiveRecord, не содержащий никакой бизнес логики, а предоставляющий таблицу из базы данных, имеет лишь одну причину для изменения (изменение таблицы).

---
> Как можно разрешить нарушения SRP в классе?

Например, используя паттерн "Фасад":

```python
class Animal:
    def __init__(self, name: str):
        self.name = name
        self.db = AnimalDB()

    def get_name(self):
        return self.name

    def get(self, id):
        return self.db.get_animal(id)

    def save(self):
        self.db.save(animal=self)
```

Все методы сохранены, но логика работы с БД теперь в другом классе, а текущий служит лишь фасадом для вызовов методов этого другого.

---
> Что означает *O* в SOLID?

*Принцип открытости/закрытости*, OCP (open–closed principle) - программные сущности (классы, модули, функции и т. п.) должны быть открыты для расширения, но закрыты для изменения. Фактически, призывает к расширению классов только через наследование.

---
> Приведите примеры нарушения OCP

Это всегда оставление деталей реализации в коде. Например, группы `if`-ов/`case`-ов:

```python
def animal_sound(animal):
    if animal.name == 'lion':
        print('roar')
    elif animal.name == 'mouse':
       print('squeak')
```

Расширит такую функцию, не вмешиваясь в код, нельзя. Или

```cpp
public function doSomeWork() {
  return (new Server())->run();
}
```

Заменить сервер, не изменяя код клиента, здесь нельзя.

---
> Как можно разрешить нарушения OCP?

Вынесение деталей реализации в отдельные параметры/методы. Например, в параметры конструктора. Или отдельные методы, которые можно перекрыть в дочернем классе, изменив, таким образом, поведение.

```python
class Lion(Animal):
    def make_sound(self):
        return 'roar'

def animal_sound(animal):
    print(animal.make_sound())
```

---
> Что означает *L* в SOLID?

*Принцип подстановки Лисков*, LSP (Liskov substitution principle) - функции, которые используют базовый тип, должны иметь возможность использовать его подтипы, не зная об этом. По сути, на место объекта базового класса должно быть всегда можно подставить объект производного.

---
> Приведите примеры нарушения LSP

Это использование специфических методов (с проверкой или без) производных классов в контексте, где предполагается объект базового типа:

```python
def animal_leg_count(animal: Animal):
    if isinstance(animal, Lion):
        print(lion_leg_count(animal))
    elif isinstance(animal, Mouse):
        print(mouse_leg_count(animal))
    elif isinstance(animal, Pigeon):
        print(pigeon_leg_count(animal))
```

Более тонкие моменты - когда наследуемый класс так переопределяет поведение базового, что это приведет к ошибке бизнес-логики в вызывающей функции:

```python
def animal_leg_count(animal: Animal):
    assert animal.leg_count == 4
```

То есть при наследовании нужно учитывать, где используется интерфейс класса, и не сломает ли переопределение это использование.

---
> Как связаны OCP и LSP?

Это, в основном, касается примера с "лапшей" `if`-ов, проверяющих тип:

```cpp
public void Save(AbstractEntity entity) {
  if (entity is AccountEntity) {
    // специфические действия для AccountEntity
  }
  if (entity is RoleEntity) {
    // специфические действия для RoleEntity
  }
}
```

Добавление нового типа требует вмешательства в код класса - это нарушение OCP. В то же время, метод оперирует специфическими для дочерних классов методами, что является нарушением LSP.

---
> Что означает *I* в SOLID?

*Принцип разделения интерфейса*, ISP (interface segregation principle) - клиенты не должны зависеть от методов, которые они не используют. Слишком "толстые" интерфейсы необходимо разделять на более маленькие и специфические.

---
> Приведите примеры нарушения ISP

Основное - это абстрактные методы в базовом классе, которые требуют переопределения в дочерних. Если интерфейс базового класса слишком "широкий", то дочерние классы будут вынуждены переопределять ненужные им методы:

```python
class IBaseShape:
    def draw_square(self):
        raise NotImplementedError

    def draw_rectangle(self):
        raise NotImplementedError

    def draw_circle(self):
        raise NotImplementedError
```

В Python-е принцип актуален только при использовании `@abc.abstractmethod`, то есть только тогда, когда класс *обязан* определить тело абстрактного метода.

---
> Что означает *D* в SOLID?

*Принцип инверсии зависимостей*, DIP, (dependency inversion principle):

- модули верхнего уровня не должны зависеть от модулей нижнего уровня. Оба должны зависеть от абстракции
- абстракции не должны зависеть от деталей. Детали должны зависеть от абстракций

---
> Приведите примеры нарушения DIP

Зависимость класса/модуля от конкретного класса более низкого уровня:

```python
# модуль нижнего уровня
class XMLHttpService:
    pass

# модуль верхнего уровня
class Http:
    def __init__(self, xml_http_service: XMLHttpService):
        ...
```

Жесткая зависимость от конкретного (низкоуровнего) класса не позволяет заменить его на другой / протестировать с заглушкой.

---
> Как можно разрешить нарушения DIP в классе?

Ввести дополнительный уровень косвенности - абстракцию, от которой будут зависеть модули и верхнего, и нижнего уровней. Промежуточное звено - базовый класс:

```python
# новая абстракция
class Connection:
    pass

# модуль нижнего уровня
class XMLHttpService(Connection):
    pass

# модуль верхнего уровня
class Http:
    def __init__(self, http_connection: Connection):
        ...
```

Теперь от этой новой абстракции можно наследовать любые классы, и свободно использовать их в модуле верхнего уровня (по LSP).

####----####

- паттерн "Фасад", когда применяется
- паттерн "Выделение частного класса данных"
- паттерн "Proxy"
- Data Access Object (DAO)
- God object
- GRASP
- Separation of Concerns
- Chain of responsibility