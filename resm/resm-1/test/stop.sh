#!/bin/bash

if [[ -e .pid ]]; then
    cat .pid | xargs kill -9
    rm -f .pid

else
    echo "Service 'resm' already running; unable to test"
    exit 77 > /dev/null 2>&1
fi
