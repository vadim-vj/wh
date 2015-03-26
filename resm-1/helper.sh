#!/bin/bash

vars=("RESM_SRC" "RESM_ADDR" "RESM_PORT" "RESM_RCNT" "RESM_RPREF" "RESM_TMOD")

if [[ "unset_all" == "$1" ]]; then
    echo ">>>>>>Unset all vars"
    unset ${vars[@]}
fi

for i in ${vars[@]}; do
    echo "$i='${!i}'"
done;
