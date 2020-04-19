class Position:
    pass


class Board:
    queens = 0

    @property
    def has_8_queens(self):
        return self.queens >= 8

    @property
    def unattacked_positions(self):
        return [Position(), Position()]

    def place_queen(self, position):
        self.queens += 1

    def remove_queen(self, position):
        pass

    def __str__(self):
        return str(self.queens)


def queens(board):
    if board.has_8_queens:
        return board

    for position in board.unattacked_positions:
        board.place_queen(position)
        solution = queens(board)

        if solution:
            return solution

        board.remove_queen(position)

    return False


# ---

if __name__ == "__main__":
    print(queens(Board()))
