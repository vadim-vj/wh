- много воды, введение, от DNS-серверов до структуры документа, и что такое HTML/CSS
- понятие элемента, тега, атрибута (имя, значение, кавычки)
- глобальный атрибут `lang="ru|en-US"`
- теги `body` (то, что выводится в окне браузера), `head` (то, что не выводится), `title` (то, что идет в заголовок окна)
- деление разметки на структурную и семантическую:
  * `h1`-`h6`, `p`, `b`, `i`, `sub`/`sup`, "сворачивание" пробелов, `br`, `hr`
  * [p.53] `strong`, `em`, `blockquote`/`q` (+ attr `cite`), `abbr` (+ attr `title`), `cite`, `dfn`, `address` (+ hCard), `ins`/`del`, `s`
- теги `ol`, `ul`, [p.68] `dl` (+ `dt`, `dd`) (+ attr `list-type-style`), оформление заголовка вложенного списка
- тег `a`, абсолютные и относительные урлы, `/`/`..`, `mailto:` и атрибут `target="_blank"`. Якоря на той же и других страницах (`id="..."` и `href="[...]#..."`)
- 2 варианта вставки изображений: `background-image` и тег `img`, хранение картинок в отдельной папке (возможно с подпапками)
- атрибуты тега `img`: `alt` обязательный (пустой для декоративных картинок), `title` необязательный, `width`/`height` не должны использоваться (нужно через CSS), `align` устарел
- нежелательно масштабировать картинки средствами браузера, лучше показывать в настоящем размере; 72ppi оптимальное разрешение; кадрирование нежелательно
- форматы: JPG (фотографии с множеством оттенков), PNG (рисунки с малым количеством оттенков и/или большими однотонными областями), GIF (то же что и PNG)
- SVG и анимированный GIF тоже можно. Прозрачность - через PNG или GIF
- теги `table`, `tr`, `td` (и расшифровка); когда нужны таблицы
- тег `th` (+ attr `scope="row|column"`, `(row|col)span`). Теги `thead`, `tbody`, `tfoot`
- атрибуты таблиц `width`, `bgcolor`, `border`, `cellpadding`, `cellspacing` считаются устаревшими и использоваться не должны
- формы и передача данных на сервер в виде пар имя/значение (`username=Anna; vote=Herbie`). Тег `form` (+ attrs `method`, `action` (и что они значат))
- тег `input`. Атрибуты `maxlength` и `size` считаются устаревшими. Тег `textarea` не является пустым (его атрибуты `cols`/`rows` считаются устаревшими)
- типы `input`: `text`, `password`, `radio`, `checkbox` (+ attrs `value`, `checked`)
- теги `select`, `option` (+ attrs `value`, `selected`, `size`, `multiple`)
- `input[type="file|submit|image"]` (загрузка файлов и кнопки формы). `input[type="hidden"]`
- тег `button` непустой для того, чтобы можно было вставлять внутрь него другие элементы
- тег `label`, 2 варианта расположения (+ attr `for`)
- теги `fieldset` и `legend`
- HTML5-аттрибуты полей формы: `required`, `input[type="date|email|url|search"]`, `placeholder`
- doctype-ы: `Transitional HTML 4.01`, `Strict XHTML 1.0`, `Transitional XHTML 1.0`, `XHTML 1.0 Frameset`
- комментарии: `<!-- -->`
- глобальные атрибуты `id` (должен быть уникальным) и `class`
- блочные элементы (напр., `h1`, `p`, `ul`, `li`) отображаются с новой строки
- встроенные элементы (напр., `a`, `b`, `em`, `img`) отображаются на той же строке
- тег `div` (= document divisions) - стандартный блочный для группировки
- тег `span` - стандартный встроенный для группировки
- тег `iframe`. Атрибуты `frameborder` и `scrolling` устаревшие, а `seamless` никем не поддерживается. `width`/`height` есть, но про них не сказано, устаревшие ли
- тег `meta` - информация о странице. Стандартно имеет атрибуты `name` и `content` (пара имя/значение). Примеры значений `name`: `keywords` (давно не влияет на позицию в поисковике), `description` (может быть отображено в поисковой выдаче), `robots` для поисковых краулеров (`noindex` - не индексировать, `nofollow` - не переходить по ссылкам с этой странице)
- `meta  http-equiv="..." content="..."` устанавливает заголовки http-запроса (точно?). Примеры: `author`, `pragma` (управление кешированием), `expires` (актуальность страницы)
- спец. символы, 2 варианта написания: `&amp; === &#38;`, их таблицы
- теги `object` и `embed` для встраивания медиконтента устарели
- описание встраивания flash-а, и совместное использование его с HTML5-тегами, пропустим
- теги `video`/`audio` непустые, всё что внутри них будет выведено если тег не распознан (?)
- их атрибуты: `src`, `poster` (картинка-превью), `preloaded="none|auto|metadata"`, `width`/`height`, `controls`, `loop`, `autoplay`
- множественные источники - тег `source src="..." type="..."` внутри тегов `audio`/`video`
- общий формат объявления CSS: `селектор { объявление; объявление (= свойство: значение; );}`
- тег `link href="..." type="text/css" rel="stylesheet"` указывает расположение файла CSS. Тег пустой
- тег `style type="text/css"` непустой. Не следует использовать его на сайтах с более чем одной страницей. Также стоит избегать атрибута `style` в элементах
- селекторы чувствительны к регистру: `*`, `<tag>`, `[<tag>].<class>`, `#<id>`, `<s1> > <s2>` (прямые потомки), `<s1> <s2>` ((не обязательно прямые) потомки), `<s1> + <s2>` (сосед (sibling) непосредственно после), `<s1> ~ <s2>` (все соседи)
- принципы каскадирования. Приоритет получает: более поздний из одинаковых селекторов, более специфичный, с `!important`
- свойства могут наследоваться (напр., `font-family`, `color` у `body` применяются к большинству дочерних элементов), или нет (`background-color`, `border`). Значение `inherit` указывает, что нужно наследовать
- в принципе, расположение CSS в отдельном файле почти всегда лучше. Плюс это отделяет контент от представления
- следует помнить о тестировании CSS на совместимость в разных браузерах, и использовать для этого онлайн-сервисы (идет перечисление некоторых, [p. 229])
- комментарии в CSS: `/* ... */`
- цвета: `[background-]color`, `rgb[a](R,G,B[,<alpha=opacity>])`, `#hex`, предустановленные имена. `opacity` (= **не**прозрачность) отдельным свойством, `0` - полностью прозрачный, `1` - полностью непрозрачный. Модель HSLA: `hsl[a](%,%,%[,<alpha=opacity>])` - оттенок, насыщенность, светлота
- новые возможности CSS следует дублировать старыми для совместимости. Сначал идет старый вариант, потом новый. Этот порядок важен: если новый не поддерживается, то будет использован старый, иначе новый перекроет
- шрифты:
  * с засечками - serif, для больших объемов текста, чтение. Georgia, Times [New Roman]
  * рубленые (гротески) - sans-serif, небольшой размер текста. Arial, Verdana, Helvetica
  * моноширинные - monospace, для кода, выравнивание. Courier [New]
- последовательность шрифтов: перечисление гарнитур, на случай если у пользователя нет первой. Последовательность следует завершать общим именем: `font-family: Georgia, Times, serif`. Имена из более чем одного слова нужно заключать в кавычки: `font-family:   "Courier New", ...`
- свойство `font-size`, единицы измерения:
  * `px`, оптимальный вариант, масштабируется вместе с разрешением экрана
  * `%`, от дефолтного размера в 16px
  * `em`, ширина буквы m
  * `pt`, пункт, 1/72 дюйма, примерно равен пикселу (из-за разрешения 72ppi), следует использовать только для печатных макетов
- `@font-face { font-family: "..."; src: url("..."); [format: ("eot|woff|ttf/otf|svg");] }` - позволяет загружать шрифты на страницу, после чего их можно использовать стандартным образом
- `font-weight: bold|normal;`, полужирное начертание
- `font-style: italic|oblique|normal`, курсив или наклонное начертание. Для курсивов используются спец. шрифты, а если его нет, просто искажает стандартный шрифт
- `text-transform: uppercase|lowercase|capitalize`, прописные и строчные буквы. Последний вариант начинает каждое слово с прописной
- `text-decoration: underline|overline|line-through|blink|none`, форматирование. `blink` не рекомендуется. `none` можно использовать для удаления подчеркивания у ссылок
- `line-height`, межстрочный интервал. Лучше указывать в `em` (1.4-1.5). В MDN пишут, что можно указывать безразмерное число (умножается на размер шрифта)
- `letter-spacing`, `word-spacing`, расстояние между буквами (кернинг) и словами. Первый полезен для заголовков (особенно из всех больших букв), второй реже, разве что для полужирного начертания и если увеличено расстояние между буквами
- `text-align: left|center|right|justify`, выравнивание текста. Последний вариант - заполнение ширины
- `vertical-align` выравнивает inline-элемент внутри строки или содержимое в ячейке таблицы
- `text-indent: px`, сдвиг первой строки, абзац. В книге привден пример сдвига на -9999px, что убирает заголовок из видимости, но сохраняет его на странице для поисковиков и программ доступа (а оно такое нужно?)
- `text-shadow: px px px <color>`, тень текста
- псевдоэлементы `:first-letter` и `:first-line`, различие псевдоэлементов (как будто доп. элемент, блок в коде) и псевдоклассов (как будто доп. css-класс, напр., `:hover` или `:visited`)
- псевдоклассы `:link` (еще не посещенная ссылка), `:visited` (посещенная), `:hover` (при наведении), `:active` (при активации, напр., путем нажатия на кнопку или щелчка по ссылке (?)), `:focus` (в фокусе)
- селекторы аттрибутов: `[class]` (просто есть), `[class=]` (точно равен), `[class~=]` (есть в списке, разделенном пробелами), `[class^=]` (начинается с), `[class$=]`  (заканчивается на), `[class*=]` (содержит)
- размер блока:
  * по умолчанию - такой, чтобы вмещал контент
  * проценты (и ширина, *и высота*) - относительно родительского блока
  * вместо пикселов можно использовать `em`, так гибче
- в случае динамического размера могут быть полезны `(min|max)-(width|height)`. Если для контента окажется недостаточно места, он выйдет за границы блока и перекроет границу (переполнит, overflow)
- в случае переполнения свойство `overflow` управляет показом контента: `hidden` - скрывать всё что вышло за границы блока, `scroll` - показывать полосу прокрутки
- рисунок: `border` (с толщиной) - граница блока, `margin` - (внешние) поля, `padding` (внутренние) отступы
- `border[-(top|left|right|bottom)]-(width|style|color)`, стили границы. Единое свойство `border` называется *стенографическим*
- `(padding|margin)[-(top|left|right|bottom)]`, внутренние отступы и границы. Свойство не наследуется. Увеличивает ширину блока (прибавляется к)
- выравнивание дочернего блока внутри другого достигается указанием левой и правой границ (`margin`) = `auto` *и ширины*
- блочная модель IE6, игнорируем
- свойство `display: inline|block|inline-block|none`, превращение блочных элементов во встроенные и наоборот. `inline-block` заставляет блочный элемент располагаться как встроенный, сохраняя остальные свойства (?). Дан пример с `li { display: inline; }` - создание горизонтального списка, напр., меню навигации
- `visibility: hidden|visible` скрывает элементы, но оставляет пустое место
- CSS3-свойства: `border-image` (картинка в качестве границы), `box-shadow` (аналог `text-shadow` для блоков), `border-radius` (скругление углов, вплоть до создания эллипсов и даже более сложных фигур)
- `list-style-type` различается для `ul` и `li`. Есть еще `list-style-image`. `list-style-position: inside|outside` определяет, показывать ли маркер внутри ли снаружи списка. Стенографическое свойство - `list-style`
- сборник свойств таблицы: `width` (ширина), `padding` (отступ внутри ячеек), `th { text-transform: uppercase; }`, `letter-spacing`, `font-size` (выделение заголовков), `border-top|bottom` (границы для заголовков таблицы), `text-align` (выравнивание внутри ячеек), `background-color` (для "зебры" (класс `.even` задается вручную)), `:hover` (выделяет строку при наведении)
- советы по оформлению таблиц: задавайте отступы внутри ячеек; выделяйте заголовки (`th` по умолчанию выделяет); подсвечивайте чередующиеся строки; выравнивайте номера по правому краю (чтобы крупные цифры отличались от мелких)
- `empty-cells: show|hide|inherit` - показывать ли границы пустых ячеек. `inherit` для вложенных таблиц
- `border-spacing: px [px]` указывает горизонтальные и вертикальные расстояния между ячейками таблицы. Если заданы границы и ячейки соприкасаются, то граница станет в 2 раза толще
- `border-collapse` позволяет этого избежать. `collapse` сливает границы в одну, нужной толщины, игнорирует `border-spacing` и `empty-cells`. `separate` разделяет границы, эти 2 свойства не игнорирует
- дальше идут сборники стилизаций для форм и их элементов, наподобие как выше для таблиц. Новых свойств не вводится, только используются уже известные для стилизации:
  * полей ввода (с иконками и закругленными границами)
  * кнопок подтверждения (трехмерный вид через `border`, `text-shadow`, `:hover` и `linear-gradient`)
  * элементов `fieldset` и `legend`
- приведены примеры выравнивания полей ввода с метками: через `text-align: right` внутри `fieldset`-а; через задание фиксированной ширины меток. Зачем-то там еще фигурирует `float`
- свойство `cursor: ...|url("...")` изменяет курсор мыши. Использовать адекватно
- краткое описание панели разработчика (еще в виде расширения для браузеров)
- блочный элемент, объединяющий другие элементы, называется *контейнером* (непосредственный родитель)
- схемы позиционирования:
  * (дефолт) нормальный поток: блочные элементы идут один за другим, вертикально, на новых строках, даже если у них задана ширина (в строку помещается больше одного)
  * относительное позиционирование: элемент перемещается в стороны от своего нормального положения, остальные элементы не затрагиваются
  * абсолютное позиционирование: элемент позиционируется относительно контейнера, остальные элементы не затрагиваются; перемещается при прокрутке страницы
  * фиксированное позиционирование: форма абсолютного, но относительно окна браузера, а не контейнера; не двигается при прокрутке страницы
  * плавающие элементы: помещает элемент в правый или левый угол контейнера. Элемент становится блочным, вокруг него располагаются остальные элементы
- свойство `z-index`, также *стековый контекст*, для относительного, абсолютного и фиксированного случаев. Элементы, указанные позже, перекрывают те, что указаны раньше. Свойство позволяет это менять
- нормальный поток, `position: static` - дефолт
- относительное позиционирование, `position: realtive` + `left|top|right|bottom` - смещение элемента от своего нормального расположения
- абсолютное позиционирование, `position: absolute` + `left|top|right|bottom` - элемент исключается из нормального потока и позиционируется относительно контейнера
- фиксированное позиционирование, `position: fixed` + `left|top|right|bottom` - то же, но относительно окна браузера
- свойство `float: left|right` прижмет элемент к краю, а остальные будут его обтекать. Нужно обязательно задавать ширину, иначе блок займет всю доступную
- свойство `float` используют для размещения элементов бок о бок (напр., все абзацы с `left`). Играет роль высота элемента (если блок в середине слишком высок, абзац не переместится левее его)
- свойство `clear: left|right|both|none` указывает, что ни один элемент в том же контейнере не должен касаться указанной стороны элемента (разрывает `float`-поток?). В примере из пред. пункта это приводит к тому, что `clear`-абзац перемещается в начало новой строки
- существует проблема, что если контейнер содержит только плавающие элементы, то их высота считается в 0px, и сам контейнер сжимается в линию. В книге дается решение решение с установкой контейнеру свойств `width: 100%; overflow: auto;` (современный подход: контейнеру устанавливается `display: flow-root;` (не поддерживается в Сафари))
- пример создания двух-трех-колоночного макета: у всех `div`-ов-столбцов, задан `float: left`, `margin` *и ширина*
- рассказ о разных форматах экранов. Разрешение мобильных может быть больше десктопов. Дизайнеры стараются создавать страницы 960-1000px шириной. Считается, что пользователь может просматривать верхние 570-600px без прокрутки, это называется "above the fold" (зд. "первый экран"), типографский термин, часть газеты над сгибом. Нужно стараться заинтересовать юзера тем, что на этом верхнем экране
- фиксированный макет, размеры в пикселах:
  * достоинства: хорошо контролируется, пропорции сохраняются
  * контент может не умещаться, шрифт становится слишком крупным/мелким, может оставаться пустое место
- "жидкий" макет, размеры в процентах:
  * достоинства: нет пустого места и проблем с размерами шрифтов
  * недостатки: непредсказуемость, картинки могут перекрыть текст, слишком длинные/короткие строки текста
- пример фиксированного макета: ширина `body` задается в 960px и оно фиксируется по центру (`margin: 0 auto`), 3 колонки фиксированной (300px) ширины
- пример "жидкого" макета: ширина `body` задается в 90% и оно фиксируется по центру (`margin: 0 auto`), 3 колонки переменной (31.3%) ширины. Можно использовать `min|max-width`
- пример вертикальной сетки шириной в 960px, в 12 колонок. Ширина блоков в каждой строке кратна колонке, промежутки между этими воображаемыми колонками сетки - это и промежутки между элементами в строках
- CSS-фреймворки протестированы в разных браузерах, имеют готовые решения. Но имена классов могут не соответствовать контенту (резделение содержания и представления), + фреймворк может содержать сильно больше нужного
- пример фреймворка 960.gs, игнорируем
- дизайнеры могут разделять CSS-код по нескольким файлам. Например, один управляет макетом, второй шрифтами, и т.д.
- можно подключать css-файлы не через тег `link` в HTML, а через `@import url("other.css")` прямо в CSS. Директива импорта должна идти в начале
- указание размеров изображений (через `width` и `height` в CSS) оптимизирует загрузку страницы. Можно, например, создать классы `small`/.../`large`
- обтекание изображений текстом делается через `float` у изображения (или задания этого `float` в классах `align-left|right`)
- выравнивание изображений по центру делается либо указанием `text-align: center` у родительского элемента (контейнера), либо через `margin: 0 auto`. В обоих случаях изображение нужно превратить в блочный элемент через `display: block` (по умолчанию `img` - строчный)
- выравнивание и прочие манипуляции с изображениями можно вести и с использованием HTML5-тегов `figure`/`figurecaption`
- фоновое изображение: `background-image: url("...")`. Свойство `background-repeat: repeat[-x|y]|no-repeat` управляет повторением (по дефолту `repeat`), а `background-attachment: scroll|fixed` - тем, должна ли картинка скролится
- свойство `background-position` получает 2 значения, либо словами (`left|top|...`) либо в пикселах или процентах. Стенгографическое свойство `background` перечисляет значения в след. порядке: `color`, `image`, `repeat`, `attachment`, `position`. Допускается использование сразу нескольких фоновых изображений (напр., одно снизу одно сверху)
- *ролловером* называется элемент, меняющий свое фоновое изображение, например, при наведении на него курсора. Может сочетаться со *спрайтом* - общей картинкой, разные части которой отображаются в элементе путем смены только `background-position`, но не самой картинки. Преимущества спрайта - в загрузке с сервера только одной картинки
- фоновую картинку можно задать и через градиент (возможно, с вендорными префиксами): `background-image: [-webkit|moz|o-]linear-gradient(...);`
- чтобы текст не терялся на фоновом изображении, оно должно иметь низкую контрастность
- HTML5-теги: сверху и снизу `header` и `footer`, между ними слева блок из нескольких `article`, справа `aside`. Блок `nav` - внутри `header`
- `header`/`footer` могут быть как колонтитулами всей страницы, так и (внутри) отдельных блоков `article`/`section` (напр., в `header` - название и дата сообщения, а в `footer` - ссылки для репоста в соцсетях)
- `nav` - основное (глобальное) меню навигации сайта
- `article` - любой независимый раздел страницы (статья, запись в блоге, комментарий, сообщение на форуме, и т.д.). Могут быть вложенными (напр., запись в блоге и вложенные `article` для каждого комментария)
- `aside`: еcли внутри `article`, то это косвенно связанная с ней информация (сторонний контент). Если вне, то это сторнний контент, относящийся ко всей странице, например, ссылки на другие разделы сайта, последние сообщения/твиты. MDN добавляет, что как правило располагается сбоку
- `section` - разделы. Тег группирует связанный контент, например, формирует разделы страницы, такие как последние новости, самые популярные товары или подписка на рассылку. Может группировать несколько `article`. Может он использоваться и внутри `article`, разбивая длинную статью на отдельные разделы
- `hgroup` удален из HTML5, служит для группировки `h1-h6`
- внутри непустого тега `figure` располагают теги `img` и `<figcaption>Legend</figcation>`
- когда нет подходящего элемента для группировки, возвращаемся к `div`. Книга не упоминает остальные семантические теги HTML5, типа `main`
- зачем-то пример оборачивания блочного элемента (`article`) тегом `a`
- эти новые теги в старых браузерах могут не распознаваться, и будут автоматически считаться inline. Можно добавить в CSS что-то вроде `article, nav, section... { display: block; }`
- условные комментарии `<!--[if lt IE 9]> ... <![endif]-->` упоминаются в контексте вставки js-скриптов HTML5-shiv/shim для поддержки новых тегов в старых IE
- пример на новые теги. Между хедером и футером слева `section` с несколькими `article` внутри, справа `aside` с несколькими `section` (группирующими ссылки и адрес кафе)
- дальше идет много об определении целевой аудитории сайта
- описывается метод *карточной сортировки*: каждый кусок информации заносится в отдельную карточку, после чего эти карты группируются, формируя страницы и разделы (сос воими главными страницами) сайта. Составляется *карта сайта* - диаграмма, показывающая структуру сайта, его компоновку
- *структурная схема* - схема компоновки, набросок каждой страницы, состоящий их блоков и lorem ipsum-текста. Хорошо бы делать его и обсуждать перед созданием дизайна
- что-то там о групировке контента, выставлении приоритетов, создание визуальной иерархии и передачи сообщений посредством дизайна
- меню навигации по сайту есть хорошо, должно быть: кратким (не больше 8 пунктов), ясным (юзер должен понимать, куда попадет с каждой ссылки), избирательным (ссылки только на основные разделы сайта). Меню навигаций может быть несколько, напр., одно сверху, одно сбоку, одно внизу (или под основным). Нужно выделять текущий пункт (юзер должен знать, гле сейчас находится)
- два направления поисковой оптимизации (SEO):
  * on-page: использование нужных ключевых слов на страницу, в том числе `alt`-ов для картинок
  * off-page: наличие ссылок на сайт на других ресурсов. Желательно чтобы ссылки включали (текст в теге `<a>...</a>`) те же ключевые слова, что и сама страница
- 7 мест куда стоит помещать ключевые слова: `title`, URL страницы, `h1`-`h6`, текст, текст ссылок, `alt` картинок, мета-тег описания (`description`?)
- описаны 6 способов подбора ключевых слов, пропускаем
- Google Anaytics: регистрируешься, получаешь код, вставляешь его на каждую страницу перед `</head>`, он шлет инфу на сервера гугла, когда кто-нибудь загружает страницу. В админке отображается расширенная статистика: кто заходил, когда, откуда (источник трафика), сколько пробыл, показатель отказа (выход сразу по переходу), сколько уников, что именно просматривают, и т.д.
- кратко о доменном имени, хостинге, его дисковых квотах, пропускной способности, почтовых ящиках, языках и базах данных, веб-платформах типа ВордПресса, FTP
- секция "Решение проблем", предметный указатель и список тегов, свойств и аттрибутов