"""Helper functions."""

import os


def get_assets_path(path: str) -> str:
    """Compose path from passed string and the `./assets/` dir."""
    return os.path.join(assets_path(), path)


def assets_path() -> str:
    """Return full path to the `./assets/` directory."""
    return os.path.join(os.path.dirname(os.path.abspath(__file__)), 'assets')
