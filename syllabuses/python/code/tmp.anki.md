---
> Что выведет этот код?
> 
> ```python
> class A:
>     pass
> 
> print(type(A), type(A()))
> ```

```python
<class 'type'> <class '__main__.A'>
```

---
> Напишите базовую реализацию синглтона

```python
class Singleton:
    _instances = {}

    def __new__(cls, *args, **kwds):
        if cls not in cls._instances:
            cls._instances[cls] = super().__new__(cls)

        return cls._instances[cls]
```

---
> Что выведет этот код при запуске с одной и с двумя `-O`?
> 
> ```python
> def test():
>     """Doctsring."""
> 
> print(test.__doc__)
> ```

С одной `-O` выведет `Doctsring.`, а с двумя строки документации будут удалены, и выведет `None`

---
####----####
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```

---
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```

---
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```

---
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```

---
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```

---
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```

---
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```

---
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```

---
> Что выведет этот код?
> 
> ```python
> 
> 
> 
> ```

```python
```
