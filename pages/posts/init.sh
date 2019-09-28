#!/bin/bash

if [ -d "$1" ]; then
  echo "Directory \"$1\" exists"
else
  cp -rT .stub $1
fi
