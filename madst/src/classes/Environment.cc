// Copyright 2018 Vadim Sannikov <vsj.vadim@gmail.com>

#include <iostream>

#include "src/classes/Agent.h"
#include "src/classes/Environment.h"

namespace madst {
namespace {

std::ostream &operator<<(std::ostream &os, const Agent &agent) {
  return agent.out(os);
}

}  // namespace

void Environment::addAgent(Agent &agent) {
  agents.push_back(agent);
  agent.start();
}

void Environment::run() {
  for (auto &agent : agents) {
    std::cout << agent << std::endl;
  }
}

}  // namespace madst
