#!/bin/bash
set -e

invoke-rc.d resm stop
update-rc.d resm remove
systemctl --system daemon-reload
