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
- marshmallow

#### 3. Improving API, Authentication with Flask

#### 4. Testing and Deploying Flask API
- pytest

#### 5. Developing RESTful APIs with Django
- рассматривается каталог игр. Используется Django Rest Framework (DRF) и SQLLite для ORM

#### 6. Class-Based Views and Hyperlinked APIs in Django

#### 7. Improving API, Authentication with Django

#### 8. Throttling, Filtering, Testing, and Deploying an API with Django

#### 9. Developing RESTful APIs with Pyramid
- без ORM, словарь в памяти

#### 10. Developing RESTful APIs with Tornado
- без ORM, 2 файла. Асинхронный неблокирующий фреймворк, в методах моделей используется `sleep()` для имитации задержек ответа
- в `drone.py` задаются модели дрона и его компонентов, и задается сам объект: `if __name__ == '__main__': \n\t hexacopter = Hexacopter()`
- в моделях есть примеры использования геттера/сеттера, напр., `motor_speed` через внутреннюю переменную `_motor_speed`
- в файле `drone_service.py` на каждый endpoint определяются классы-потомки `tornado.web.RequestHandler` с методами `get()`/`patch()`/etc, в классе-наследнике `tornado.web.Application` они передаются родительскому конструктору как список кортежей "паттерн_урла-класс". Под `if __name__ == "__main__":` этот класс приложения инстантиируется, и на нем запускается цикл прослушки порта
- здесь уже статусы берутся из `from http import HTTPStatus`
- в классах хендлеров нужно определять переменную `SUPPORTED_METHODS` (иначе 405), причем `GET` в ней указан по дефолту (будет проходить, если не переопределить)
- параметры запроса в методы `get()`/`patch()`/etc передаются как аргументы функции (парсить ничего не надо), а ответ в них дается через `self.set_status(HTTPStatus.OK)` и, опционально, `self.write(response)`. Если у последнего аргумент имеет тип `dict`, Торнадо автоматически выставит `Content-Type = application/json`
- параметры передаются только для паттернов урлов, а вот тело запроса для `POST`/`PATCH` уже нужно получать через `request_data = tornado.escape.json_decode(self.request.body)` - отдает в виде словаря
- параметры урлов, идущие после знака вопроса (напр., `/endpoint/2?unit=meters`) можно получать через `self.get_arguments(name='unit')`

#### 11. Asynchronous Code, Testing, and Deploying an API with Tornado
- по умолчанию сервер Торнадо выполняет запросы синхронно - ждет пока выполнится каждый. В этом разделе они делаются асинхронными
- у методов `get()`/`patch()`/etc появляются декораторы `@tornado.gen.coroutine`, методы моделей с задержками выносятся в отдельные функции с декоратором `@run_on_executor(executor="_thread_pool_executor")`, а вызовы этих функций делаются через `yield`: `hexacopter_status = yield self.retrieve_hexacopter_status()`
- перед возвратами по причине ошибки и после записи контента в случае успеха вызывается `self.finish()`
- в классах-потомках `RequestHandler`-а объявляется свойство `_thread_pool_executor = thread_pool_executor`, для сохранения ссылки на `tornado.concurrent.futures.ThreadPoolExecutor` (???)
- в файле `setup.cfg` хранится конфиг pytest-а, а в файле `tests.py` - сами тесты: функция `def app():` с декоратором `@pytest.fixture`, возвращающая приложение, и метод(ы) `async def test_...(http_server_client)`. Внутри последних выполняются запросы (через `await http_server_client.fetch()`), а их результат проверяется в `assert`-ах
- запуск тестов: `pytest --cov -v`, заодно считает покрытие
- в папке `htmlcov/` лежит визуализация этого покрытия. Его перегенерация: `coverage html`
- показ непокрытых тестами частей: `coverage report -m`
- Tornado не поддерживает асинхронные операции, когда выполняется в WSGI-среде
