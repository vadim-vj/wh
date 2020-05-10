class Node:
    def __init__(self, key):
        self.nodes = []
        self.key = key

    def add(self, node):
        self.nodes.append(node)

    def __str__(self):
        return self.key + ': ' + ', '.join(map(lambda e: e.key, self.nodes))

def DFS(start_node, key):
    next_nodes = [ start_node ]
    seen_nodes = { start_node }

    while next_nodes:
        node = next_nodes.pop()

        if node.key == key:
            return node

        for n in node.nodes:
            if n not in seen_nodes:
                next_nodes.append(n)
                seen_nodes.add(n)

    return None

from collections import deque

def BFS(start_node, key):
    next_nodes = deque({ start_node })
    seen_nodes = { start_node }

    while next_nodes:
        node = next_nodes.popleft()

        if node.key == key:
            return node

        for n in node.nodes:
            if n not in seen_nodes:
                next_nodes.append(n)
                seen_nodes.add(n)

    return None

def common(start_node, key):
    seen_nodes = set()
    # стек или очередь
    next_nodes = collection()

    while next_nodes:
        # берем узел из вершины стека или из начала очереди
        node = next_nodes.get_next()

        # элемент найден
        if node.key == key:
            return node

        # добавление дочерних узлов в коллекцию
        for n in node.nodes:
            # отсечка уже просмотренных
            if n not in seen_nodes:
                next_nodes.add(n)
                seen_nodes.add(n)

    # элемент не найден
    return None

# ---

if __name__ == '__main__':
    graph = Node('A')
    b = Node('B')
    c = Node('C')
    d = Node('D')
    e = Node('E')
    f = Node('F')

    b.add(c)
    b.add(d)
    c.add(d)
    d.add(c)
    e.add(f)
    f.add(c)
    graph.add(b)
    graph.add(c)

    for key in 'ABCDEF':
        print(DFS(graph, key))
        print(BFS(graph, key))
        print('---')
