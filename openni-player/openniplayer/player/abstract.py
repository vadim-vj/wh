import abc
from typing import List, Tuple, Union
from PyQt5 import QtGui
from openni import openni2

# pylint: disable=c-extension-no-member


class Player(abc.ABC):
    """Abstract class for ONI player."""

    def __init__(self, player_type: int) -> None:
        """Types: SENSOR_{COLOR|DEPTH}."""
        self.player_type: int = player_type

        self._name: str = ''
        self._position: int = -1
        self._stream: openni2.VideoStream = None
        self._frames: List[openni2.VideoFrame] = []

        openni2.initialize()

    @property
    def name(self) -> str:
        """File name."""
        return self._name

    @name.setter
    def name(self, value: str) -> None:
        """File name."""
        if self._name:
            self.stream.stop()

        self._stream = None
        self._frames = []
        self._name = value

    @property
    def stream(self) -> openni2.VideoStream:
        """Lazy load for stream."""
        if self._stream is None:
            self._stream = openni2.VideoStream(
                openni2.Device(self.name.encode()),
                self.player_type
            )
            self._stream.start()

        return self._stream

    @property
    def max_position(self) -> int:
        """Max number of frames in stream."""
        return self.stream.get_number_of_frames()

    @property
    def frames_available(self) -> int:
        """Number of already loaded frames."""
        return len(self._frames)

    @property
    def position(self) -> int:
        """Current position in stream."""
        return self._position

    @position.setter
    def position(self, value: int) -> None:
        """Setter with margin control."""
        if value > self.max_position:
            self._position = self.max_position
        elif value < 0:
            self._position = 0
        else:
            self._position = value

    def get_image_data(self) -> Union[Tuple[int, ...], None]:
        """Open `.oni` file."""
        image = self.get_image_frame()

        if image:
            return (
                self.prepare_image_data(image),
                image.width,
                image.height,
                self.image_type,
            )

        return None

    def get_image_frame(self) -> openni2.VideoFrame:
        """Read and cache frames."""
        if self.position < self.max_position:
            while self.frames_available <= self.position:
                self._frames.append(self.stream.read_frame())

            return self._frames[self.position]

        return None

    def prepare_image_data(self, image: openni2.VideoFrame) -> int:
        """Will be overloaded for DEPTH stream."""
        return image.data

    def get_image(self) -> Union[QtGui.QImage, None]:
        """Construct QT image from stream data."""
        data = self.get_image_data()

        return QtGui.QImage(*data) if data else None

    def cleanup(self) -> None:
        """Unload library."""
        openni2.unload()

    @property
    def image_type(self) -> QtGui.QImage.Format:
        """Qt image format to convert to."""
        return QtGui.QImage.Format_RGB888
