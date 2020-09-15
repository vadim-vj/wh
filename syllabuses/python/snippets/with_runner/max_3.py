lst = (3, 5, 7)

# 3
result = lst[0] if lst else None

# i in (5, 7)
for val in lst[1:]:
    # 5 > 3
    # 7 > 5
    if val > result:
        result = val

# 7
print(result)
