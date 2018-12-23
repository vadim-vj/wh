// Copyright 2018 Vadim Sannikov <vsj.vadim@gmail.com>

#ifndef SRC_CLASSES_AGENT_H_
#define SRC_CLASSES_AGENT_H_

#include <ostream>

namespace madst {

class Agent {
 public:
  virtual void start() = 0;
  virtual std::ostream &out(std::ostream &os) const = 0;
  virtual ~Agent() {}
};

}  // namespace madst

#endif  // SRC_CLASSES_AGENT_H_
