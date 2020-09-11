import _data
lst = _data.lst

result = [] if lst else None
length = len(lst)

for i in range(length):
    sum_val = 0

    for j in range(i + 1):
        sum_val += lst[j]

    result.append(sum_val/(i + 1))
