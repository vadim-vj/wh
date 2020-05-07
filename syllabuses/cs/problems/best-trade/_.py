import math
from operator import gt, lt

def min_max_with_index(op, *args):
    if hasattr(args[0], '__iter__'):
        args = args[0]

    sign = -1 if op == gt else 1
    m_el = (None, sign * math.inf)

    for el in enumerate(args):
        if op(el[1], m_el[1]):
            m_el = el

    return m_el

def min_with_index(*args):
    return min_max_with_index(lt, *args)

def max_with_index(*args):
    return min_max_with_index(gt, *args)

def best_trade(arr):
    length = len(arr)

    if length == 1:
        return 0

    middle = length // 2
    former = arr[:middle]
    latter = arr[middle:]

    return max(
        best_trade(former),
        best_trade(latter),
        max(latter) - min(former)
    )

def best_trade_dq(P):
    B = [None, 1]
    sell_day = 0
    best_profit = 0

    for n in range(2, len(P)):
        B.append(n if P[n] < P[B[n - 1]] else B[n - 1])
        profit = P[n] - P[B[n]]

        if profit > best_profit:
            sell_day = n
            best_profit = profit

    return (sell_day, B)

# ---

if __name__ == '__main__':
    data = (
        (27, 53, 7, 25, 33, 2, 32, 47, 43),
    )

    for d in data:
        print(best_trade(d))
        print(best_trade_dq(d))
