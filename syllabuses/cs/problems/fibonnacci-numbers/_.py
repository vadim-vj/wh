def fib(n):
    return fib(n - 1) + fib(n - 2) if (n > 2) else 1

# ---

if __name__ == "__main__":
    for n in [2, 4, 6, 7]:
        print(fib(n))
