def merge_ordered_lists(list1, list2):
    result = []

    while list1 or list2:
        if list1 and list2:
            # `<` is important
            if list1[0] < list2[0]:
                list = list1
            else:
                list = list2

        elif list1:
            list = list1

        elif list2:
            list = list2
            
        result.append(list.pop(0))

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
