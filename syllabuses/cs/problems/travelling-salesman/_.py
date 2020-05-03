def generate_distance_matrix(n):
    import random

    matrix = [[None for i in range(n)] for j in range(n)]

    for i in range(n):
        for j in range(i):
            matrix[i][j] = matrix[j][i] = random.uniform(1, 100)

    return matrix


def generate_permutations(n):
    """TODO: check <https://en.wikipedia.org/wiki/Permutation#Algorithms_to_generate_permutations>"""

    import itertools

    return tuple(itertools.permutations(range(n)))


def travelling_salesman(n):
    """TODO: check <https://ru.wikipedia.org/wiki/Задача_коммивояжёра>"""

    if n > 9:
        print("You're gonna hang the system")
        return ''

    import math

    distances = generate_distance_matrix(n)
    routes = generate_permutations(n)

    min = math.inf
    route = None

    for r in routes:
        distance = 0

        for i in range(n - 1):
            distance += distances[r[i]][r[i + 1]]

        if distance < min:
            min = distance
            route = r

    return min, route  # , routes, distances


# ---

if __name__ == '__main__':
    #print(generate_distance_matrix(3))
    print(travelling_salesman(9))
