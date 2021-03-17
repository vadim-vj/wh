"""Main UI window class."""

from PyQt5 import QtWidgets, QtGui

from .assets import get_assets_path
from .player_ui import PlayerUI

# pylint: disable=c-extension-no-member


class MainWindow(QtWidgets.QMainWindow):
    """Application main window class."""

    def __init__(self) -> None:
        """Set class properties and run `.initUI()`."""
        super().__init__()

        self.widget = QtWidgets.QWidget(self)
        self.grid = QtWidgets.QGridLayout(self.widget)
        self.widget.setLayout(self.grid)

        self.player = PlayerUI()
        self.init_ui()

    def init_ui(self) -> None:
        """Create window UI components."""
        open_file = QtWidgets.QAction('Open', self)
        open_file.setShortcut('Ctrl+O')
        open_file.triggered.connect(self.file_dialog)

        quit_file = QtWidgets.QAction('Quit', self)
        quit_file.setShortcut('Ctrl+Q')
        quit_file.triggered.connect(self.close)

        menu_bar = self.menuBar()
        file_menu = menu_bar.addMenu('&File')
        file_menu.addAction(open_file)
        file_menu.addAction(quit_file)

        self.setMinimumSize(400, 300)
        self.setWindowTitle('Player for .oni files')
        self.setWindowIcon(QtGui.QIcon(get_assets_path('openni.png')))

        self.player.init_ui(self.grid)

    def file_dialog(self) -> None:
        """Open `.oni` file."""
        name, *_ = QtWidgets.QFileDialog.getOpenFileName(
            self,
            'Open file',
            '',
            '*.oni'
        )

        self.player.open(name)

    def resizeEvent(self, event: QtGui.QResizeEvent) -> None:
        """Adjust player size."""
        # pylint: disable=unused-argument,invalid-name
        self.widget.setGeometry(
            0,
            self.menuBar().height(),
            self.width(),
            self.height() - self.menuBar().height(),
        )

    def closeEvent(self, event: QtGui.QCloseEvent) -> None:
        # pylint: disable=unused-argument,invalid-name
        self.player.cleanup()
