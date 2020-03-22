from tornado import gen
from .abstract import Abstract


class Test1(Abstract):
    ROUTE = Abstract.ROUTE + 'test1/([0-9]+)'

    @gen.coroutine
    def get(self, id):
        response = {'test1': id}

        self.set_status(200)
        self.write(response)
        self.finish()

    @gen.coroutine
    def post(self):
        pass
