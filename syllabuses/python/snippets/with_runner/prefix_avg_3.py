lst = (3, 5, 7)

result = [] if lst else None
length = len(lst) # 3

# i < 3
for i in range(length): # i in (0, 1, 2)
    sum_val = 0

    # i + 1 in (1, 2, 3)
    #
    # j < 1 ~ j in (0)
    # j < 2 ~ j in (0, 1)
    # j < 3 ~ j in (0, 1, 2)
    for j in range(i + 1):
        # lst[0] = 3
        # lst[0] + lst[1] = 8
        # lst[0] + lst[1] + lst[2] = 15
        sum_val += lst[j]

    # [3/1, 8/2, 15/3]
    result.append(sum_val/(i + 1))
