"""Here should be a docstring"""
from ..utils import import_all
from .abstract import Abstract
from .notfound import NotFound

__all__ = import_all(
    __file__,
    __package__,
    lambda entry:
        isinstance(entry, type(Abstract))
        and entry.ROUTE
        and not entry.ROUTE.endswith('/')
)
del import_all, Abstract
