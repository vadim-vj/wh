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

    for _ in range(2, n):
        pred, curr = curr, pred + curr

    return curr

mem = [None, 1, 1]
def fib_mem(n):
    if len(mem) <= n:
        mem.append(fib_mem(n - 1) + fib_mem(n - 2))
        #mem.append(mem[n - 1] + mem[n - 2])

    return mem[n]

# ---

if __name__ == '__main__':
    from doctest import run_docstring_examples

    for func in [fib, fib_nr, fib_mem]:
        run_docstring_examples(func, globals())

        for n in range(1, 11):
            print(n, ': ', func(n))
