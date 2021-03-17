from typing import List, Dict, Any
from aiohttp.web_routedef import RouteDef
from aiohttp.web_response import Response

from .abstract import Abstract
from ..db.pool import Pool


class Router(Abstract):
    """Task pool endpoint."""

    def _get_params_schema(self) -> Dict[str, Any]:
        """Define default DB params."""
        return {**super()._get_params_schema(), **{
            'status': None
        }}

    async def get_all(self, request: RouteDef) -> Response:
        """Get all DB records as JSON response."""
        return self.web.json_response(
            await Pool(self.app['pool']).get_all(self._get_params(request))
        )

    def get_routes(self) -> List[RouteDef]:
        """Define endpoints."""
        return [
            self.web.get('/pools', self.get_all),
        ]
