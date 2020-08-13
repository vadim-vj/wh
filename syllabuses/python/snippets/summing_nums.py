def mysum(*args, sum=0):
    for arg in args:
        try:
            sum += arg
        except TypeError:
            pass

    return sum


def avg(*args):
    return mysum(*args) / len(args)


def words(lst):
    lengths = [float("inf"), 0, avg(*map(lambda e: len(e), lst))]

    for word in lst:
        length = len(word)

        if length < lengths[0]:
            lengths[0] = length

        elif length > lengths[1]:
            lengths[1] = length

    return tuple(lengths)


if __name__ == "__main__":
    for seq in ((1, 2, 3), (5, 3, 1, 1, 1)):
        print(mysum(*seq), avg(*seq))

    print(mysum(1, 2, 3))
    print(words(("111", "444444", "fdsa")))
    print(mysum({}, 3, 4, "dewdew", 5))
