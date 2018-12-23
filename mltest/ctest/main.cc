// Copyright 2018 <Vadim Sannikov>
#include <functional>
#include <vector>
#include "include/hello1.h"

int main(/*int argc, char *argv[]*/) {
  ctest::Hello1 h;

  h.test();
  h.test1();

  std::vector<std::reference_wrapper<int>> vec;
  int i = 4;
  vec.push_back(i);
}
