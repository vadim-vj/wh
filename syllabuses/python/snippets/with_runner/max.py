import _data
lst = _data.lst

max_val = lst[0] if lst else None

for val in lst[1:]:
    if val > max_val:
        max_val = val
