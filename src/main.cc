// Copyright 2018 Vadim Sannikov <vsj.vadim@gmail.com>

#include "src/classes/Environment.h"
#include "src/classes/Snippet/Snippet21.h"

int main(int, char *[]) {
  madst::Snippet21 snip;
  madst::Environment env;

  env.addAgent(snip);
  env.run();
}
