def knapsack_divide_and_conquer(items, max_weight):
    pass

# ---

if __name__ == "__main__":
    data = (
        # 0 - weight, 1 - price
        ((1, 3), (3, 6)),
    )

    for items in data:
        print(knapsack_divide_and_conquer(items, 3))
        print(knapsack_divide_and_conquer(items, 4))
