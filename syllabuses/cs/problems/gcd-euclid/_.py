def gcd(a, b):
    while b > 0:
        a, b = b, a % b

    return a

def gcd_rec(a, b):
    if b == 0:
        return a

    else:
        return gcd_rec(b, a % b)

def dcd_full(a, b):
    if a < b:
        a, b = b, a

    while True:
        c = a % b

        if c > 0:
            a = b
            b = c

        else:
            break

    return b

# ---

if __name__ == '__main__':
    for data in ((12, 16), (100, 30)):
        print(gcd(*data))
        print(gcd_rec(*data))
        print(dcd_full(*data))
