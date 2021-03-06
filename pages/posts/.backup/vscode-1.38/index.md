- <https://code.visualstudio.com/updates/v1_38>

## Workbench

- кнопка "Preserve case" была добавлена в v1.37 для редактора, теперь она есть и для глобального поиска/замены
- кнопка "Cancel search" для остановки длительного поиска
- валидация по схеме (`minItems`, `maxItems`, `item.enum`, и `item.pattern`) для настроек типа массив
- попап подтверждения для перехода по внешним ссылкам. Настраивается через команду `Configure Trusted Domains`
- улучшения для создания файлов верхнего уровня в панели "Explorer" (возможность вызова контекстного меню на скроллбаре, возможность прокрутить так, что появится свободная область для вызова меню, `Escape` для сброса фокуса)
- команда `filesExplorer.openFilePreserveFocus` (`Space`) - возможность открывать превью файлов не снимаю фокус с панели "Explorer"
- настройка `explorer.incrementalNaming` управляет именованием создаваемых дубликатов файлов (`simple` (текущая, по умолчанию) добавляет в конец имени `copy[N]`, `smart` - добавляет только номер или инкрементирует существующий, если имя файла само кончается на число)
- команда `workbench.action.toggleEditorWidths` как-то переключает ширину группы редакторов
- переписан на гридах, теперь такая же схема как и для редакторов. Опция `workbench.useExperimentalGridLayout` теперь по дефолту включена
- эти же гриды позволили скрывать область редактора и показывать нижнюю панель (напр., терминал) в полное окно. Команды `Toggling the editor area` / `Maximizing the panel`. Редактор автоматически восстановится если открыть какой-нибудь файл
- настройка `keyboard.touchbar.ignored` управляет пересечением команд с macOS Touch Bar
- возможные ключи контекста для `when`, группы редакторов: `activeEditorGroupIndex` / `activeEditorGroupLast`
- некоторые улучшения accessibility

## Редактор

- настройка `editor.cursorSurroundingLines` - количество линий вокруг курсора при скролле файла (аналог `scrollOff` для Vim-а)
- виджет поиска теперь поддерживает многострочный поиск (`Ctrl + Enter` в поле)
- команды в удаленных блоках в diff-редакторе: копировать всё удаленное, копировать строку, восстановить всё
- команда `Go to Line` теперь поддерживает отрицательные числа, идет переход в конец файла

## Терминал

- при использовании несуществующих переменных в настройке `cwd` (напр., `"terminal.integrated.cwd": "${fileDirname}"`) терминал теперь не крашится, а пишет ошибку в консоль VSCode и переходит в рабочую директорию проекта
- настройка выбора шелла для тасков автоматизации `"terminal.integrated.automationShell.(windows|linux|osx)"`

## Языки

- во всплывающих подсказках для HTML/CSS теперь показываться ссылки на MDN
- улучшена поддержка Less (+ root functions, map lookups, anonymous mixins)
- показ тегов `nonstandard` и `obsolete` для CSS-свойств
- встроенный TypeScript обновлен до v3.6.2 (+ stricter generators, `import.meta`)
- QuickFix теперь поддерживает добавление `await`
- улучшена автоматическая вставка `;` (напр., при авто-вставке директив `import ...`)
- JSDoc-комментарии больше не сливаются автоматически, для тайпинга используется только первый

## Контроль версий

- имя текущей ветки теперь показывается как в плейсхолдере текстового поля сообщения коммита (чтобы не ошибиться, в какую ветку идет коммит)
- настройка `git.branchSortOrder` для сортировки списка команды `Git: Checkout to...`
- настройка `git.supportCancellation` дает возможность прерывать медленные pull-реквесты

## Отладчик

- новый тип брейкпоинтов (т.н. Data Breakpoints), срабатывают когда значение переменной меняется. Пока только планируется, что дебаггеры C#/C++ будут поддерживать такое. Сейчас лишь отладчик-заглушка [Mock Debug](https://marketplace.visualstudio.com/items?itemName=andreweinand.mock-debug) поддерживает этот тип
- улучшения вида панели Call Stack
- настройка `terminal.integrated.automationShell...` учитывается и здесь

## Расширения

- открыт тикет для всех расширений, использующих webview. Должны следовать Content Security Policy (CSP), хоть это и не срочно. Также добавлено предупреждение для разработчиков в консоли
- улучшения расширений [GitHub Pull Requests](https://marketplace.visualstudio.com/items?itemName=GitHub.vscode-pull-request-github), [Remote Development](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.vscode-remote-extensionpack)
- создан репозиторий всех иконок VSCode: <https://github.com/microsoft/vscode-icons>. Авторы расширений могут их использовать

## Команды

- `*.action.*.find(Next|Previous)` для нескольких панелей (`F3`/`Shift + Enter` для редактора, `F3`/`Shift + F3` для терминала, и т.д.)

Плюс, как обычно, много багфиксов и технических изменений всех частей API.
