from typing import Tuple
from openni import openni2

from .abstract import Player
from .color import ColorPlayer
from .depth import DepthPlayer

players: Tuple[Player, ...] = (
    ColorPlayer(openni2.SENSOR_COLOR),
    DepthPlayer(openni2.SENSOR_DEPTH),
)
