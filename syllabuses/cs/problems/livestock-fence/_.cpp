#include <utility>

auto livestock_fence(double perimeter) {
  auto a = -2.0 / 3;
  auto b = perimeter / 3;

  auto w = -b / (2 * a);
  auto l = (perimeter - 2 * w) / 3;

  return std::make_pair(l, w);
}

// ---

auto livestock_fence_simplified(double perimeter) {
  auto w = perimeter / 4;
  auto l = perimeter / 6;

  return std::make_pair(l, w);
}

// ---

#include <cassert>
#include <cmath>
#include <vector>

int main() {
  auto constexpr epsilon = 0.001;

  for (const auto &func : std::vector{livestock_fence, livestock_fence_simplified}) {
    auto pair = func(100);

    assert(std::abs(pair.first - (16 + 2.0 / 3)) < epsilon);
    assert(std::abs(pair.second - 25) < epsilon);
  }
}
