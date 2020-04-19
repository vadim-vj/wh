def power_set(flowers):
    fragrances = {frozenset()}

    for flower in flowers:
        new_fragrances = list(map(lambda e: set(e), fragrances.copy()))

        for fragrance in new_fragrances:
            fragrance.add(flower)

        fragrances.update(map(lambda e: frozenset(e), new_fragrances))

    return fragrances


def power_set_lists(flowers):
    import copy
    fragrances = [[]]

    for flower in flowers:
        new_fragrances = copy.deepcopy(fragrances)

        for fragrance in new_fragrances:
            fragrance.append(flower)

        fragrances += new_fragrances

    return fragrances

# ---


if __name__ == "__main__":
    data = (
        # ('a',)
        ('a', 'b', 'c',),
        # ('fl1', 'fl3', 'fl2', 'fl4')
    )

    for flowers in data:
        for func in [power_set, power_set_lists]:
            print(func(flowers))
