# git-help

- `git help` === `git` - без аргументов печатает синопсис команды `git` и список наиболее распространенных команд
- `git help -a|--all` - синопсис + все команды
- `git help -a|--all --verbose` - синопсис + все команды + описание команд; опция `--verbose` действует только вместе с `-a|--all`
- `git help -c|--config` - список имен всех опций конфига (без значений); это краткое summary `git config`
- `git help -g|--guides` - список гайдов
---
- `git help <command|guide>` === `git --help <command|guide>` === `git <command> --help` - третий вариант не действует для гайдов
- `man git-<command>` - действует только для команд (не для гайдов), и игнорирует настройки просмотрщика (см. далее)
---
- опция конфига - `help.format={man|info|web}` - просмотрщик
- `git help -m|--man <command|guide>` - для перекрытия значения из конфига и использования стандартного просмотрщика `man`
- `git help -i|--info <command|guide>` - в формате `info` найти документацию на `git` не удалось
- `git help -w|--web <command|guide>` - в браузере
---
- `git help help` - справка по команде `help`
- `git help git` - по основной команде `git`

# git-init
