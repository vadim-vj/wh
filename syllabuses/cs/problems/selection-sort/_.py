def selection_sort(to_sort):
    arr = to_sort[:]

    for i in range(len(arr) - 1):
        i_min = i

        for j in range(i + 1, len(arr)):
            if arr[j] < arr[i_min]:
            i_min = j

            if (i != i_min):
                arr[i], arr[i_min] = arr[i_min], arr[i]

    return arr

# ---


if __name__ == "__main__":
    data = (
        [3, 7, 2],
        [3, 4, 5, 7, 2, 3, 41, 2],
        [0, 0, 0, 0],
        [1, 2, 3, 4, 5],
        [9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
    )

    for arr in data:
        print(selection_sort(arr))
