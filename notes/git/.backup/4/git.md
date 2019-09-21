# 1. Введение

Эти заметки - всего лишь попытка описать, зачем нужен Git, почему в нем приняты те или иные технические решения, почему сделано так, а не иначе. Приведенная здесь информация не претендует ни на полноту, ни на точность. Это рабочий набросок, достаточно краткий. Большинство тем раскрыто тезисно, без деталей. Отсутствуют рисунки, листинги, в общем вся инфографика. Терминология не унифицирована.

Для начинающего программиста Git/Github нужен, главным образом, для трех целей:

- Централизованного бекапа своих pet-проектов
- Хранения/показа своего портфолио
- Добавления строчки в резюме о знании Git

## 1.1. О бекапе и [ГитХабе](http://github.com)

На случай отказа/поломки локального жесткого диска, свои проекты лучше бекапить где-нибудь в сети, на отказоустойчивых серверах. Это дает и дополнительный плюс - код можно скачивать и развертывать на другой машине. Для хранения проектов с кодом существуют специализированные (бесплатные) сервисы. Наиболее популярным из них является GitHub.

- Git - это сама система управления кодом проектов (консольные команды, протоколы передачи и т.д.)
- GitHub - это сайт в сети (<http://github.com>), предоставляющий услуги хранения проектов (репозиториев)

## 1.2. О портфолио

ГитХаб сейчас, де-факто, является стандартным местом для хранения портфолио программиста. Ссылка на ГитХаб в резюме очень желательна, это визитная карточка специалиста. Сам GitHub позиционирует себя как "социальную сеть для программистов", предоставляя много полезных функций помимо простого хранения. Пользоваться им, и наполнять свой аккаунт очень желательно.

## 1.3. О строчке в резюме

На самом деле, это немного больше чем просто строчка. Научиться работать с Git рано или поздно придется потому, что команды программистов при разработке используют несколько другой подход, чем программист-одиночка для своих частных проектов. При промышленной разработке обычно держат (часто не одну) стабильную версию софта, а команда, работая параллельно, вносит исправления и новый функционал в ее копии, впоследствии объединяя всё это в новую стабильную версию. Для такого подхода нужны т.н. "системы контроля версий" (Version Control System, VCS) - программы, управляющие кодом/целыми проектами. Git сейчас наиболее популярная из таких систем, и будущие работодатели будут требовать его знания.

## 1.4. Порядок изучения

Для большинства программистов достаточно будет изучить базовый набор концепций и команд. Сделать это можно, например, прочитав первые главы книги ProGit. В этих же заметках изложение начинается с внутреннего устройства Git, и ведется гораздо более подробно, чем это нужно большинству разработчиков.

![Base commands](images/main-1.png)

---

# 2. Немного истории

`<!-- TODO: при желании дописывать -->`

Git сделан для разработки ядра Линукс, это его изначальное и основное назначение. Это предполагает работу с консолью, команду в тысячи человек (массовая параллельная разработка), распространение патчей по электронной почте, и много других вещей, кажущихся отдельному девелоперу (или небольшой команде) странными и просто лишними. Но это лишь потому, что GitHub популяризировал Git, сделал его обязательным инструментом для всех. Так что не стоит удивляться сложности или нелогичности системы: она изначально была рассчитана на другие, отличные от ваших личных, цели.

---

# 3. Ресурсы и ссылки

## 3.1. Книги

Систематическое изложение материала по Git-у есть в книгах, на начальном этапе очень желательно начать с них. Что-то вроде официального руководства - книга ProGit, доступная на официальном сайте, как для онлайн-чтения, так и для скачивания в pdf, epub и mobi форматах.

- Английская версия на оф. сайте: <https://git-scm.com/book/en/v2>
- Русская версия на оф. сайте переведена не до конца, но довольно много: <https://git-scm.com/book/ru/v2>
- Есть полностью переведенная русская версия, доступна в сети: <https://www.piter.com/collection/all/product/git-dlya-professionalnogo-programmista-2>
- Исходники книги постоянно обновляются, доступны на GitHub-е. Можно клонировать репозиторий себе и собирать html/pdf/прочее самому: <https://github.com/progit/progit2>

Подборка других книг есть на оф. сайте: <https://git-scm.com/doc/ext>, да и вообще книг по нему в сети достаточно много.

## 3.2. Man-страницы

`<!-- TODO: упростить как-нибудь часть про доп. разделы справки -->`

Наиболее полным источником материала по Git-у являются его man-страницы. Идут вместе с самой системой. Есть их html-версии, и я рекомендую пользоваться именно ими. Включается при помощи `git config --global help.format web`, после чего страницы помощи начнут открываться в браузере. Вызов помощи идет через `git help <command|guide>`. Другие варианты менее предпочтительней: `man git-<command|guide>` не позволяет просматривать страницы через браузер и открывать ссылки, а `git --help` требует помнить порядок следования команды/гайда и опции `--help` (`git <guide> --help` выдаст ошибку, произвольный порядок работает только для команды).

- `git help` без аргументов выдаст краткую справку со списком команд и подсказками
- Вызов справки по команде: `git help <command>`
- У помощи Git-а есть несколько тематических разделов, т.н. "гайдов" (guides). Полный их список можно получить через `git help -g | --guides`
- Вызов любого гайда из списка осуществляется так же, как и для команды: `git help guide`
- Два особых случая: `git help help` покажет справочную страницу для команды `help`, а `git help git` выдаст главную справочную страницу программы
- С этой главной страницы можно перейти, например, на страницу Git User Manual ([/usr/share/doc/git-doc/user-manual.html][um]), а также в такие специфические разделы как Git Howto Index ([git-doc/howto-index.html][hti] -> [git-doc/howto/][ht]) и Git API Documents (internal Git API, [git-doc/technical/api-index.html][api] -> [git-doc/technical/][ap])

[um]:  file:///usr/share/doc/git-doc/user-manual.html
[ht]:  file:///usr/share/doc/git-doc/howto/
[hti]: file:///usr/share/doc/git-doc/howto-index.html
[ap]:  file:///usr/share/doc/git-doc/technical/
[api]: file:///usr/share/doc/git-doc/technical/api-index.html

Страницы команд и гайдов есть и в сети, в html-формате: <https://git-scm.com/docs>

## 3.3. Чит-листы (cheat sheet)

Могут иногда пригодиться:

- Интерактивный (en): <http://ndpsoftware.com/git-cheatsheet.html>
- От GitHub-а (ru): <https://github.github.com/training-kit/downloads/ru/github-git-cheat-sheet/>

## 3.4. Прочее

Ресурсов по Гиту в сети очень много, перечислить все просто невозможно, так что только некоторые:

- Справочные материалы от ГитХаба: <http://try.github.io>
- Вики на kernel.org: <http://git.wiki.kernel.org>
- Git Developer Pages - домашняя страница о разработке Git-а. Можно подписаться на ежемесячные рассылки: <https://git.github.io>
- Мейл-листы разработчиков и irc-каналы. Выглядит немного устаревшим, но там самая актуальная инфа. Нужны лишь для тех, кто пишет сам Git. См. <https://git-scm.com/community>

---

# 4. Git internals

## 4.1. Введение

Отслеживать изменения в файле можно двумя путями: хранить исходный файл и изменения в нем, "дельту" (это т.н. дельта-компрессия) или хранить каждое состояние файла. Второй подход требует больше дискового пространства, но гораздо проще в алгоритмическом плане. При дельта-компрессии для получения какой-либо версии файла на его исходное состояние нужно накладывать патчи (хранимые "дельты"), что сложно, ресурсоёмко, и чревато ошибками. При хранении каждой версии файла можно просто брать нужную с диска. Это быстро и не требует интеллектуальных патчей. Такой подход - хранения "снимков" (snapshots) - использует Git.

Системы контроля версий кода (CVCS) хранят "срез" рабочей папки проекта, следят именно за его (среза) состоянием. Их не интересуют отдельные файлы: работоспособность проекта определяется состоянием всех файлов, не отдельных. Но папки, в конечном итоге, сами состоят из файлов. Можно рассматривать папку как файл особого формата, хранящий список содержащихся в ней файлов и подпапок. Таким образом, Git хранит каждый снимок папки точно так же, как снимки отдельных файлов. Об этом будет ниже.

Стоит отметить, что Git заточен именно под код, является CVCS, и максимально эффективно работает именно с текстовыми файлами (которыми и является исходный код). Поддержка бинарных (не-текстовых) файлов в нем гораздо хуже. Да, он работает с ними, и вполне неплохо, но всё же некоторые проблемы, такие как сравнение и экономия места, в нем требуют дополнительных действий.

При неспешном ковырянии собственного проекта его можно держать в "разобранном" состоянии, работоспособность его в каждый момент времени не важна. При коммерческой разработке это недопустимо, и нужно:

- всегда иметь рабочую протестированную версию
- при выпуске новой версии и обнаружении в ней критических багов иметь возможность быстро откатиться на старую, и только потом делать фиксы (ведь они могут занять длительное время)
- иметь возможность разрабатывать новые фичи, не затрагивая рабочую версию
- разрабатывать фичи параллельно, в команде, чтобы несколько человек (иногда очень много) могли вносить изменения в проект баз конфликтов в файлах
- иметь возможность быстро найти версию, в которой была сделана ошибка (чтобы откатиться на предыдущую) и члена команды, который эту ошибку сделал (чтобы отдать фикс именно ему (и лишить премии))
- и многие другие удобные мелочи (и не очень мелочи), помогающие в такой командной, с версионированием, разработке

## 4.1. Консольные команды

Страшная и ужасная консоль. Во всех руководствах рекомендуют изучать через неё. В конечном итоге, большинство девелоперов сохраняет/отправляет изменения в Git через IDE, через дружественный интерфейс с несколькими кнопками. Консольные команды нужны больше для изучения Git, и в изучение внутренностей системы они особенно пригодятся.

Консоль - родная среда для Гита, ведь разрабатывался он под ядро Линукс, где всем девелопером консоль близка и знакома. Первоначально система представляла собой набор низкоуровневых скриптов, выполнявших лишь отдельные простые действия. Группировать их нужно было вручную, составляя из них более общие скрипты. Последние со временем стали отдельными командами, да и весь Git был переписан на C. Но деление на служебные ("канализация", plumbing) и высокоуровневые ("сантехника/фарфор", porcelain) команды сохранилась, так что можно использовать и те и те. Сохранилась, правда, и некоторая разрозненность, нелогичность, дублирующая функциональность, и прочее историческое наследие того времени, когда Git был не средством контроля версий, а набором инструментов и скриптов для построения таких средств.

В повседневном кодинге используются как правило высокоуровневые команды, а для отдельных сложных случаев, или для написания сложного скрипта, можно воспользоваться низкоуровневыми. Кроме того, именно служебные команды помогут разобраться в git internals, и с них мы и начнем в следующих разделах.

Оба типа команд имеют одинаковую структуру:

```shell
$ git <command> <args>
```
То есть она "двойная" - сначала всегда `git`, потом низко- или высокоуровневая команда (напр. `add`, `commit`, `update-index` и т.д.), а потом параметры команды. Параметры могут идти и перед командой, но есть и исключения, так что лучше писать после.

Все команды делятся на типы (`abbr. = <list>`):

- `[pi]` = `plumbinginterrogators`
- `[pm]` = `plumbingmanipulators`
- `[ai]` = `ancillaryinterrogators`
- `[am]` = `ancillarymanipulators`

`<!-- TODO: продолжить список -->`

Получение списка команд: `git --list-cmds=list-<list>`

## 4.2. Контентно-адресуемая файловая система (КАФС)

Т.к. Git хранит не изменения в файлах, а снимки самих файлов, то возникает вопрос экономии места на диске. Как упоминалось выше, важен "срез" проекта целиком, все файлы в рабочей папке. На практике оказывается, что два "снимка" проекта, два состояния рабочей папки как правило различаются лишь несколькими файлами, то есть меняются незначительно. Остальные файлы в них не изменились, они идентичны, и в новом снимке можно их не дублировать, а лишь заменить на ссылки на файлы в старом снимке.

Git возводит концепцию такой ссылки в абсолют, делает так, что вообще не может быть двух файлов с одинаковым содержимым и разными именами. Если файл однажды сохранен, то сохранить его второй раз (напр., в новом "снимке" проекта) просто нельзя - вместо него в снимке автоматически сохранится ссылка. Такая концепция - когда для файла уникально не имя, а содержимое - называется *контентно-адресуемой файловой системой*. Физически, на диске сохраняется содержимое файла (напр., текст, код), а имя сохраняемого файла генерируется по этому содержимому.

Чтобы поставить в соответствие контенту (содержимому) файла некоторое имя, нужно этот контент захешировать. Git использует SHA-1 хеши, длиной 40 символов, такого вида: `9daeafb9864cf43055ae93beb0afd6c7d144bfa4`. Он просто сохраняет в папку `.git/objects` файлы с такими 40-символьными именами, записывая в них содержимое файлов проекта. Так формируется *база объектов* Git. После записи файла в базу, достаточно просто указать где угодно его хеш, и этот хеш будет использован как ссылка.

Папки тоже являются объектами. Если составить файл со списком пар "`имя файла < -- > ссылка на содержимое (хеш файла)`", то такой файл-список тоже можно сохранить в базу - захешировать и получить на него ссылку. Кроме того, объекты-папки решают вопрос хранение исходных имен файлов (разработчик должен знать, что его файл `test.sh` хранится в базе под ссылкой (хешем) `cc39c13708fa8b699b5dbbb97f1e95e639ca75b3`). Хэш объекта-папки точно так же (как и файлы) входит в списки папок более высокого уровня, формируя древовидную структуру каталогов.

КАФС, кроме того, решает проблему *целостности* (integrity) хранимых снимков проекта. Малейшее изменение в файле приводит к изменению его хеша, и разработчик не пропустит ничего даже случайно - система скажет ему, что он или кто-то другой уже редактировали файл(ы). Кроме того, сами хеши присутствуют в списках в объектах-папках, и изменение даже одного файла меняет содержимое всех объектов-папок (а значит и их хеш-имена в базе), в которые он входит, вплоть до верхнего уровня.

`<!-- TODO: нужны примеры, листинги и рисунки -->`

Служебная команда для получения хеша - `[pm] hash-object`. Опция `-w` физически пишет файл в базу, без неё команда просто выводит хеш в stdout. Имеет 2 основные формы:

- файл на диске: `git hash-file [-w] <file-path>`
- чтение из stdin: `echo "<some content>" | git hash-file [-w]`

## 4.3. Снимки и коммиты