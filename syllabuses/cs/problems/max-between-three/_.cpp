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
#include <vector>

int main() {
  for (const auto &func : std::vector{max_between_three_simple, max_between_three_via_assign}) {
    assert(func(1, -10, 33) == 33);
  }
