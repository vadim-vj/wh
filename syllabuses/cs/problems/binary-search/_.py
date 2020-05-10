def binary_search(items, key):
    global cnt

    if not items:
        return None

    i = len(items) // 2

    if key == items[i]:
        print(cnt)
        return items[i]

    cnt += 1
    return binary_search(items[i + 1:] if key > items[i] else items[:i], key)

if __name__ == '__main__':
    data = (
        (4, list(range(100))),
        (56, list(range(10, 1000))),
        (134212, list(range(10**7)))
    )

    for key, lst in data:
        cnt = 0
        assert binary_search(lst, key) == key
