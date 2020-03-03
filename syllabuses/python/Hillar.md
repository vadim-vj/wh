### Hiilar G., Hands-On RESTful Python Web Services
<https://www.packtpub.com/application-development/hands-restful-python-web-services-second-edition>

---

Код примеров: <https://github.com/PacktPublishing/Hands-On-RESTful-Python-Web-Services-Second-Edition>

<!-- Конспектируем только (первые) общие части и про Flask. -->

#### 1. RESTful APIs and Microservices with Flask
- в первой главе не рассматривается ORM, словарь сообщений хранится в памяти. Используется расширение Flask-RESTful
- использует разные методы (`GET`/`POST`/`DELETE`/etc) для разных действий, и HTTP-коды в качестве результата (статуса) операции
- микросервисы получают всё большее распространение (особенно в рамках CD), и RESTful-сервисы - важная их часть
- использует пакет `venv` для создания виртуальных сред
- ни Flask, ни Flask-RESTful не определяют HTTP-коды, поэтому от `Enum` наследуется класс, атрибуты которого - эти самые HTTP-коды (в виде целых чисел), а статические методы (`@staticmethod`) определяют принадлежность кода группе (`100 <= status_code.value <= 199`)
- помимо кодов определяется класс модели сообщения и файл сервиса - собственно приложения Flask. В последнем определяются класс менеджера сообщений (хранит словарь сообщений `id: notif` и методы работы с этим словарем)
- у класса `NotificationManager` использует статическую переменную `self.__class__.last_id` для хранения последнего сообщения
- модуль `flask_restful.fields` хранит описания типов полей. С его использованием составляется словарь, напр., `notification_fields = { 'id': fields.Integer, 'uri': fields.Url('notification_endpoint'), ... }`. `Url` в этом примере вернет относительный урл запрашиваемого ресурса
- определяются классы-потомки `flask_restful.Resource` - фактически обработчики каждого endpoint-а. В этом классе методы с именами HTTP-методов - `def (get|patch|delete|...)(self, id):`. У методов, возвращающих сообщение, задаются декораторы `@marshal_with(notification_fields)` - форматирование и фильтрация возвращаемого объекта по словарю, определенному в пред. пункте (передается как аргумент декоратора). Такое декорирование автоматически возвращает код 200. Для возврата другого кода нужно делать `return notif, <code>`
- для возврата значений используют объект-хранилище сообщений, напр., `notification_manager.get_notification(id)`
- в самом объемном методе `patch()` (обновление сообщение) используется объект типа `flask_restful.reqparse.RequestParser()`
- во всех методах идет проверка через вспомогательный (предварительно определенный) метод `abort_if_notification_not_found()`
- похожий класс-потомок `Resource` - `NotificationList` - определяется для второго endpoint-а
- если HTTP-метод не описан в классе ресурса (endpoint-а) Flask-RESTful вернет `405 Method Not Allowed`
- в том же файле `service.py`, со всеми этими классами ресурсов, объявляется Flask-приложение: `app = Flask(__name__); service = Api(app); service.add_resource(Notification, '/service/notifications/<int:id>'); ...`
- в `service.add_resource()` можно передать `endpoint='<name>'` - по этому имени потом можно ссылаться на урл в классе ресурса, напр., в `fields.Url('<name>')`
- параметры запуска приложения через командную строку: `app.run(host='0.0.0.0', debug=True)`
- идут примеры выполнения запросов через HTTPie и CURL, через графическую тулзу Postman, через HTTP-клиент, встроенный в PyCharm, iCurlHTTP на iOS
- метод `PATCH` может использоваться для модификации существующего объекта (в нашем примере сообщения), а `PUT` - для замены объекта целиком
- `204 No Content` возвращается при успешном удалении существующего объекта

#### 2. Working with Models, SQLAlchemy, and Hyperlinked APIs in Flask
-
