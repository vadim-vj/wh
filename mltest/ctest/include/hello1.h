#include <iostream>
#include "hello.h"

namespace ctest {

class Hello1 : public Hello {
 public:
  void test1() override { std::cout << "3333"; }
};

}  // namespace ctest
