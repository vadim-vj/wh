import importlib
import _data


def get_module(name):
    return importlib.reload(importlib.import_module(name))


if __name__ == '__main__':
    for lst in _data.SEQS:
        _data.lst = lst

        # print(lst, get_module('max').maxval, sep=' => ')
        print(lst, get_module('prefix_avg').result, sep=' => ')
