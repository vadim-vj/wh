import os
import asyncio
import aiohttp

from tlkapi import init_app

if __name__ == '__main__':
    loop = asyncio.get_event_loop()
    app = loop.run_until_complete(init_app())

    aiohttp.web.run_app(app, port=int(os.environ.get('PORT', 5000)))
