def golden_ratio():
    guess, epsilon = 2, 1e-5

    while abs(guess**2 - guess - 1) > epsilon:
        guess = 1/guess + 1

    return guess

if __name__ == '__main__':
    print(golden_ratio())
