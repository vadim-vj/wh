import copy

def power_set_recursive(items):
    # not yet working
    return
    ps = copy.deepcopy(items)

    for item in items:
        ps.remove(item)
        ps.append(power_set_recursive(ps))
        ps.append(item)

    return ps


if __name__ == "__main__":
    data = (
        ['a', 'b'],
        #{'a', 'b', 'c',},
    )

    for items in data:
        print('---', power_set_recursive(items))
