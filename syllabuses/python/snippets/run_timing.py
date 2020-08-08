import decimal

def run_timing():
    total_time = 0.0
    counter = 0

    while val := input('Enter 10 km time: '):
        try:
            val = float(val)
        except ValueError:
            print('Wrong input: ', val)
        else:
            total_time += val
            counter += 1

    return (total_time, counter)

def convert_float(num, before, after):
    # return float(f'{(num % 10 ** before):.{after}f}')
    int_part, float_part = str(num).split('.')

    return float(int_part[-before:] + '.' + float_part[:after])

def sum_decimal():
    values = []

    while len(values) < 2:
        val = input('Enter a float: ')

        try:
            values.append(decimal.Decimal(val))
        except decimal.InvalidOperation:
            print('Wrong input: ', val)

    return sum(values)

if __name__ == '__main__':
    # avg, runs = run_timing()
    # print(f'Average of {avg:.2f}, over {runs} runs')

    print(convert_float(12_34.5678, 2, 3))
    print(sum_decimal())
