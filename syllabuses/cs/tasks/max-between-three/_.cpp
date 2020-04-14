int max_between_three_simple(int a, int b, int c) {
  int max;

  if (a > b) {
    max = a > c ? a : c;

  } else {
    max = b > c ? b : c;
  }

  return max;
}

// ---

int max_between_three_via_assign(int a, int b, int c) {
  int max = a;

  if (b > max) max = b;
  if (c > max) max = c;

  return max;
}

// ---

#include <cassert>

int main() {
  assert(max_between_three_simple(1, -10, 33) == 33);
  assert(max_between_three_via_assign(1, -10, 33) == 33);
}
