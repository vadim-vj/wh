"""Here should be a docstring"""
from ..utils import import_all
from .abstract import Abstract, db

__all__ = import_all(
    __file__,
    __package__,
    lambda entry:
        isinstance(entry, type(Abstract))
        and not entry.__abstract__
)

db.create_all()
del import_all, Abstract
