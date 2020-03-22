from tornado import gen
from . import abstract
from ..models import project


class Projects(abstract.Abstract):
    ROUTE = abstract.Abstract.ROUTE + r'projects'
    SUPPORTED_METHODS = ('GET', 'POST')

    @gen.coroutine
    def post(self):
        newProject = project.Project()

        with self.make_session() as session:
            session.add(newProject)
            session.flush()
            print(newProject.id)

        self.write_response(200, self._body)

    @gen.coroutine
    def get(self):
        with self.make_session() as session:
            self.write_response(200, {
                'items': (yield self.as_future(session.query(project.Project).all)),
                'hasMore': False,
            })


class ProjectsId(abstract.Abstract):
    ROUTE = Projects.ROUTE + r'/(\d+)'
    SUPPORTED_METHODS = ('GET', 'PUT')

    @gen.coroutine
    def put(self, id):
        self._body['id'] = int(id)
        self.write_response(200, self._body)

    @gen.coroutine
    def get(self, id):
        self.write_response(200, {'id': id})


class ProjectsIdArchive(abstract.Abstract):
    ROUTE = ProjectsId.ROUTE + r'/archive'
    SUPPORTED_METHODS = ('POST')

    @gen.coroutine
    def post(self, id):
        self.write_response(200, {'id': id})
