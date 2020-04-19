def cracking_the_code(pin):
    count = 0

    for i in range(100):
        for c in range(ord('a'), ord('z') + 1):
            count += 1

            if pin == chr(c) + f'{i:02d}':
                return count

    return count

# ---


def cracking_the_code_letter_first(pin):
    count = 0

    for c in range(ord('a'), ord('z') + 1):
        for i in range(100):
            count += 1

            if pin == chr(c) + f'{i:02d}':
                return count

    return count

# ---


if __name__ == '__main__':
    data = {
        'a00': 1,
        'z99': 2600,
    }

    for func in [cracking_the_code, cracking_the_code_letter_first]:
        for key, value in data.items():
            assert func(key) == value

    assert cracking_the_code('z09') == 260
    assert cracking_the_code_letter_first('z09') == 2510
