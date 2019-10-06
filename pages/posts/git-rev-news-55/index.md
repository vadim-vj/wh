- <https://git.github.io/rev_news/2019/09/25/edition-55/>

## Discussions

### General

- Закончился Google Summer of Code 2019. Оба гитовских студента представили свои проекты
- Johannes "Dscho" Schindelin организовал Virtual Git Contributor Summit, который прошел 12-13 сентября по Zoom-у (отчет прилагается)
- Emily Shaffer в мейл-листах разработчиков гита спрашивает, интересно ли будет создание блога по Git, который будут вести разработчики. Цель - сделать гит более понятным для остального мира. Ее поддержали и согласились писать иногда статьи. Jeff King, админ оф. сайта, выделил поддомен <https://blog.git-scm.com> (пока не работает). Репозиторий блога - <https://gitlab.com/git-scm/blog/>. Будут делать на движке Hugo (markdown)

### Support

- diff.renames not working?

Обсуждение детектов переименований с участием Jeff King и Junio Hamano, историческая справка от последнего.

## Developer Spotlight: Emily Shaffer

Дамочка живет в Калифорнии, работает в Гугле, и постоянно контрибутит в гит. Автор мануала по засыланию патчей в гит: <https://git-scm.com/docs/MyFirstContribution.html>. Последнее время делает что-то с гитом в гугле (?). Работает над тулзой по генерации репортов об ошибках. Планирует скоро заняться хуками, мечтает заняться сабмодулями. Восхищается системой алиасов, сама для себя настроила многие; также ей нравится использование mutt-а для мейл-листов гита и возможность отправки почты прямо из Vim.

## Releases

Текущая версия гит - 2.23, в августе не обновлялся. Вышли релизы Gerrit Code Review, GitHub Enterprise, GitLab, Bitbucket Server, GitKraken и GitHub Desktop.

## Other News

### Various

- в блоге GitHub-а появился пост про фичи v2.23: <https://github.blog/2019-08-16-highlights-from-git-2-23/>
- выступления разработчиков (Git standup on IRC) в #git-devel на irc.freenode.net каждые две недели
- BitBucket объявляет о прекращении поддержки Mercurial к 1 июня 2020 года: <https://bitbucket.org/blog/sunsetting-mercurial-support-in-bitbucket>

## Light reading

- [“They Didn’t Teach Us This”: A Crash Course for Your First Job in Software][1] от Max Pekarsky, секция "Git Workflow"
- [First Steps Contributing to Git][2] от Matheus Tavares (GSoC 2019 student)
- [Maintaining the kernel’s web of trust][3] от Jonathan Corbet, предложение по хранению GPG-ключей
- [Defragmenting the kernel development process][4] от Jonathan Corbet, секция про контроль версий и Git
- [GitLens: where have you been all my life!][5] от G.L Solaria, про аддон к VSCode
- [Git Can Do That?][6] от Pratik Karki, неформальная презентация с общими сведениями о Git

[1]: https://stackoverflow.blog/2019/09/05/they-didnt-teach-us-this-a-crash-course-for-your-first-job-in-software/
[2]: https://matheustavares.gitlab.io/posts/first-steps-contributing-to-git
[3]: https://lwn.net/Articles/798230/
[4]: https://lwn.net/Articles/799134/
[5]: https://dev.to/glsolaria/gitlens-where-have-you-been-all-my-life-1c2d
[6]: https://docs.google.com/presentation/d/1xbzgdj_gnUSEvpTedoyJXVvREwOxBi1amm7A_FdMFCc/edit

## Git tools and sites

- patchew, система работы с патчами по почте: <https://github.com/patchew-project/patchew>
- gitin2it, набор алиасов для работы: <https://github.com/slefevre/gitin2it>
