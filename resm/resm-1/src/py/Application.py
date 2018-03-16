# vim: set ts=4 sw=4 sts=4 et:

#
# Application singleton
#
# @author  Vadim Sannikov <vsj.vadim@gmail.com> 
# @version $id$
# @link    ____link____

#
# Application
#
class Application(object):
    """ Main service class """

    #
    # Block names in resources' structure
    #
    __API_BLOCK_ALLOC   = 'allocated'
    __API_BLOCK_DEALLOC = 'deallocated'

    #
    # Config var names
    #
    __NAME_SECTION_MAIN = 'Main'
    __NAME_ADDRESS   = 'address'
    __NAME_PORT      = 'port'
    __NAME_RES_COUNT = 'res_count'
    __NAME_RES_PREF  = 'res_prefix'
    __NAME_TEST_MODE = 'test_mode'

    #
    # Pattern to parse first line of HTTP/1.1 header.
    # See also http://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html#sec5.1
    #
    __PATTERN = r'\s*GET\s+/?(allocate/[\w\.\-]+|deallocate/\w+\d+|list(?:/[\w\.\-]+)?|reset)/?(?:\s+|$)'

    #
    # __instance
    #
    __instance = None

    #
    # __config
    #
    __config = {}

    #
    # Main socket
    #
    __server = None

    #
    # Resources list
    #
    __resources = {}

    #
    # __new__
    #
    def __new__(cls, config_file = None):
        if cls.__instance is None:
            cls.__instance = super(cls.__class__, cls).__new__(cls)

            if config_file:
                cls.__instance.init(config_file)

        return cls.__instance

    #
    # __del__
    #
    def __del__(self):
        self.close_socket(self.get_server())

    #
    # Initialization
    #
    @classmethod
    def init(cls, config_path):
        import ConfigParser

        parser = ConfigParser.ConfigParser()
        parser.read(config_path)
        cls.__config = dict(parser.items(cls.__NAME_SECTION_MAIN))
        cls.__config[cls.__NAME_RES_COUNT] = parser.getint(cls.__NAME_SECTION_MAIN, cls.__NAME_RES_COUNT)
        cls.__config[cls.__NAME_TEST_MODE] = parser.getboolean(cls.__NAME_SECTION_MAIN, cls.__NAME_TEST_MODE)

        cls.__resources[cls.__API_BLOCK_ALLOC]   = {}
        cls.__resources[cls.__API_BLOCK_DEALLOC] = map(
            lambda x: cls.__config.get(cls.__NAME_RES_PREF) + str(x),
            range(1, cls.__config.get(cls.__NAME_RES_COUNT) + 1)
        )

    #
    # Return main socket
    #
    def get_server(self):
        if not self.__server:
            import socket

            self.__server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
            self.__server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
            self.__server.bind((self.__config.get(self.__NAME_ADDRESS), int(self.__config.get(self.__NAME_PORT))))
            self.__server.listen(1)

        return self.__server

    #
    # Process request
    #
    def process_request(self, request, add_test_info = False):
        import os, re, json

        data = [400, 'Bad Request', 'Bad Request']

        if request:
            match = re.match(self.__PATTERN, request, re.IGNORECASE)

            if match and match.group(1):
                args = match.group(1).split('/')
                result = getattr(self, args.pop(0) + 'API')(*args)

                if result:
                    data = result

        result = 'HTTP/1.1 ' + str(data[0]) + ' ' + data[1] + os.linesep \
            + 'Content-Type: ' + ('text/plain' if add_test_info else 'application/json') + '; charset=utf-8'

        if (data[2] is not None) or add_test_info:
            if data[2] is None:
                data[2] = ''

            else:
                data[2] = json.dumps(data[2], sort_keys=True)

            if add_test_info:
                data[2] += self.add_test_info(data[0], data[1], request)

            result += os.linesep + os.linesep + data[2]

        return result

    #
    # Run
    #
    def run(self):
        while True:
            connection, address = self.get_server().accept()

            if connection:
                makefile = connection.makefile('r')

                if makefile:
                    request = makefile.readline()
                    makefile.close()

                else:
                    request = False

                connection.send(self.process_request(request, self.__config.get(self.__NAME_TEST_MODE)))
                self.close_socket(connection)

    # {{{ API

    #
    # Allocate resource for user
    #
    def allocateAPI(self, user):

        if self.__resources[self.__API_BLOCK_DEALLOC]:
            res = self.__resources[self.__API_BLOCK_DEALLOC].pop(0)
            self.__resources[self.__API_BLOCK_ALLOC][res] = user

            result = [201, 'Created', res]

        else:
            result = [503, 'Service Unavailable', 'Out of resources']

        return result

    #
    # Deallocate resource by name
    #
    def deallocateAPI(self, res):

        if self.__resources[self.__API_BLOCK_ALLOC].get(res):
            del self.__resources[self.__API_BLOCK_ALLOC][res]
            self.__resources[self.__API_BLOCK_DEALLOC].append(res)
            self.__resources[self.__API_BLOCK_DEALLOC].sort()

            result = [204, 'No Content', None]

        else:
            result = [404, 'Not Found', 'Not allocated']

        return result

    #
    # List resources
    #
    def listAPI(self, user = None):

        if user:
            result = []

            for key, val in self.__resources[self.__API_BLOCK_ALLOC].iteritems():
                if val == user:
                    result.append(key)

            result.sort()

        else:
            result = self.__resources

            if not result[self.__API_BLOCK_ALLOC]:
                result[self.__API_BLOCK_ALLOC] = []

        return [200, 'OK', result]

    #
    # Reset resources list state
    #
    def resetAPI(self):
        self.__resources[self.__API_BLOCK_DEALLOC] += self.__resources[self.__API_BLOCK_ALLOC].keys()
        self.__resources[self.__API_BLOCK_DEALLOC].sort()
        self.__resources[self.__API_BLOCK_ALLOC] = {};

        return [204, 'No Content', None];

    # }}}

    #
    # add_test_info
    #
    def add_test_info(self, status, phrase, request):
        import os

        result  = os.linesep + os.linesep + '=============== Test info ===============' + os.linesep
        result += str(status) + ': ' + phrase + os.linesep + os.linesep
        result += 'Request:   "' + request.strip('/' + os.linesep) + '"' + os.linesep
        result += 'Resources: "' + str(self.__resources) + '"' + os.linesep

        return result

    #
    # Close resource
    #
    def close_socket(self, resource):
        import socket

        resource.shutdown(socket.SHUT_RDWR)
        resource.close()
