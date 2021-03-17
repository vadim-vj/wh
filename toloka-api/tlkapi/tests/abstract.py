import os
import abc

from aiohttp import web
from aiohttp.test_utils import AioHTTPTestCase

from ..common import init_app


class Abstract(abc.ABC, AioHTTPTestCase):
    """Abstract class for all test cases."""
    async def get_application(self) -> web.Application:
        """Async function to get web-app instance."""
        return await init_app()

    def get_json_path(self, name: str) -> str:
        """Return path to a JSON file with response."""
        return f'{os.path.dirname(__file__)}/json/{name}.json'
