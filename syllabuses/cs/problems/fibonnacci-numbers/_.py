def fib(n):
    """Recursive version

    >>> fib(7)
    13
    >>> fib(8)
    21
    """
    return fib(n - 1) + fib(n - 2) if (n > 2) else 1

def fib_nr(n):
    """Non-recursive version

    >>> fib_nr(9)
    34
    >>> fib_nr(10)
    55
    """
    pred, curr = 1, 1

    while n > 2:
        pred, curr = curr, pred + curr
        n -= 1

    return curr

# ---

if __name__ == '__main__':
    from doctest import run_docstring_examples

    for func in [fib, fib_nr]:
        run_docstring_examples(func, globals())

        for n in range(1, 10):
            print(n, ': ', func(n))
