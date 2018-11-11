// Copyright 2018 <Vadim Sannikov>
#include "include/hello.h"

#include <iostream>

namespace {

void output();

}  // namespace

namespace ctest {

void Hello::test() const {
    output();
}

}  // namespace ctest

namespace {

void output() {
    std::cout << "fff" << std::endl;
}

}  // namespace
