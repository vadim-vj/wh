def knapsack_greedy(items, max_weight):
    bag_weight = 0
    bag_items = []

    for item in sorted(items, key=lambda e: e[1], reverse=True):
        if max_weight >= bag_weight + item[0]:
            bag_weight += item[0]
            bag_items.append(item)

    return bag_items

# ---

if __name__ == "__main__":
    data = (
        # 0 - weight, 1 - price
        ((1, 3), (3, 6)),
    )

    for items in data:
        print(knapsack_greedy(items, 0.5))
        print(knapsack_greedy(items, 2))
        print(knapsack_greedy(items, 3))
        print(knapsack_greedy(items, 4))
