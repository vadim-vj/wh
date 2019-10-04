## Plumbing

- `[pi]` = `plumbinginterrogators`
- `[pm]` = `plumbingmanipulators`
- `[ph]` = `purehelpers`
- `[sh]` = `synchelpers`
- `[sr]` = `synchingrepositories`

## Porcelain

- `[ai]` = `ancillaryinterrogators`
- `[am]` = `ancillarymanipulators`
- `[mp]` = `mainporcelain`
- `[fi]` = `foreignscminterface`

`<!-- TODO: там еще есть списки, типа "builtins" и "nohelpers -->`

## Misc

- `ls -la /usr/share/doc/git-doc/cmds-*` - все списки
- `git --list-cmds=list-<list>` - получение списка
- `git config --global alias.list-mp '--list-cmds=list-mainporcelain'` - добавление алиаса
- `ls -la /usr/lib/git-core/` - папка с бинарниками
