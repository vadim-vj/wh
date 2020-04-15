def hot_server(A, B, C):
    """A server crashes if it’s overheating while the air conditioning is off.
    It also crashes if it’s overheating and its chassis cooler fails.
    In which conditions does the server work?
    """

    # A - Server overheats
    # B - Air conditioning off
    # C - Chassis cooler fails
    # !D- Server works

    # Server crashes
    D = False

    # (A && B) || (A && C)
    if A and B or A and C:
        D = True

    return not D

# ---


def hot_server_simplified(A, B, C):
    # (A && B) || (A && C) -> D
    # !D -> !(A && (B || C))
    # !D -> !A || !B && !C

    return not A or not B and not C


# ---

if __name__ == '__main__':
    for func in [hot_server, hot_server_simplified]:
        assert func(A=False, B=True, C=True)
        assert func(A=False, B=True, C=False)
        assert func(A=False, B=False, C=True)
        assert func(A=False, B=False, C=False)
        assert not func(A=True, B=True, C=True)
        assert not func(A=True, B=True, C=False)
        assert not func(A=True, B=False, C=True)
        assert func(A=True, B=False, C=False)
