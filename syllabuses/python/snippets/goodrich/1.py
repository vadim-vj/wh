import random
from collections import Counter


def is_multiple(n, m):
    return not n % m


def is_even(k):
    return not k & 1


def minmax(data):
    minimum = maximum = data.pop(0) if data else None

    for item in data or ():
        if item < minimum:
            minimum = item
        if item > maximum:
            maximum = item

    return minimum, maximum


def squares_sum(n):
    sum_val = 0

    for i in range(1, n):
        sum_val += i ** 2

    return sum_val


def squares_sum_odd(n):
    sum_val = 0

    for i in range(1, n, 2):
        sum_val += i ** 2

    return sum_val


def choice(seq: list):
    return seq[random.randrange(len(seq))]


def get_distinct_pair_gen(seq):
    for i, item_outer in enumerate(seq):
        for item_inner in seq[i+1:]:
            if (item_inner * item_outer) % 2 != 0:
                yield (item_outer, item_inner)


def get_distinct_pair(seq):
    cntr = Counter(get_distinct_pair_gen(seq))

    return (key for key, cnt in cntr.items() if cnt == 1)


def are_all_distinct(seq):
    distinct_set = set()

    for item in seq:
        if item in distinct_set:
            return False

        else:
            distinct_set.add(item)

    return True


def shuffle(seq):
    while seq:
        yield seq.pop(random.randint(0, len(seq) - 1))


def shuffle_inplace(seq):
    length = len(seq) - 1

    for i in range(length):
        j = random.randint(i + 1, length)
        seq[i], seq[j] = seq[j], seq[i]

def input_reverse():
    result = []

    while True:
        try:
            line = input('Enter a line: ')
        except EOFError:
            break
        else:
            result.append(line)

    print('\n', list(reversed(result)))

def get_vowels_count(string):
    return len([char for char in string if char in 'aeiou'])

def remove_punctuation(string):
    return ''.join(char for char in string if 'a' <= char <= 'z' or 'A' <= char <= 'Z' or char == ' ')

if __name__ == '__main__':
    x = [1, 2, 3, 5, 4, 5]
    # print(is_multiple(2, 2))
    # print(is_even(11))
    #print(minmax([1, 2, 3, 1, 1, -100, 23, 1]))
    # print(minmax([]))
    # print(squares_sum(10))
    #print(sum(i ** 2 for i in range(1, 10)))
    # print(squares_sum_odd(10))
    #print(sum(i ** 2 for i in range(1, 10, 2)))
    # print(choice(range(10)))
    # print(list(get_distinct_pair(x)))
    # print(are_all_distinct(x))
    #print([i * (i + 1) for i in range(10)])
    #print([chr(i) for i in range(ord('a'), ord('z') + 1)])
    # print(list(shuffle(x)))
    # shuffle_inplace(x); print(x)
    #input_reverse()
    #print(get_vowels_count('Some string with'))
    print(remove_punctuation('Lets try, Mike.'))
