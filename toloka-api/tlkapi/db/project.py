from typing import List, Dict, Awaitable, Any
from asyncpg import Record
from asyncpg.connection import Connection

from .abstract import Abstract


class Project(Abstract):
    """Projects' database connector."""

    def _prepare_params(self, query: Dict[str, List[str]], params: Dict[str, str]) -> None:
        """Internal method. Prepare query params."""
        if params.get('status'):
            query['statements'].append('status = $1')
            query['params'].append(params['status'])

    def _get_query(self, connection: Connection, params: Dict[str, str]) -> Awaitable[Record]:
        """Internal method. Return query to fetch."""
        query: Dict[str, List[str]] = {
            'statements': [],
            'params': [],
        }

        self._prepare_params(query, params)

        return connection.fetch(
            'SELECT * FROM projects' +
            (' WHERE ' + ', '.join(query['statements'])
             if query['statements'] else ''),
            *query['params']
        )

    async def get_all(self, params: Dict[str, str]) -> Dict[str, Any]:
        """Return all DB records."""
        async def _get(connection: Connection) -> Dict[str, Any]:
            """Internal func. Fetch records."""
            result: List[Record] = []

            for record in await self._get_query(connection, params):
                record = dict(record)
                record['created'] = str(record['created'])

                result.append(record)

            return {
                'items': result,
                'has_more': False,
            }

        return await self._handle_request(_get)
