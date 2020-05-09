def insertion_sort(arr):
    for i in range(1, len(arr)):
        j = i

        while j and arr[j - 1] > arr[j]:
            arr[j], arr[j - 1] = arr[j - 1], arr[j]
            j -= 1

    return arr

def insertion_sort_oth(nums):
    for i in range(1, len(nums)):
        curr = nums[i]
        j = i

        while j and nums[j - 1] > curr:
            nums[j] = nums[j - 1]
            j -= 1

        nums[j] = curr

    return nums

def insertion_sort_pyth(nums):
    for i in range(1, len(nums)):
        curr = nums[i]
        j = i

        while j and nums[j - 1] > curr:
            j -= 1

        if i != j:
            del nums[i]
            nums.insert(j, curr)

    return nums

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
        print(insertion_sort(arr))
        print(insertion_sort_oth(arr))
        print(insertion_sort_pyth(arr))
