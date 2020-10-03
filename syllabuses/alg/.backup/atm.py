n = 120
a = [10, 60, 100]
INF = 1000000000
F = [0]*(n+1)

for m in range(1, n+1):
    F[m] = INF

    for j in a:
        if m >= j and F[m-j]+1 < F[m]:
            F[m] = F[m-j]+1

print(F, len(F))

if F[n] == INF:
    raise Exception

while n > 0:
    for j in a:
        if F[n-j] == F[n] - 1:
            print(j)
            n -= j
            break
