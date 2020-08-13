import typing


@typing.no_type_check
def greeting(name: str) -> str:
    return 'Hello ' + name


class A:
    a: int = 3

    def __init__(self, i: int) -> None:
        self.i = i


if __name__ == '__main__':
    print(greeting('wqsq'))
    print(greeting.__annotations__)
    print(typing.get_type_hints(A))

    A(1)
