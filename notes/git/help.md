## Книги

Систематическое изложение материала по Git-у есть в книгах, на начальном этапе очень желательно начать с них. Что-то вроде официального руководства - книга ProGit, доступная на официальном сайте, как для онлайн-чтения, так и для скачивания в pdf, epub и mobi форматах.

- Английская версия на оф. сайте: <https://git-scm.com/book/en/v2>
- Русская версия на оф. сайте переведена не до конца, но довольно много: <https://git-scm.com/book/ru/v2>
- Есть полностью переведенная русская версия, доступна в сети: <https://www.piter.com/collection/all/product/git-dlya-professionalnogo-programmista-2>
- Исходники книги постоянно обновляются, доступны на GitHub-е. Можно клонировать репозиторий себе и собирать html/pdf/прочее самому: <https://github.com/progit/progit2>

Подборка других книг есть на оф. сайте: <https://git-scm.com/doc/ext>, да и вообще книг по нему в сети достаточно много.

## Man-страницы

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

## Чит-листы (cheat sheet)

Могут иногда пригодиться:

- Интерактивный (en): <http://ndpsoftware.com/git-cheatsheet.html>
- От GitHub-а (ru): <https://github.github.com/training-kit/downloads/ru/github-git-cheat-sheet/>

## Прочее

Ресурсов по Гиту в сети очень много, перечислить все просто невозможно, так что только некоторые:

- Справочные материалы от ГитХаба: <http://try.github.io>
- Вики на kernel.org: <http://git.wiki.kernel.org>
- Git Developer Pages - домашняя страница о разработке Git-а. Можно подписаться на ежемесячные рассылки: <https://git.github.io>
- Мейл-листы разработчиков и irc-каналы. Выглядит немного устаревшим, но там самая актуальная инфа. Нужны лишь для тех, кто пишет сам Git. См. <https://git-scm.com/community>
