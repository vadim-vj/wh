def check_if_palindrome(word):
    if len(word) <= 1:
        return True

    if word[0] != word[-1]:
        return False

    return check_if_palindrome(word[1:-1])

# ---

if __name__ == "__main__":
    data = (
        'racecar',
        'some',
    )

    for word in data:
        print(check_if_palindrome(word))
