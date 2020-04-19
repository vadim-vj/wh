#pragma clang diagnostic push
#pragma clang diagnostic ignored "-Wlogical-op-parentheses"

/**
 * A server crashes if it’s overheating while the air conditioning is off.
 * It also crashes if it’s overheating and its chassis cooler fails.
 * In which conditions does the server work?
 */
bool hot_server(bool A, bool B, bool C) {
  // A - Server overheats
  // B - Air conditioning off
  // C - Chassis cooler fails
  // !D- Server works

  // Server crashes
  bool D = false;

  // (A && B) ||(A && C)
  if (A && B || A && C) {
    D = true;
  }

  return !D;
}

// ---

bool hot_server_simplified(bool A, bool B, bool C) {
  // (A && B) || (A && C) -> D
  // !D -> !(A && (B || C))
  // !D -> !A || !B && !C

  return !A || !B && !C;
}

#pragma clang diagnostic pop

// ---

#include <cassert>
#include <vector>

int main() {
  for (const auto &func : std::vector{hot_server, hot_server_simplified}) {
    assert(func(false, true, true));
    assert(func(false, true, false));
    assert(func(false, false, true));
    assert(func(false, false, false));
    assert(!func(true, true, true));
    assert(!func(true, true, false));
    assert(!func(true, false, true));
    assert(func(true, false, false));
  }
}
