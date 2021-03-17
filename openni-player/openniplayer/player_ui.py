from typing import List, Union
from collections import namedtuple
from PyQt5 import QtWidgets, QtGui, QtCore

from .assets import get_assets_path
from .player import players

# pylint: disable=c-extension-no-member


class PlayerUI:
    """QT components to display and control stream frames."""

    interval: int = 30  # milliseconds
    item_type = namedtuple('Item', ['pixmap', 'player'])

    def __init__(self) -> None:
        """Constructor."""
        self.items: List[PlayerUI.item_type] = []

        self.button_center = QtWidgets.QPushButton('Play')
        self.slider = QtWidgets.QSlider(QtCore.Qt.Horizontal)
        self.timer = QtCore.QTimer()

    def init_ui(self, grid: QtWidgets.QGridLayout) -> None:
        """Set playback controls and image widgets."""
        for i, player in enumerate(players):
            view = QtWidgets.QGraphicsView()
            scene = QtWidgets.QGraphicsScene()
            pixmap = QtWidgets.QGraphicsPixmapItem()

            scene.addItem(pixmap)
            view.setScene(scene)

            self.items.append(self.item_type(pixmap, player))
            grid.addWidget(view, 0, i)

        self.slider.valueChanged.connect(self.slide)

        controls_box = QtWidgets.QGroupBox()
        controls = QtWidgets.QHBoxLayout(controls_box)

        button_left = QtWidgets.QPushButton('<<')
        button_left.clicked.connect(self.prev_frame)

        button_right = QtWidgets.QPushButton('>>')
        button_right.clicked.connect(self.next_frame)

        self.button_center.clicked.connect(self.play_pause)
        self.timer.timeout.connect(self.time)

        controls.addWidget(button_left)
        controls.addWidget(self.button_center)
        controls.addWidget(button_right)

        grid.addWidget(self.slider, 1, 0, 1, 2)
        controls_box.setLayout(controls)
        grid.addWidget(controls_box, 2, 0, 2, 2)

    def play_pause(self) -> None:
        """Play/Pause button handler."""
        if self.timer.isActive():
            self.timer.stop()
            self.button_center.setText('Play')

        else:
            self.timer.start(self.interval)
            self.button_center.setText('Pause')

    def change_position(self, delta):
        """Helper to process both players."""
        for item in self.items:
            item.player.position += delta

    def set_images(self) -> Union[QtGui.QImage, None]:
        """Draw both images, color and depths."""
        data = None

        for item in self.items:
            if item.player.position - item.player.frames_available > 10:
                item.pixmap.setPixmap(QtGui.QPixmap(
                    get_assets_path('loading.png')))
                QtWidgets.qApp.processEvents()

        for item in self.items:
            data = item.player.get_image()

            if data:
                item.pixmap.setPixmap(
                    QtGui.QPixmap.fromImage(data)
                )

                # pylint: disable=attribute-defined-outside-init
                self._prevent_slide = True
                self.slider.setValue(int(
                    (item.player.position / max(1, item.player.max_position - 1))
                    * self.slider.maximum()
                ))
                self._prevent_slide = False

        return data

    def slide(self):
        """Slider handler."""
        if self._prevent_slide:
            return None

        for item in self.items:
            item.player.position = int(
                item.player.max_position * self.slider.value()
                / self.slider.maximum()
            )

        self.set_images()

    def open(self, name: str) -> None:
        """Open file dialog handler."""
        for item in self.items:
            item.player.name = name
            item.player.position = 0
            self.slider.setRange(0, item.player.max_position)

        self.set_images()

    def prev_frame(self) -> None:
        """Prev button handler."""
        self.change_position(-1)

        self.set_images()

    def next_frame(self) -> Union[QtGui.QImage, None]:
        """Next button handler."""
        self.change_position(1)

        return self.set_images()

    def time(self) -> None:
        """Timer handler - support for video play."""
        if not self.next_frame():
            self.play_pause()

            for item in self.items:
                item.player.position = 0

    def cleanup(self) -> None:
        """Unload library."""
        for item in self.items:
            item.player.cleanup()
