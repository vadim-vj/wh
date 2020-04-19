def livestock_fence(perimeter):
    a = -2/3
    b = perimeter/3

    w = -b/(2 * a)
    l = (perimeter - 2 * w) / 3

    return l, w

# ---


def livestock_fence_simplified(perimeter):
    w = perimeter / 4
    l = perimeter / 6

    return l, w

# ---


if __name__ == '__main__':
    from math import isclose

    for func in [livestock_fence, livestock_fence_simplified]:
        l, w = func(100)
        assert isclose(l, 16 + 2/3)
        assert isclose(w, 25)
