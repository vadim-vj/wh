def livestock_fence(perimeter):
    a = -2/3
    b = perimeter/3

    w = -b/(2 * a)
    l = (perimeter - 2 * w) / 3

    return l, w

def livestock_fence_simplified(perimeter):
    w = perimeter / 4
    l = perimeter / 6

    return l, w

print(livestock_fence(100), livestock_fence_simplified(100))
