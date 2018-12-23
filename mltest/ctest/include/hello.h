// Copyright 2018 <Vadim Sannikov>
#ifndef INCLUDE_HELLO_H_
#define INCLUDE_HELLO_H_

namespace ctest {

class Hello {
 public:
  void test() const;
  virtual void test1() {}
  virtual ~Hello() {}
};

}  // namespace ctest

#endif  // INCLUDE_HELLO_H_
