def quick_sort(nums):
    length = len(nums)

    if length <= 1:
        return nums

    parts = [], [], []
    pivot = nums[length // 2]

    for n in nums:
        if n < pivot:
            i = 0
        elif n > pivot:
            i = 2
        else:
            i = 1

        parts[i].append(n)

    return quick_sort(parts[0]) + parts[1] + quick_sort(parts[2])

def quick_sort1(nums):
    length = len(nums)

    if length < 3:
        if length == 2:
            if nums[0] > nums[1]:
                nums[0], nums[1] = nums[1], nums[0]

        return nums

    parts = [], [], []
    pivot = nums[length // 2]

    for n in nums:
        if n < pivot:
            i = 0
        elif n > pivot:
            i = 2
        else:
            i = 1

        parts[i].append(n)

    return quick_sort(parts[0]) + parts[1] + quick_sort(parts[2])

def quick_sort_in_place(nums, fst, lst):
    if fst >= lst:
        return

    i, j = fst, lst
    pivot = nums[(lst - fst) // 2 + fst]

    while i <= j:
        while nums[i] < pivot: i += 1
        while nums[j] > pivot: j -= 1

        if i <= j:
            nums[i], nums[j] = nums[j], nums[i]
            i, j = i + 1, j - 1

    quick_sort_in_place(nums, fst, j)
    quick_sort_in_place(nums, i, lst)

# ---


if __name__ == "__main__":
    data = (
        [5, 2, 3, 1],
        [3, 7, 2],
        [3, 4, 5, 7, 2, 3, 41, 2],
        [0, 0, 0, 0],
        [1, 2, 3, 4, 5],
        [9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
    )

    for arr in data:
        print(quick_sort(arr))
        print(quick_sort1(arr))

        quick_sort_in_place(arr, 0, len(arr) - 1)
        print(arr)
