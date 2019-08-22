## Типы команд

- `[pi]` = `plumbinginterrogators`
- `[pm]` = `plumbingmanipulators`
- `[ai]` = `ancillaryinterrogators`
- `[am]` = `ancillarymanipulators`

`<!-- TODO: продолжить список -->`

Получение списка: `git --list-cmds=list-<list>`

## Объекты в репозитории

Все четыре типа хранятся в `.git/objects/[a-z0-9]{2}/`. Формат:

- объект: `object = "<type> <size-in-bytes>\0<content>"`
- имя файла: `sha1(<object>)`
- содержимое файла: `zip(<object>)`

## Контент деревьев

```
<mode> {tree|blob} <sha1> <file-name>
<mode> {tree|blob} <sha1> <file-name>
...
```

## Контент (аннотированных) тегов

```
commit <sha1>
```

## Контент коммитов

```
tree <sha1>
parent <sha1>
parent <sha1>
...
author Ben Straub <ben@straub.cc> 1565198977 -0700
committer GitHub <noreply@github.com> 1565198977 -0700
gpgsig <multi-line-signature>

<commit message>
```

## Хеш по файлу или строке, `[pm] hash-object`

Команда выводит хеш *объекта* в `stdout`:

- `git hash-file [-w] <file-path>`
- `echo "<content>" | git hash-file [-w]`

Нужно помнить, что `[pm] hash-object` дает SHA1 не самого контента, а объекта (заголовка `<type> <size-in-bytes>\0` + контент). Опция `-w` (дополнительно) физически пишет зипованный объект в базу.

## Просмотр содержимого объекта, `[pi] cat-file`

- `git cat-file -p <revision>`

Разжимает файл и отбрасывает заголовок; выводит только контент.
