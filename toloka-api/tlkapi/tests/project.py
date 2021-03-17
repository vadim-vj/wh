import json
from aiohttp.test_utils import unittest_run_loop

from .abstract import Abstract


class Project(Abstract):
    """Projects' tests."""
    @unittest_run_loop
    async def test_get_list(self) -> None:
        """Get all records for projects."""
        resp = await self.client.request('GET', '/projects')
        assert resp.status == 200

        body = await resp.json()
        with open(self.get_json_path('projects')) as fin:
            for i, _ in enumerate(body['items']):
                del body['items'][i]['created']

            assert json.load(fin) == body
