from typing import Tuple
from types import ModuleType

import os
import asyncpg
from aiohttp import web

from .router import project, pool

# Add new routers here
ROUTERS: Tuple[ModuleType, ...] = (
    project,
    pool,
)


async def init_app() -> web.Application:
    """This func will be imported in top-level `__init__.py` of the package."""
    app = web.Application()

    # See <https://magicstack.github.io/asyncpg/current/usage.html#connection-pools>
    app['pool'] = await asyncpg.create_pool(os.getenv('DATABASE_URL'))
    assert isinstance(app['pool'], asyncpg.pool.Pool)

    for module in ROUTERS:
        # Register endpoints
        module.Router(app).register()

    return app
