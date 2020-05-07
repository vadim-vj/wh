def merge_ordered_lists(list1, list2):
    result = []

    while list1 or list2:
        if list1 and list2:
            # `<` is important
            lst = list1 if list1[0] < list2[0] else list2

        elif list1:
            lst = list1

        elif list2:
            lst = list2

        result.append(lst.pop(0))

    return result


def merge_sort(arr):
    length = len(arr)

    if length == 1:
        return arr

    middle = length // 2

    return merge_ordered_lists(
        merge_sort(arr[:middle]),
        merge_sort(arr[middle:])
    )


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
        print(merge_sort(arr))
