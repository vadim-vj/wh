#include <iomanip>
#include <map>
#include <sstream>
#include <string>

int cracking_the_code(const std::string& pin) {
  int count = 0;

  for (int i = 0; i < 100; ++i) {
    for (char c = 'a'; c <= 'z'; ++c) {
      ++count;

      std::stringstream ss;
      ss << std::setw(2) << std::setfill('0') << i;

      if (c + ss.str() == pin) return count;
    }
  }

  return count;
}

// ---

int cracking_the_code_letter_first(const std::string& pin) {
  int count = 0;

  for (char c = 'a'; c <= 'z'; ++c) {
    for (int i = 0; i < 100; ++i) {
      ++count;

      std::stringstream ss;
      ss << std::setw(2) << std::setfill('0') << i;

      if (c + ss.str() == pin) return count;
    }
  }

  return count;
}

// ---

#include <cassert>
#include <vector>

int main() {
  std::map<std::string, int> data = {
      {"a00", 1},
      {"z99", 2600},
  };

  for (const auto& func : std::vector{cracking_the_code, cracking_the_code_letter_first}) {
    for (const auto& pair : data) {
      assert(func(pair.first) == pair.second);
    }
  }

  assert(cracking_the_code("z09") == 260);
  assert(cracking_the_code_letter_first("z09") == 2510);
}
