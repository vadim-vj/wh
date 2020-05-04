def newtons_method(f):
    guess = 10
    delta = epsilon = 10e-5

    while abs(f(guess)) > epsilon:
        approx_derivate = (f(guess + delta) - f(guess)) / delta

        guess -= f(guess) / approx_derivate

    return guess

if __name__ == '__main__':
    print(newtons_method(lambda x: x**2 - 16)) # sqrt(16)
    print(newtons_method(lambda x: 2**x - 32)) # log2(32)
