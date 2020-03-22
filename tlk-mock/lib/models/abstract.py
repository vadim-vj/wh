import os
import abc
import tornado_sqlalchemy as tsql

db = tsql.SQLAlchemy(os.environ['DATABASE_URL'], engine_options={'echo': True})

class AbstractMeta(type(db.Model), abc.ABCMeta):
    pass


class Abstract(db.Model, abc.ABC, metaclass=AbstractMeta):
    __abstract__ = True
