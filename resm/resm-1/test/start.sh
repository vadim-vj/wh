#!/bin/bash
pid="$(pidof -x resm)"

if [[ -z "$pid" ]]; then
    ../src/resm --local="$(realpath $top_srcdir)" --config="$(realpath ./resm.conf)" &
    echo $! > .pid
    sleep 1

elif [[ ! -e .pid || "$pid" != $(cat .pid) ]]; then
    echo "Service 'resm' already running; unable to test"
    rm -f .pid
    exit 77 > /dev/null 2>&1
fi
