## Типы команд

- `[pi]` = `plumbinginterrogators`
- `[pm]` = `plumbingmanipulators`
- `[ai]` = `ancillaryinterrogators`
- `[am]` = `ancillarymanipulators`

`<!-- TODO: продолжить список -->`

Получение списка: `git --list-cmds=list-<list>`

## Хеш по файлу или строке, `[pm] hash-object`

Опция `-w` физически пишет объект в базу, без неё просто выводит хеш в `stdout`:

- `git hash-file [-w] <file-path>`
- `echo "<some content>" | git hash-file [-w]`

## Просмотр содержимого объекта, `[pi] cat-file`

- `git cat-file -p <revision>`
