from typing import Sequence, Tuple, Dict
from collections import defaultdict, Counter  # pylint: disable=import-self
from collections import abc  # pylint: disable=import-self
from operator import itemgetter
# import re


def w3_1(seq: Sequence[int]) -> Sequence[int]:
    counts: Dict[int, int] = Counter(seq)  # defaultdict(int)

    # for item in seq: # pylint: disable=redefined-outer-name
    #    counts[item] += 1

    result = []

    for item in seq:  # pylint: disable=redefined-outer-name
        result += [item] * counts[item]

    return result


def w3_2(seq: Sequence[int], num: int = None) -> Sequence[Tuple[int, int]]:
    counts: Counter = Counter(seq)

    if not num:
        num = len(counts)

    assert num > 0
    assert counts.items
    assert isinstance(counts.items(), abc.ItemsView)

    return sorted(counts.items(), key=itemgetter(1), reverse=True)[:num]


def cw_reverse_words(string: str) -> str:
    return ' '.join(map(lambda e: e[::-1], string.split(' ')))


DATA: Tuple[Tuple[int, ...], ...] = (
    (1, 2, 1, 3, 5),
    (4, 4, 4, 3, 4),
)


if __name__ == '__main__':
    # for item in DATA:
    #    print(w3_1(item))
    #    print(w3_2(item, 1))

    print(
        cw_reverse_words('This is an example!'),
        cw_reverse_words('double  spaces'),
        sep='\n'
    )
