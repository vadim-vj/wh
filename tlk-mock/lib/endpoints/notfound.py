from tornado import web
from . import abstract


class NotFound(abstract.Abstract):
    """Custom handler for 404 URLs
    
    We set it in `app.py`: `settings['default_handler_class'] = NotFound`
    """
    ROUTE = None
    SUPPORTED_METHODS = web.RequestHandler.SUPPORTED_METHODS

    def prepare(self):
        self.write_json_error(404, f'Unknown path: \'{self.request.uri}\'')
