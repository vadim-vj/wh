def sqrt(n):
    guess, epsilon = 1, 1e-5

    while abs(guess**2 - n) > epsilon:
        guess = (n/guess + guess)/2

    return guess

if __name__ == '__main__':
    for i in [9, 16, 25]:
        print((sqrt(i)))
