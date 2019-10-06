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

`<!-- TODO: нужно дополнить список русскими и английскими. И прочитать их -->`

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
- от БитБакета: <https://www.atlassian.com/git/tutorials>
- вики на kernel.org: <http://git.wiki.kernel.org>
- мейл-листы разработчиков и irc-каналы, ссылки есть на <https://git-scm.com/community>

## [ai] help

Показ справки по команде или гайдлайна.

- `git help [ --web | --man ] <command|guide>` - страница справки
- `git help --guides | -g` - список гайдов

Включение просмотра через браузер: `git config --global help.format web` (+ есть выбор браузера, `web.browser firefox`). Интересные случаи:

- `git help git`
- `git help help`
