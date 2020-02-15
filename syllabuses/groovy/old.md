# Groovy language (local)

## Общие заметки
- язык чувствителен к регистру, как и Java
- поддерживает перегрузку методов и операторов
- объекты присваиваются/передаются по ссылке
- допустимо сравнение объектов через `==` и ссылок через `A.is(B)`
- множественное наследование (стандартно) поддерживается только для интерфейсов; для классов только через trait-ы

## Style guide
[https://groovy-lang.org/style-guide.html](https://groovy-lang.org/style-guide.html)

- не ставить `;`
- не использовать `return` по возможности
- не использовать `def` с типом: ~~`def String name = ...`~~
- `def` в параметрах методов и в объявлении конструкторов лишний, не нужно там его использовать
- но лучше использовать явное указание типа (для IDE, самодокументируемого кода и проверок на этапе компиляции)
- общее правило: использовать явную типизацию в публичных интерфейсах, контрактах и API. В приватном коде, во внутренних методах, можно использовать `def`
- не использовать модификатор доступа `public`: он и так по дефолту
- опускать скобки когда возможно (`println "Hello"`, `method a, b` (вызов метода), `list.each  { println it }` etc.)
- опускать суффикс `.class`: объекты первого класса (`ResourcesResponse` вместо `ResourcesResponse.class`)
- не объявлять и не использовать геттеры/сеттеры: `.name = "something"` вместо `.setName("something")` (а boilerplate code генерируется автоматически)
- не объявлять дефолтный конструктор и не инициализировать поля явно, вместо этого использовать сгенерерированный дефолтный конструктор (`def server = new Server(name: "Obelix", cluster: aCluster)`)
- использовать `with()` и `tap()` чтобы не повторять имя объекта и не вычитывать его во временную переменную
- использовать `==` вместо `equals()` (заодно это позволяет избежать проверки на `null`)
- строки:
  * предпочитать interpolated strings (строки в стиле Groovy) обычной конкатенации (`+`)
  * предпочитать (dollar) slashy string для регулярных выражений
  * но при этом предпочитать строки в одинарных кавычках для констант
- использовать синтаксис Groovy (не Java) для списков, карт, паттернов и диапазонов
- использовать методы Groovy для итерации по коллекциям (`each{}`, `find{}`, `findAll{}`, `every{}`, `collect{}`, `inject{}`; см. GDK)
- по максимуму использовать возможности `switch` (возможность использовать в `case`-ах произвольные типы, поддерживающие `.isCase()`)
- использовать псевдонимы импорта для исключения дублирования (`import java.util.List as UtilList`, `import java.awt.List as AwtList`)
- использовать в `if`, `while` etc. неявную проверку на истинность ("Groovy truth") вместо явных (`if (name) { ... }` вместо `if (name != null && name.length > 0) { ... }`), либо даже переопределять `.asBoolean()` у классов для возможности такой проверки
- использовать оператор безопасного доступа `?.` вместо явных проверок
- использовать `assert`
- использовать короткий тернарный оператор `?:` (т.н. "Elvis operator")
- не указывать тип перехватываемого исключения в блоке `catch`, если нужно ловить всё

## Комменты
- 4 вида: `//`, `/* */`, многострочные `/** */` (groovy-doc) и т.н. shebang line (`#!/usr/bin/env groovy`)
- groovy doc для аннотаций, но может быть везде, где и обычный multiline, хоть в середине конструкции
- groovy doc может иметь звездочки в новых строках
- shebang line: исполняемый `./test.sh` запустит скрипт

## Ключевые слова
[https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#\_keywords](https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#_keywords)

## Имена переменных
- могут начинаться с `[a-zA-z_$]` (и буквы юникода), не могут начинаться с цифры
- закавыченные могут использовать любой из шести типов строк и даже без квадратных скобок: `x.$/blah-blah-blah/$`
- в закавыченных первой идет подстановка: `map."Simpson-${firstname}" == map.'Simpson-Homer'`

## Строки
- шесть типов (`java.lang.String` если нет переменных, и `groovy.lang.GString` (т.н. "interpolated strings") если есть):
  * `'single quote'` - всегда `java.lang.String`
  * `"double quote"`
  * `'''triple single quote'''` - всегда `java.lang.String`
  * `"""triple double quote"""`
  * `/slashy string/` - нужно эскейпить только прямой слеш (multiline; для регулярок и паттернов)
  * `$/dollar slashy string/$` - не нужно эскейпить ни доллар (но подстановки идут), ни прямой слеш (multiline; паттерны со слешами, символ эскейпа - `$`)
- тройные - heredoc; помнить про перенос строки в начале и возможность его стрипа (`'''\`)
- ни `'` ни `"` не нужно эскейпить внутри тройных кавычек
- и `'` и `"` *можно* эскейпить в другом типе кавычек, но не обязательно (зачем это?)
- во *всех* кроме одинарных кавычек (interpolated strings) разворачиваются переменные
- вообще говоря, содержимое `${...}` по умолчанию анонимной функцией не является, только если есть стрелка внутри. Если нет - то строка вычисляется один раз, в момент объявления
- если же там замыкание - строка вычисляется каждый раз в момент использования (например, учитывает изменившееся значение внешних переменных)
- такие замыкания могут иметь 0 или 1 параметр, иначе `groovy.lang.GroovyRuntimeException`. В замыкание передается экземпляр `org.apache.groovy.io.StringBuilderWriter` - собственно обрабатываемая строка. Добавлять в нее контент можно оператором `<<` (типа как в потоки?)
- `${...}`, без фигурных скобок допустимы только поля: `$map.x` (по пробелу?), иначе исключение (`groovy.lang.MissingPropertyException`): `$map.toString()` (`== ${number.toString}()`)
- т.н. dotted expression недопустимы еще и когда первая переменная - не объект: `$thing.x != ${thing}.x`
- подставлять можно хоть константы: `"The message is ${'hello'}"`
- хэши GString не совпадают с результатом подстановки: `assert "one: ${1}".hashCode() != "one: 1".hashCode()`. Поэтому нужно избегать использования interpolated strings в качестве ключей карты (`def m = ["${key}": "letter ${key}"]`): неизвестно как потом обращаться к ним, даже если результат подстановки известен
- в slashy strings (`/blah blah/`) действуют какие-то другие правила эскейпа (типа `"$()"` или `"$5"` дают ошибку, а `/$()/` `/$5/` нет), но эти правила нигде не описаны. Пустую строка задать ими нельзя (неразличима с комментарием, `assert '' == //`)
- для эскейпа плейсхолдера достаточно эскейпить только доллар: `'${name}' == "\${name}"`
- конкатенация - плюсом: `assert 'ab' == 'a' + 'b'`
- эскейп так же - обратным слешем
- спецсимволы те же (`\t`, `\n` etc.)
- символы юникода: `'The Euro currency symbol: \u20AC'`
- для переноса строк можно использовать не только тройные кавычки, но и обратный слеш
- передача GString в метод с явным параметром `java.lang.String` вызовет подстановку (`toString()`)
- Groovy не имеет отдельного класса для символов, но можно привести тремя способами (`char c1 = 'A'`, `def c2 = 'B' as char`, `def c3 = (char)'C'`: all to `Character`)
- строки можно умножать: `assert 'blah' * 2 == 'blahblah'`
---
- вызов методов возможен напрямую на литералах: `"one: ${1}".hashCode()`
- нужны списки функций (`stripIndent`, `stripMargin`, `startsWith`, `hashCode` etc.)

## Числа
- 6 целочисленных типов (в скобках суффиксы литералов): `byte`, `char` -> `Character`, `short` -> `Short`, `int` -> `Integer` (`I`/`i`), `long` -> `Long` (`L`/`l`) и `java.lang.BigInteger` (`G`/`g`); через `def` выводятся только последние 3
- 3 вещественных типа (в скобках суффиксы литералов): `float` -> `Float` (`F`/`f`), `double` -> `Double` (`D`/`d`) и `java.lang.BigDecimal` (`G`/`g`); через `def` выводится только последний
- 3 префикса: `0b` (binary), `0` (octal) и `0x` (hexadecimal)
- вещественные литералы могут использовать степень: `2E4`, `3e+1`, `4E-2` etc.
- цифры в литералах можно группировать через подчеркивание, произвольным образом: `12_345_132.12`, `1234_5678_9012_3456L` etc.
- операции:
  * целые + дробные = дробное
  * `/` или `/=` = всегда дробное, для целочисленного деления нужно использовать `.intdiv()`
  * `**` - возведение в степень, если можно представить результат в целом типе, то использует его, иначе дробный
  * таблица типов: [https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#\_math\_operations](https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#_math_operations)

## Boolean
- тип `boolean`/`java.lang.Boolean`
- стандартные литералы `true`/`false`

## Коллекции
- класс `java.util.ArrayList`, интерфейс `java.util.List` - гетерогенные списки переменного размера. Дефолтный тип, задаваемый литералом `[]`: `def letters = ['a', 'b', 'c', 'd']`
- `<Type>[]` (напр., `String[] arr = ['test']`, `def arr = [1, 2, 3] as int[]` или `def matrix3 = new Integer[3][3]`) - типизированные массивы фиксированного размера
- оба имеют метод `.size()`
- оператор `<<` ("левый сдвиг") используется для вставки элемента в конец (`letters << 'e'`)
- в обоих обращение к элементам идет через оператор `[]` и целочисленные индексы
- отрицательные индексы начинают отсчет с конца: `assert letters[-1] == 'd'`
- можно получать/присваивать части списков, через перечисление (`assert letters[1, 3] == ['b', 'd']`) или диапазоны (`assert letters[2..4] == ['c', 'd', 'e']`)
- многомерные списки: `def multi = [[0, 1], [2, 3]]; assert multi[1][0] == 2`
- пустой список: `[]`

## Карты
- в других языках могут называться словарями или ассоциативными массивами
- синтаксис литералов как у объектов в JS, только скобки квадратные: `def colors = [red: '#FF0000', green: '#00FF00', blue: '#0000FF']`
- обращение к полям как у объектов в JS: `assert colors.unknown == null`, `colors['pink'] = '#FF00FF'`
- тип `java.util.LinkedHashMap`
- возможны ключи произвольных типов: `def numbers = [1: 'one', 2: 'two']`
- ключ из переменной - через круглые скобки: `person = [(key): 'Guillaume']`
- пустая карта: `[:]`

## Основные операторы
- всё те же (`%=` - остаток от деления, `**=` - возведение в степень)
- оператор сравнения только один - `==` (и `!=`) (метод `a.equal(b)`), тройной заменяется `a.is(b)`
- приоритеты стандартные, вычисление по короткой цепи
- тернарный в двух формах, короткой ("Elvis operator") и полной
- логические операторы возвращают `boolean`, а не свои операнды, как в JS. Короткие выражения писать не получится
- оператор безопасного доступа `?.` возвращает поле или `null`
- оператор прямого доступа к полю `.@` возвращает значение в обход геттера
- оператор получения указателя на метод `.&` возвращает `groovy.lang.Closure`, так что результат можно сохранять в переменной/передавать всюду, где требуются замыкания. С v3 может вызываться и на классе, не только на объекте (но первым аргументом должен получать объект: `assert String.&toUpperCase('foo') == 'FOO'`). С v3 можно получать указатель на конструктор: `assert BigInteger.&new('42') == 42G`
- с v3 доступен оператор расширения области видимости `::`. В динамическом Groovy (что это?) - просто псевдоним предыдушего, но есть какие-то отличия для статических методов классов

## Регулярные выражения
- оператор `~<строка>` создает объект класса `java.util.regex.Pattern`
- стандартно используются (dollar) slashy строки. "Cобрать" паттерн легко, ведь подстановки в строках допустимы (`~/${var1}_${var2}/`)
- оператор поиска `<текст> =~ <паттерн>` возвращает объект класса `java.util.regex.Matcher` или `null`, если нет совпадений
- Groovy truth для матчера - это вызов `m.find()` (`if (!m)` эквивалентно `if (!m.find())`)
- оператор совпадения `==~` возвращает не матчер, а `true`/`false`

## Прочие операторы
- спред полей объектов `*.` для списков:
  * возвращает список значений поля из каждого объекта: `assert [[make: 'Peugeot'], [make: 'Renault']]*.make == ['Peugeot', 'Renault']`
  * эквивалент `.collect{ it.make }`)
  * вообще, доступ к несуществющему полю на агрегате компилятор поймет (`[].make` ~ `[]*.make`), но явный оператор предпочтительней
  * null-безопасен: `assert null*.make == null`
  * может быть вызван на любом (кастомном) классе, имплементирующем интерфейс `Iterable`
  * поддерживает последовательный вызов на свойствах-агрегаторах: `cars*.models*.name` (эквивалент `.collectNested{ it.model }`)
- спред элементов списков `*`:
  * стандартно: `[1, 2, 3, *items, 6]`
  * можно вызвать функцию N аргументов: `def args = [4,5,6]; assert function(*args) == 26`
  * для карт это даст ошибку, нужно использовать `*:`: `[a:1, b:2, *:m1]`
  * для карт важна позиция спреда: следующие ключи перетирают предыдущие: `def m1 = [c:3, d:4]; assert [a:1, b:2, *:m1, d: 8] == [a:1, b:2, c:3, d:8]`
  * эквивалент `.addAll()` (но это не точно)
- диапазон `..`:
  * легковесный (сохраняются только границы) объект класса `groovy.lang.Range`
  * вызов `.collect()` на диапазоне генерирует `ArrayList`, `.size()` дает размер
  * может быть вызван на любом (кастомном) классе, имплементирующем интерфейс `Comparable`
  * эквивалент `next()`/`previous()`-методов
- оператор `<=>` ("spaceship") - трехстороннее сравнение (-1, 0, 1), эквивалент `.compareTo()`-метода
- оператор индекса `[]`:
  * эквивалент `.getAt()`/`.putAt()`, в зависимости от позиции (слева/справа)
  * поддерживает перечисления (`assert letters[1, 3] == ['b', 'd']`) и диапазоны (`assert letters[2..4] == ['c', 'd', 'e']`)
- оператор принадлежности `in`:
  * `assert 'Emmy' in ['Grace','Rob','Emmy']`
  * эквивалент `.inCase()`
  * для списков эквивалент `.contains()`
- оператор приведения `as`:
  * `String s = 123 as String` (аналог `String s = (String)123`)
  * оператор возвращает новый объект (идет вызов `new`). Исключение - когда типы совпадают (тривиальный случай)
  * эквивалент `.asType()`
- оператор вызова `()`, эквивалент `.call()`: `assert mc(2) == mc.call(2)`

## Приоритет операторов
[https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#\_operator\_precedence"](https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#_operator_precedence)

## Пакеты и импорт
- имена пакетов совпадают с `<имя-директории>.<имя-класса>`, указываются первой строчкой в файле класса
- потом директивы импорта, но можно и писать имена классов целиком
- имена директорий целиком в нижнем регистре, имена классов в PascalCase
- Groovy по дефолту импортирует [кучу всего](https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#_default_imports_2)
- 3 типа импорта: обычный (`import groovy.xml.MarkupBuilder`), со звездочкой (`import groovy.xml.*`) и статический (`import static Boolean.FALSE`)
- статический позволяет использовать метод/свойства без указания класса (делает их статическими в текущем классе)
- в Groovy статически импортированные методы могут быть перегружены
- оператор `as` позволяет задавать псевдонимы импорта, как в динамике (`import java.sql.Date as SQLDate`) так и в статике (`import static Calendar.getInstance as now`)

## Генерация класса по скрипту
- имя класса будет совпадать с именем файла (регистр тоже)
- модификатор доступа класса - `public`, предок `groovy.lang.Script`
- `public class aggregate extends groovy.lang.Script { ... }`
- функции, объявленные в скрипте, станут методами класса
- весь код скрипта пойдет в метод `.run()`
- есть разница между объявлением `int x = 3;` и `x = 3` в скрипте:
  * первая даст локальную переменную внутри `.run()` и не будет доступна в функциях (ставших методами класса)
  * вторая пойдет в биндинг скрипта (?) и будет видна в методах класса
  * того же эффекта, не помещая переменную в биндинг (а делая ее свойством класса) можно достичь через аннотацию: `@groovy.transform.Field String name = 'test'`
- в файле можно смешивать код и классы
- для каждого класса будет сгенерирован отдельный файл с тем же именем, что и имя класса
- любой файл, содеражищий код вне класса, рассматривается как скрипт: `public class aggregate extends groovy.lang.Script { ... }`. Поэтому нельзя объявлять в скрипте класс с именем, совпадающим с именем файла скрипта

## Классы
- классы без модификаторов доступа по умолчанию `public`
- поля без модификаторов доступа автоматически становятся свойствами (`public`, генерируются геттеры и сеттеры)
- можно объявлять (так же как методы и свойства) внутренние классы:
  * `class Outer { class Inner { ... } }`
  * может быть `static`, тогда доступен извне (`new Outer.Inner()`)
  * все, даже приватные, свойства и методы этих классов перекрестно доступны обоим
  * внутренние классы улучшают инкапсуляцию и группировку кода
  * можно объявлять анонимные внутрение классы (in-place): `new Interface()`. Только через интерфейс
- ключевое слово `abstract` - стандартно
- интерфейсы - `interface`/`implements`, в принципе стандартно:
  * могут наследоваться, в том числе множественно
  * могут использоваться в `instanceof`
  * поддерживается приведение к типу интерфейса в рантайме: `greeter as Greeter`
- конструкторы:
  * объявление через имя, совпадающее с именем класса
  * поддерживается перегрузка
  * бывают с позиционными и именованными параметрами, можно передавать карту
  * можно приводить через `as` или объявление типа: `def person2 = ['Marie', 2] as PersonConstructor` или `PersonConstructor person3 = ['Marie', 3]`
  * можно через аннотации `groovy.transform.TupleConstructor` или `groovy.transform.MapConstructor`
- методы:
  * по дефолту `public`, можно указывать `def` как возвращаемый тип
  * указав карту первым параметром, потом можно вызывать с любым порядком аргументов
  * поддерживаются аргументы по умолчанию
  * varargs: `def foo(Object... args) { args.length }` или `def foo(Object[] args) { args.length }`
  * передача `null` в varargs даст `null`, не пустой массив
  * при вызове varargs с массивом его можно не спредить: `def foo(Object... args) { args }; assert foo([1, 2]) == [1, 2]`
  * перегруженные varargs-методы имеют низкий приоритет
- исключения можно указывать рядом с методами: `def badRead() throws FileNotFoundException { ... }`
- поля и свойства:
  * стандартные модификаторы доступа
  * `final`/`static`/`synchronized` (блокировка для потокобезопасности)
  * тип опционален (но лучше указывать)
  * инициализация через `=`: `public static final boolean DEBUG = false`, не только константы: `private String id = IDGenerator.next()`
  * стандартно: поле без модификатора, по нему Groovy сгенерирует приватное свойство и геттер/сеттер (Java Beans)
  * c `final` у поля не генерируется сеттер, нужно задавать значение в конструкторе или в объявлении
  * доступ к полю идет напрямую, если внутри класса, и через геттер/сеттер если извне
  * все свойства объекта: `obj.properties`
  * геттеры/сеттеры могут имитировать поле, даже если его физически нет
- аннотации:
  * похожи на интерфейсы, объявление: `@interface SomeAnnotation { String value() default '/home' }`
  * использование: `@SomeAnnotation void someMethod() { ... }`, `@SomeAnnotation class SomeClass { ... }`, `@SomeAnnotation String var`
  * в объявлении можно лимитировать, где допустима, через `@Target` (аннотация для аннотации)
  * при использовании нужно объявить все свойства аннотации, не имеющие дефолтных значений: `@Page(value='/home')`
  * в объявлении можно лимитировать retention policy (?; compile time or runtime), через `@Retention` (аннотация для аннотации)
  * в Groovy аннотации могут получать замыкания (дальше идет мутный пример для `@OnlyIf`)
  * если в объявление аннотации вставить несколько других аннотаций и `@AnnotationCollector`, то получится мета-аннотация - псевдоним, объединяющий их всех (Groovy-only feature)
  * и там еще много про мета-аннотации, как компилятор (препроцессор?) их разворачивает, как подставляет параметры и обрабатывает дубликаты

## Traits

## Замыкания
- по дефолту в замыкании доступны все внешние переменные
- `{ [closureParameters -> ] statements }`
- являются объектами класса `groovy.lang.Closure`: `Closure<Boolean> isTextFile = { ... }`
- анонимные in-place вызовы возможны, только если возвращаемое значение не указано явно, иначе нужно явное именование
- неявный (первый) параметр `it` в обычных методах вроде не поддерживается
- для запрета `it` и задания пустого списка аргументов: `def magicNumber = { -> 42 }`
- поддерживают varargs стандартным способом
- замыкания отличаются от лямбд в Java8. Спец. переменные внутри замыкания:
  * `this` - *объект*, в классе которого замыкание *определено*. Можно получать напрямую и через `getThisObject()`, лучше использовать `this` напрямую
  * `owner` - *объект*, в классе которого замыкание *определено* (класс или *другое замыкание* - в этом отличие от `this`), `getOwner()`
  * `delegate` - по умолчанию равен `owner`, `getDelegate()`. Можно установить в любой объект и вызывать, причем `delegate.` к вызовам методов подставляется автоматически
  * можно самому устанавливать стратегии выбора делегата в замыкании (`Closure.OWNER_FIRST`, `Closure.DELEGATE_ONLY` etc.): `cl.resolveStrategy = Closure.TO_SELF`
- для использования в `GString`: `${-> x}`, тогда строка будет вычисляться каждый раз при использовании, станет динамической
- каррирование: `closure.curry(<аргументы-с-начала>)`, `closure.rcurry(<аргументы-с-конца>)`, `closure.ncurry(<index>, <аргументы-с-<index>-позиции>)`
- мемоизация: `def cl = { ... }.memoize[AtMost|AtLeast|Between]()` будет кешировать результаты вызовов. Ускоряет, например, рекурсивные вызовы с теми же аргументами
- композиция - операторы `>>` и `<<`: `assert (cl1 << cl2)() == cl1(cl2())` и `assert (cl1 >> cl2)() == cl2(cl1())`
- развертывание хвостовой рекурсии в цикл: `cl.trampoline()`
- обычный метод может быть использован как замыкание через `.&` оператор
- замыкание может быть приведено (через `as`) к SAM (single abstract method) - любому абстрактому классу, определяющему ровно один абстрактный метод: `({ 'Groovy' } as Greeter).greet()`
- и вообще замыкание можно привести к любому типу


## Семантика
- `def` ~ `Object`, не забывать про дженерики (`List<String> names`)
- множественное присваивание: `def (a, b, c) = [1, 2]`. Так же можно разваливать объекты, если у них перегружен оператор индекса (`.getAt()`/`.putAt()`): `def (la, lo) = coordinates`
- управляющие структуры стандартные, в C-стиле
- цикл перебора коллекций: `for (i in [0, 1, 2, 3, 4]) { ... }`
- `try`/`catch` поддерживает `finally` и перечисление классов исключений: `catch ( IOException | NullPointerException e )`
- неотключаемые утверждения дают подробную информацию при ошибке: `assert [left expression] == [right expression] : (optional message)`
- поддерживает метки (`label:`) и переходы на них по `break`-у из циклов и свитчей. `goto` вроде нет
- GPath - язык описания графа объектов. Из нудных восторгов по его поводу понятно только, что можно искать имена методов: `this.class.methods.name.grep(~/.*Bar/)`
- приведение типов (`as`):
  * замыкания приводятся к SAM и вообще к любым типам
  * карты приводятся к объектам (ключи - имена методов и свойств). Причем исключения будут только при вызовах несуществующих методов, не при приведении
  * строки к enum-ам вообще приводятся неявно, включая использование в свитчах
  * приведение произвольных типов - через перегрузку метода `.asType()`
  * `as` работает только с литералами, не с рефлекшном: `as Class.forName('Greeter')` выбросит исключение
- опциональность:
  * круглые скобки нужны только для методов без параметров или если неоднозначность: `println(); println(Math.max(5, 10))`
  * опциональны `;`, `return` и `public`
- Groovy truth: пустые строки, списки, карты, ноль (сравни с JS). Можно перегружать метод `.asBoolean()`

## Типизация
- возвращаемый тип у метода может быть опущен, но тогда нужем модификатор доступа, чтобы отличить объявление метода от его вызова
- аннотация `@groovy.transform.TypeChecked` включает статичискую проверку типов при компиляции
- аннотация `@groovy.transform.TupleConstructor` дает возможность использовать (генерирует) два типа конструкторов: обычный `Person classic = new Person('Ada','Lovelace')`, и из списка `Person list = ['Ada','Lovelace']`. Из карты (с доп. проверками) работает и без аннотации: `Person map = [firstName:'Ada', lastName:'Lovelace']`
- для потокобезопасности рекомендуется явно определять тип полей, методов и прочего API. Для локальных переменных допустим `def`
- много воды про вывод типов для `def`, про Least upper bound (LUB) типов
- интересное объявление дженерика: `List<? extends Serializable> list = []`
- компилятор учитывает последнее присвоенное значение `def`-переменной, и позволяет вызывать соотвествующие методы (это называется "flow typing") даже с аннотацией `@groovy.transform.TypeChecked`: `def o = 'foo'; o = o.toUpperCase(); o = 9d; o = Math.sqrt(o)`
- для замыкания использовать тип возвращаемого значения `def` нормально, а для методов класса нежелательно, из-за перегрузки
- иногда компилятор не может вывести тип неявного параметра `it` в замыканиях, и нужно явно его декларировать
- можно аннотировать параметры типа замыкания, решая предыдущую проблему (указывая тип параметра замыкания): `@ClosureParams(FirstParam)`
- статический тайп-чекер `@groovy.transform.TypeChecked` уязвим для monkey-патчей, изменение классов в рантайме он отловить не может. Это говорит о том, что статическая проверка динамических по натуре программ Groovy - плохая идея
- поэтому есть альтернатива - аннотация `@groovy.transform.CompileStatic`. Происходит статическая компиляция в байт-код, и все манки-патчи (типа `Computer.metaClass.compute = { ... }` просто перестают работать (даже хотя метакласс изменился, сам байт-код остался неизменным)
- преимуществами статической компиляции являются типобезопасность и более высокая производительность
- упоминается какой-то "invokedynamic" Groovy, который может быть так же быстр, как статически скомпилированный код
- можно написать свое расширение для статической проверки типов (например, для очень динамичных билдеров): `@TypeChecked(extensions='/path/to/myextension.groovy')`

## Отличия от Java
- основные пакеты импортируются по дефолту: [https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#\_default\_imports\_2](https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#_default_imports_2)
- выбор перегруженного метода происходит в рантайме, не при компиляции: `int method(String arg) { 1 }; int method(Object arg) { 2 }; Object o = "Object"; assert 1 == method(o)` (выбрана строка, рантайм; в Java будет выбран `Object`: `assert 2 = method(o)`)
- т.к. фигурные скобки зарезервированы для замыканий, массивы с их помощью объявлять нельзя: ~~`int[] array = { 1, 2, 3}`~~. Только через квадратные: `int[] array = [1,2,3]`
- если у поля класса опустить модификатор доступа, то это не приведет к созданию package-private поля (?), как в Яве, а создаст свойство класса (приватное поле + геттер/сеттер). Для достижения такого же, как в Java, эффекта нужно указать аннотацию: `@PackageScope String name`
- внутренние классы:
  * лучше всего поддерживаются статические члены: `class A { static class B {} }; new A.B()`
  * анонимные классы (а без интерфейсов это можно сделать, интересно?): `schedule(new TimerTask() { ... })`
  * какая-то муть про создание экземпляра внутреннего класса, `new X(y)` вместо `y.new X()`
- с v3 можно получать ссылки на статические методы через оператор `::`: `[].each(System.out::println)`. В более ранних версиях нужно использовать замыкания: `[].each { println it }`
- GString и String же, хотя компилятор и приводит типы один к другому
- тип "символ" можно получать из строк приведением (`char a = 'a'`, `"c" as char` или `(char) "c"`), отдельного нет
- все примитивные типы обертываются в объекты. Это в том числе влияет на выбор перегруженного метода: `void m(long l) { 1 }; void m(Integer i) { 2 }; int i; assert 2 == m(i)` (выбран объект-обертка, точное совпадение; в Java будет выбран `long`: `assert 1 == m(i)`, т.к. расширение инта приоритетнее unboxing-а)
- оператор `==` в Groovy преобразуется в `a.compareTo(b)==0`, если объекты имплементируют интерфейс `Comparable`, и в `a.equals(b)` иначе
- преобразования сужение/расширения типов происходят немного по-разному. Огромные ненужные [таблицы](https://docs.groovy-lang.org/docs/groovy-3.0.0-beta-2/html/documentation/#_conversions)
- Groovy объявляет 4 дополнительных ключевых слова: `as`, `def`, `in`, `trait`

## Groovy Development Kit (GDK)
- файлы:
  *
  *

---

## Типы
- различать `String` (`java.lang.String`) и `GString` (`groovy.lang.GString`)
- приведение типов через оператор `as`: `def linkedList = [2, 3, 4] as LinkedList`

## I/O
- `println /blah blah/` почему-то не работает