def import_all(file, package, filter=None):
    import inspect
    import importlib
    import os
    import types

    entries = set()

    for name in os.listdir(os.path.dirname(file)):
        if name != '__init__.py' and name.endswith('.py'):
            module = importlib.import_module('.' + name[:-3], package=package)

            for entry in module.__dict__:
                if not entry.startswith('_'):
                    entry = getattr(module, entry)

                    if (
                        not isinstance(entry, types.ModuleType)
                        and not inspect.isabstract(entry)
                        and (not filter or filter(entry))
                    ):
                        entries.add(entry)
                        globals().update({entry: entry})

    return entries
