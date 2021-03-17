import abc

from typing import Any, Dict, Coroutine, Callable
from asyncpg.pool import Pool
from asyncpg.connection import Connection


class Abstract(abc.ABC):
    """Abstract class for all DB-subpackage classes."""

    def __init__(self, pool: Pool) -> None:
        """Cache the `asyncpg.pool.Pool` instance."""
        self.pool = pool

    async def _handle_request(self, func: Callable[[Connection], Coroutine[Any, Any, Dict[str, Any]]]):
        """Helper func to aquire DB connection from the pool."""
        async with self.pool.acquire() as connection:
            async with connection.transaction():
                # Run passed func asynchronously
                return await func(connection)
