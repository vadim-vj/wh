def power_set(flowers):
    fragrances = {frozenset()}

    for flower in flowers:
        new_fragrances = list(map(lambda e: set(e), fragrances.copy()))

        for fragrance in new_fragrances:
            fragrance.add(flower)

        fragrances.update(map(lambda e: frozenset(e), new_fragrances))

    return fragrances


def power_set_lists(elements):
    import copy

    ps = [[]]

    for e in elements:
        new_ps = copy.deepcopy(ps)

        for sets in new_ps:
            sets.append(e)

        ps += new_ps

    return ps

# ---


if __name__ == '__main__':
    data = (
        # ('a',)
        ('a', 'b', 'c',),
        # ('fl1', 'fl3', 'fl2', 'fl4')
    )

    for flowers in data:
        for func in [power_set, power_set_lists]:
            print(func(flowers))
