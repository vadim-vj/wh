import ctypes


class DynamicArray:
    def __init__(self):
        self._length = 0
        self._capacity = 1
        self._array = self._make_array(self._capacity)

    def __len__(self):
        return self._length

    def __getitem__(self, index):
        if not 0 <= index < self._length:
            raise IndexError

        return self._array[index]

    def __setitem__(self, index, value):
        self._array[index] = value

    def __delitem__(self, index):
        for i in range(index, self._length - 1):
            self[i] = self[i + 1]

        self._length -= 1

    def insert(self, index, value):
        self._resize()

        for i in range(self._length, index, -1):
            self[i] = self[i - 1]

        self._length += 1
        self[index] = value

    def append(self, value):
        self.insert(self._length, value)

    def _resize(self):
        if self._length < self._capacity:
            return

        self._capacity *= 2
        tmp = self._make_array(self._capacity)

        for index in range(self._length):
            tmp[index] = self[index]

        self._array = tmp

    def _make_array(self, capacity):
        return (capacity * ctypes.py_object)()

    def __str__(self):
        return f'[{", ".join(str(self[i]) for i in range(self._length))}]'


a = DynamicArray()

a.append(1)
a.append(2)
a[1] = 3
del a[1]
a.insert(0, 2)
a.insert(2, 7)
print(a)

