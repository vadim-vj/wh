import abc

from typing import List, Dict, Any
from aiohttp import web
from aiohttp.web_routedef import RouteDef


class Abstract(abc.ABC):
    """Abstract class for all endpoints."""

    def __init__(self, app: web.Application) -> None:
        """Cache web-app instances."""
        self.web = web
        self.app = app
    
    def _get_params_schema(self) -> Dict[str, Any]:
        """Return default DB query params."""
        return {}

    def _get_params(self, request) -> Dict[str, Any]:
        """Return DB query params."""
        return {key: (request.query.get(key, value) or value)
                for (key, value) in self._get_params_schema().items()}

    def register(self) -> None:
        """Will be called from the `..common`."""
        self.app.add_routes(self.get_routes())

    @abc.abstractmethod
    def get_routes(self) -> List[RouteDef]:
        """Each endpoint must define its own routes."""
