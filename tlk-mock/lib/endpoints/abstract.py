import abc
import jsonschema
import os.path
from tornado import web, gen
import tornado_sqlalchemy as tsql

# Do NOT change inheritance order here: we probably
# won't need `super()` to be an instance of `SessionMixin` or `abc.ABC`
class Abstract(web.RequestHandler, tsql.SessionMixin, abc.ABC):
    """Base abstract class for all endopints

    We use the fact this class is abstract in `..utils.import_all()`:
    there we check module entries via `not inspect.isabstract(entry)`
    """
    ROUTE = r'/api/v1/'
    SUPPORTED_METHODS = ()

    def as_future(self, callable):
        return tsql.as_future(callable)

    @property
    def schema(self):
        """JSON file full name in `./schemas/` folder,
        e.g. `<full-path>/Projects.POST.json`"""
        return os.path.sep.join((
            os.path.dirname(__file__),
            'schemas',
            self.__class__.__name__ + '.' + self.request.method + '.json'
        ))

    def prepare(self):
        """Tornado hook; here we validate request body
        against a JSON schema. Called on each HTTP-request"""
        super().prepare()

        if self.request.body and os.path.isfile(self.schema):
            self.validate_against_schema()

        else:
            self._body = {}

    def validate_against_schema(self):
        """Throw `jsonschema.ValidationError` if body doesn't match"""
        with open(self.schema, 'r') as file:
            import json

            from tornado import escape
            body = escape.json_decode(self.request.body)

            jsonschema.validate(body, json.load(file))
            self._body = body

    def write_response(self, status, json):
        """Our custom method; shortcut"""
        self.set_status(status)
        self.write(json)
        self.finish()

    def write_json_error(self, code, obj):
        """We always return JSON object on error, not HTML"""
        self.write_response(code, {'error': str(obj)})

    def write_error(self, status_code, **kwargs):
        """Tornado method to handle exceptions. We use it to return
        exception body as <400, JSON-with-exception-message> response"""
        hasCustomError = False

        if status_code == 500 and 'exc_info' in kwargs:
            eType, eObj = kwargs.get('exc_info')[:2]

            if eType is jsonschema.exceptions.ValidationError:
                hasCustomError = True
                self.write_json_error(400, eObj)

        if not hasCustomError:
            super().write_error(status_code, **kwargs)
