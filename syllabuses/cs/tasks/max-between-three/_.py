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


assert max_between_three_simple(1, -10, 33) == 32
assert max_between_three_via_assign(1, -10, 33) == 33
