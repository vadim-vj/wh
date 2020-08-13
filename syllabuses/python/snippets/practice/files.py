from typing import List
import os

PATH = os.path.dirname(os.path.abspath(__file__)) + os.sep


def w3_2(file: str, n: int) -> List[str]:
    result: List[str] = []

    with open(PATH + file, encoding='windows-1251') as fin:
        for line in fin:
            if not line.strip():
                continue

            result.append(line.rstrip())

            if len(result) >= n:
                break

    return result


if __name__ == '__main__':
    print(w3_2('_.txt', 10))
