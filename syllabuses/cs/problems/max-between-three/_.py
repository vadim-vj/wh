def max_between_three_simple(a, b, c):
    if a > b:
        if a > c:
            max = a
        else:
            max = c
    else:
        if b > c:
            max = b
        else:
            max = c

    return max

# ---


def max_between_three_via_assign(a, b, c):
    max = a

    if b > max:
        max = b

    if c > max:
        max = c

    return max

# ---


if __name__ == '__main__':
    for func in [max_between_three_simple, max_between_three_via_assign]:
        assert func(1, -10, 33) == 33
