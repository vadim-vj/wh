import os

from tornado import httpserver, ioloop, web
from tornado.options import define, options
#from tornado_sqlalchemy import SQLAlchemy

import lib
from lib.endpoints import NotFound
from lib.models import db
from lib import globals
# or
# lib.init(port=8888)

debug = True
define('port', default=globals.PORT, help='Listening port', type=str)

print(lib.endpoints.__all__)


class Application(web.Application):
    def __init__(self, **settings):
        settings['default_handler_class'] = NotFound
        settings['db'] = db

        super(Application, self).__init__(
            map(lambda classObj: (classObj.ROUTE, classObj), lib.endpoints.__all__),
            **settings
        )


def main():
    options.parse_command_line()
    httpserver.HTTPServer(Application(debug=debug)).listen(options.port)
    ioloop.IOLoop.instance().start()


if __name__ == '__main__':
    main()
