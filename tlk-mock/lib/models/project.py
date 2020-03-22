from sqlalchemy import Column, BigInteger, String
from . import abstract


class Project(abstract.Abstract):
    __tablename__ = 'projects'

    id = Column(BigInteger, primary_key=True)
    username = Column(String(255), unique=True)

    def __init__(self):
        print('Model')
