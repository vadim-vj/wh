#!/bin/bash
set -e

update-rc.d resm defaults
invoke-rc.d resm start
