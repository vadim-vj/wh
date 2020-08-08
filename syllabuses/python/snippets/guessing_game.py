import random

def guessing_game():
    number = random.randint(1, 100)
    guess = None
    counter = 0

    while guess != number and counter < 3:
        counter += 1
        guess = input(f'Enter a number ({number}, attempt {counter}): ')

        try:
            guess = int(guess)

        except ValueError:
            print('Wrong input: ', guess)

        else:
            if guess < number:
                print('Lesser')

            elif guess > number:
                print('Greater')

            else:
                print('Gotcha!')
    
    if counter >= 3:
        print('No more attempts, exit')

if __name__ == '__main__':
    guessing_game()
