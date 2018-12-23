// Copyright 2018 Vadim Sannikov <vsj.vadim@gmail.com>

#ifndef SRC_CLASSES_SNIPPET_SNIPPET21_H_
#define SRC_CLASSES_SNIPPET_SNIPPET21_H_

#include <ostream>

#include "src/classes/Snippet.h"

namespace madst {

class Snippet21 : public Snippet {
 public:
  void start() override;
  std::ostream &out(std::ostream &os) const override;
};

}  // namespace madst

#endif  // SRC_CLASSES_SNIPPET_SNIPPET21_H_
