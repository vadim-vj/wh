# Списки команд

Plumbing:

- `[pi]` = `plumbinginterrogators`
- `[pm]` = `plumbingmanipulators`
- `[ph]` = `purehelpers`
- `[sh]` = `synchelpers`
- `[sr]` = `synchingrepositories`

Porcelain:

- `[ai]` = `ancillaryinterrogators`
- `[am]` = `ancillarymanipulators`
- `[mp]` = `mainporcelain`
- `[fi]` = `foreignscminterface`

Misc:

- `ls -la /usr/share/doc/git-doc/cmds-*` - все списки
- `git --list-cmds=list-<list>` - получение списка
- `git config --global alias.list-mp '--list-cmds=list-mainporcelain'` - добавление алиаса
- `ls -la /usr/lib/git-core/` - папка с бинарниками

# Материалы

## Онлайн-ресурсы

- оф. сайт: <https://git-scm.com>
- репозиторий: <https://github.com/git/git>
- Git Developer Pages: <https://git.github.io>
- GitHub (+ твиттер): <https://github.com> (<https://twitter.com/github>)
- BitBucket (+ твиттер): <https://bitbucket.org/product/> (<https://twitter.com/bitbucket>)

## Книги

ProGit:

- en: <https://git-scm.com/book/en/v2>
- ru: <https://git-scm.com/book/ru/v2>
- ru (полный перевод): <https://www.piter.com/collection/all/product/git-dlya-professionalnogo-programmista-2>
- исходники: <https://github.com/progit/progit2>

Другие: <https://git-scm.com/doc/ext>, + сеть.

## Внутренняя документация

Спец. разделы (ссылки есть в секции "Further documentation" в `git help git`):

- Git User Manual ([/usr/share/doc/git-doc/user-manual.html][um])
- Git Howto Index ([git-doc/howto-index.html][hti] -> [git-doc/howto/][ht])
- Git API Documents ([git-doc/technical/api-index.html][api] -> [git-doc/technical/][ap])

[um]:  file:///usr/share/doc/git-doc/user-manual.html
[ht]:  file:///usr/share/doc/git-doc/howto/
[hti]: file:///usr/share/doc/git-doc/howto-index.html
[ap]:  file:///usr/share/doc/git-doc/technical/
[api]: file:///usr/share/doc/git-doc/technical/api-index.html

Папка документации: `ls -la /usr/share/doc/git-doc/`.

`<!-- Разобрать содержимое полностью -->`

Онлайн: <https://git-scm.com/docs>

## Чит-листы (cheat sheets)

- интерактивный (en): <http://ndpsoftware.com/git-cheatsheet.html>
- от GitHub-а (ru): <https://github.github.com/training-kit/downloads/ru/github-git-cheat-sheet/>

## Прочее

- справочные материалы от ГитХаба: <http://try.github.io>
- вики на kernel.org: <http://git.wiki.kernel.org>
- мейл-листы разработчиков и irc-каналы, ссылки есть на <https://git-scm.com/community>

## [ai] help

Показ справки по команде или гайдлайна.

- `git help [ --web | --man ] <command|guide>` - страница справки
- `git help --guides | -g` - список гайдов

Включение просмотра через браузер: `git config --global help.format web` (+ есть выбор браузера, `web.browser firefox`). Интересные случаи:

- `git help git`
- `git help help`

# Объектная база

## Объекты в репозитории

Все четыре типа хранятся в `.git/objects/[a-z0-9]{2}/`. Формат:

- объект: `object = "<type> <size-in-bytes>\0<content>"`
- имя файла: `sha1(<object>)`
- содержимое файла: `zip(<object>)`

Контент:

- деревья

      <mode> {tree|blob} <sha1> <file-name>
      <mode> {tree|blob} <sha1> <file-name>
      ...

- аннотированные теги

      object <sha1>
      type <blob|tree|commit|tag>
      tag <tag-name>
      tagger John Doe <tagger@example.com> 1559945764 +0400
      gpgsig <multi-line-signature>

      <tag-message>

  Команда `git cat-file -p <tag>` на легковесном теге выдаст содержимое коммита

- коммиты

      tree <sha1>
      parent <sha1>
      parent <sha1>
      ...
      author John Doe <author@example.com> 1565198977 -0700
      committer Jane Doe <committer@example.com> 1565198977 -0700
      gpgsig <multi-line-signature>

      <commit-message>

Git поддерживает механизм "альтернатив" - файлы `./git/objects/info/alternates` и `.git/objects/info/http-alternates`. В них можно построчно перечислить пути (урлы) к другим объектным базам, в которых будет вестись поиск в случае если в текущей базе нужного хеша нет. Используются всеми локальными утилитами и HTTP-фетчером при сетевых операциях.

## [pm] hash-object

Хеш по файлу или строке. Получает на вход *контент*, и выводит хеш *объекта* в stdout:

- `git hash-file [-w] <file-path>`
- `echo "<content>" | git hash-file [-w]`

Нужно помнить, что `hash-object` дает SHA1 не самого контента, а объекта (заголовка `<type> <size-in-bytes>\0` + контент). Опция `-w` (дополнительно) физически пишет зипованный объект в базу.

## [pi] cat-file

Просмотр содержимого объекта:

- `git cat-file -p <revision>`

Разжимает файл и отбрасывает заголовок; выводит только контент.

## [pi] ls-tree

Просмотр содержимого дерева. Корректно разыменовывает любые объекты (теги, коммиты, ссылки), приводящиеся к tree-ish. Вывод команды можно лимитировать через `<pattern>` (`-r` = recursive):

- `git ls-tree [-r] <tree-ish> [<pattern>]`

Формат вывода (размеры для блобов выводятся через `--long | -l`):

      <mode> <blob|tree> <sha1>[ <blob-size|->] <entry-name>
      <mode> <blob|tree> <sha1>[ <blob-size|->] <entry-name>
      ...

Это корректный входной формат для `git update-index --index-info --stdin`.

## [pi] unpack-file

Создает в текущей директории временный файл формата `.merge_file_\w+` (напр., `.merge_file_GIZzRz`) и пишет в него контент указанного блоба:

- `git unpack-file <sha1>`

Имя созданного файла выводится в stdout.

# Индекс и коммиты

## Формат индекса

Термины *index*, *stage* и *cache* равнозначны.

- [git-doc/technical/index-format.html][if]
- <https://mincong-h.github.io/2018/04/28/git-index/>

[if]: file:///usr/share/doc/git-doc/technical/index-format.html

Общий формат бинарного файла `.git/index`:

      Header (12 byte; "DIRC <index-version:(2|3|4)> <entries-number>")
      Entries list
      Extensions
      SHA-1 of the index file before this checksum (160 bit)

Entry, элемент списка (данные из системного вызова `stat()`):

- `ctime`, время последнего изменения метаданных файла (командами `chmod`/`chown`/`ln`)
- `mtime`, время последнего изменения содержимого файла
- `dev`, ID устройства, на котором расположен файл
- `ino`, номер индексного дескриптора файловой системы (inode)
- `object type`, тип объекта git: 1000 (regular file), 1010 (symbolic link) и 1110 (gitlink)
- `perm:(0755|0644)`, UNIX-права, только 2 возможных значения для файлов. Симлинки и git-линки имеют в этом поле `0`
- `uid`, ID владельца файла
- `gid`, ID группы владельца файла
- `file-size`, размер файла в байтах
- `sha1`, хеш объекта (160 бит)
- `flags`, флаги, зависят от версии
- `file-path`, относительно рабочей директории верхнего уровня. В v4 идет префиксное сжатие этого поля относительно предыдущего (видимо, нужно для паковки)

Элементы (entries) индекса сортируются сначала по полю `file-path`, рассматриваемому как строка беззнаковых битов (без локализации, учёта `/` и т.д.; это для `memcmp()`), а потом по `stage-level`.

Дополнительные флаги в версиях выше 2 читаются только тогда, когда `extended-flag=1`; во второй версии он всегда ноль и эти два флага игнорируются:

- v2: `assume-unchanged:(1|0)`, `extended-flag=0`, `stage-level:[0-3]`, `file-name-length`
- v3, v4: дополнительно `skip-worktree:(1|0)`, `intent-to-add:(1|0)`

Расширения и их сигнатуры:

- Cached tree (`TREE`). Содержит хеши деревьев, которые могут быть сгенерированы по индексу. Это ускоряет запись деревьев при коммите. При изменении какого-либо пути в индексе хеш соответствующего дерева инвалидируется
- Resolve undo (`REUC`). При разрешении конфликтов (напр., `git add <path>`) все вхождения со `stage-level` больше нуля удаляются из индекса. Это расширение сохраняет их, чтобы можно было воспроизвести конфликт с нуля (напр., через `git checkout -m`)
- Split index (`link`). Поддерживает режим *split index*, храня `sha1` "расщепленного" индекса. Сам файл такого индекса хранится в `.git/sharedindex.<sha1>`
- Untracked cache (`UNTR`). Хранит кеш неотслеживаемых файлов. Имеет довольно сложную структуру, учитывает файл `.git/info/exclude`
- File system monitor (`FSMN`). Поддерживает совместную работу гита с системным файловым монитором, хранит метаданные для взаимодействия с этим монитором
- Index entry offset table (`IEOT`). Помогает определить стоимость задействования многопоточности при загрузке индекса в память. Хранит количество элементов (entries) в блоках и смещения этих блоков в бинарном индексе
- End of index entry (`EOIE`). Ничего не делает, маркирует конец списка расширений. Хранит их сигнатуры и смещения в бинарном индексе

## [pi] ls-files

Просмотр индекса и/или рабочего дерева. Выводит списки файлов, рабочий каталог (`--others` - untracked files) + индекс:

- `git ls-files [ --stage | --debug ] <pattern>`

По умолчанию выводит просто список файлов, а со `--stage`:

      <mode> <sha1> <stage-level> <file-path>
      <mode> <sha1> <stage-level> <file-path>
      ...

Опция `--debug` выводит данные от `lstat()`. `<pattern>` лимитирует файлы по пути.

# Конфиг

## Формат файлов

Настройки vim-а: `:set noexpandtab` и `:set sts=2`.
