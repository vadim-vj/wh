def power_set(items):
    combinations = {frozenset()}

    for flower in items:
        new_combinations = list(map(lambda e: set(e), combinations.copy()))

        for fragrance in new_combinations:
            fragrance.add(flower)

        combinations.update(map(lambda e: frozenset(e), new_combinations))

    return combinations


def total_weight(items):
    return sum(map(lambda e: e[0], items))


def total_price(items):
    return sum(map(lambda e: e[1], items))


def knapsack(items, max_weight):
    best_value = 0

    for item in power_set(items):
        if total_weight(item) <= max_weight:
            if total_price(item) > best_value:
                best_value = total_price(item)
                best_candidate = item

    return best_candidate

def knapsac_rec(items, max_weight):
    pass

def knapsack_powdered(items, max_weight):
    pass

# ---

if __name__ == "__main__":
    data = (
        # 0 - weight, 1 - price
        ((1, 3), (3, 6)),
    )

    for items in data:
        # print(power_set(items))
        for func in [knapsack, knapsac_rec, knapsack_powdered]:
            print(func(items, 3))
            print(func(items, 4))
