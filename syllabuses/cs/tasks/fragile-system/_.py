def fragile_system(A, B, C, D):
    """We have to create a database system with the following requirements:
    I : If the database is locked, we can save data.
    II : A database lock on a full write queue cannot happen.
    III : Either the write queue is full, or the cache is loaded.
    IV : If the cache is loaded, the database cannot be locked."""

    # A - Database is locked
    # B - Able to save data
    # C - Write queue is full
    # D - Cache is loaded

    return (
        A <= B,  # Yes, it's an implication in Python
        not (A and C),
        C or D,
        D <= (not A),
    ) # System works when they're all true

# ---


if __name__ == '__main__':
    var_number = 4

    for i in range(2 ** var_number):
        vars = tuple(map(bool, map(int, f'{i:0{var_number}b}')))
        is_true = all(fragile_system(*vars))

        print('>>>' if is_true else '', tuple(map(int, vars)) + (is_true,))
        #print(tuple(map(int, vars)) + (is_true,))
