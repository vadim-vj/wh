import sys
from typing import List
from PyQt5 import QtWidgets

from .main_window import MainWindow


def run(argv: List[str]) -> int:
    """Create application and main window."""
    app = QtWidgets.QApplication(argv)  # pylint: disable=c-extension-no-member
    app.setApplicationName('ONI player')

    window: MainWindow = MainWindow()
    window.showMaximized()

    return app.exec()


if __name__ == '__main__':
    sys.exit(run(sys.argv) or 0)
