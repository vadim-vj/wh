// Copyright 2018 Vadim Sannikov <vsj.vadim@gmail.com>

#ifndef SRC_CLASSES_ENVIRONMENT_H_
#define SRC_CLASSES_ENVIRONMENT_H_

#include <functional>
#include <vector>

#include "src/classes/Agent.h"

namespace madst {

class Environment {
 public:
  void addAgent(Agent &);
  void run();

 private:
  std::vector<std::reference_wrapper<Agent>> agents{};
};

}  // namespace madst

#endif  // SRC_CLASSES_ENVIRONMENT_H_
