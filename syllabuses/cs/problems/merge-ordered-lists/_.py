def merge_ordered_lists(list1, list2):
    result = []

    while list1 or list2:
        if list1 and list2:
            # `<` is important
            if list1[0] < list2[0]:
                lst = list1
            else:
                lst = list2

        elif list1:
            lst = list1

        elif list2:
            lst = list2

        result.append(lst.pop(0))

    return result

if __name__ == "__main__":
    data = (
        (
            ['a', 'b', 'e'],
            ['a', 'c'],
        ),
    )

    for lists in data:
        print(merge_ordered_lists(*lists))
