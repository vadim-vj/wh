from PyQt5 import QtGui
import numpy as np

from .abstract import Player

# pylint: disable=c-extension-no-member


class DepthPlayer(Player):
    """Player for openni2.SENSOR_DEPTH."""

    def prepare_image_data(self, image):
        """From https://stackoverflow.com/a/55539208/8245749."""
        img = np.frombuffer(image.get_buffer_as_uint16(), dtype=np.uint16)

        img8 = (img / 256).astype(np.uint8)
        img8 = ((img8 - img8.min()) / (img8.ptp() / 255)).astype(np.uint8)

        return img8.repeat(4)

    @property
    def image_type(self) -> QtGui.QImage.Format:
        return QtGui.QImage.Format_RGB32
