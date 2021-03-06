- <https://code.visualstudio.com/updates/v1_39>

## Workbench

- переключение вида tree/list во вкладке "Source control". Также управляется опцией `scm.defaultViewMode`
- в той же панели теперь есть поиск по файлам, нужно просто начать печатать
- фича управления переходами по внешним ссылкам (попап подтверждения) была введена в [v1.38](vscode-1.38). Теперь команда `Manage Trusted Domains` открывает JSON-файл настроек, где можно редактировать список доверенных доменов
- текст из подсказок автодополнения теперь можно копировать
- улучшена поддержка японских шрифтов для Windows
- улучшенные моноширные шрифты во всплывающих подсказках
- схема валидации настроек типа массив теперь поддерживает `uniqueItems`
- подсветка синтаксиса в блоках кода в README-страницах

## Редактор

- команда `Toggle Fold (Ctrl+K Ctrl+L)`
- подсветка текущего выделения в миникарте
- поддержка перетаскивания в миникарте через касание (?, "The minimap slider can now be dragged with touch.")
- вставка из буфера для мультикурсоров теперь настраивается через `editor.multiCursorPaste: (spread|full)` (построчная вставка или весь текст сразу)

## Терминал

- команда `workbench.action.terminal.newWithCwd` позволяет в аргументах указывать стартовую директорию для открываемого терминала (полезно, напр., для хоткеев)
- улучшено определение локали, замена команды: `terminal.integrated.setLocaleVariables --> terminal.integrated.detectLocale`

## Языки

- во всплывающих подсказках для HTML ARIA теперь показываться ссылки на w3.org
- автодополнение CSS теперь вставляет точку с запятой в конце строки. Поведение управляется настройкой `[css|scss|less].completion.completePropertyWithSemicolon`
- квадратики с цветом для цветовых свойств CSS теперь показываются и во всплывающих подсказках
- настройка `markdown.links.openLocation: (currentGroup|beside)` определяет, где открывать ссылки из markdown-документов: в текущей группе редакторов или рядом

## Отладчик

- теперь показываются возможные позиции для breakpoint-ов внутри строки
- в панели "Call stack" кнопки действий теперь показываются при наведении
- другие улучшения панели "Call stack": раскрытие тредов и фокус
- ссылки теперь распознаются в выводе Debug Console
- переменная конфига тасков `${defaultBuildTask}` (то, что запускается по команде `Tasks: Run Build Task`). Может быть использована, например, в `"preLaunchTask": "${defaultBuildTask}"`
- в случае ошибок во время `preLaunchTask` выбор действия теперь можно сохранять. Настройка `debug.onTaskErrors: (prompt|debugAnyway|showErrors)`

## Расширения

- улучшения расширения [Remote Development](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.vscode-remote-extensionpack)

## Новые фичи

- хотя VSCode не будет интегрировать TypeScript v3.7 до официального релиза, некоторе его фичи можно потестить уже сейчас

## Для разработчиков расширений

- терминал для Extension API
- показ устаревших тегов в подсказках
- редактирование имени отладочной сессии (`DebugSession`)
- предупреждения для WebView
- API для сообщений в режиме TreeView
- обновление стиля иконок
- возможность направлять команды в отдельную папку в режиме дерева в панели SCM

## Протокол языкового сервера

- версия 3.15.0 доступна, хотя работа над ней еще на полностью завершена

## Протокол отладчика

- поддержка отмены запросов (запрос `cancel`)
- поиск всех возможных breakpoint-ов в диапазоне кода (запрос `breakpointLocations`)

## Предложенные API для расширений

- тип UI, в котором запускается VSCode: `vscode.env.uiKind: (UIKind.Desktop|UIKind.Web)`
- `vscode.env.asExternalUri`, что-то с разбором внешних урлов в рамках нового `vscode.env.openExternal` API
- нативная поддержка редакторов для любого типа файлов (т.н. Custom Editor API)
- редактируемый заголовок для TreeView
- улучшения для иерархических сессий отладчика
- удаллено устаревшее API терминала `Terminal.onDidWriteData`

## Проектирование и разработка

- улучшены иконки и цвета сайта
- минификатор JS сменен с uglify-es на [terser](https://github.com/terser/terser)
- обработчик событий от файловой системы (filewatcher) Chokidar обновлен до v3.x
- интеграционные тесты теперь запускаются на реальной сборке
- VSCode и расширения теперь собираются с TypeScript v3.6
- функционал предпросмотра изображений вынесен из ядра во встроенное расширение Image Preview

## Новая документация

- руководство по деплою на Node.js перемещено на <https://docs.microsoft.com/azure/javascript>

И около десятка фиксов.
