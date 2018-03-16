#!/bin/bash

# Name and version
name='resm'
version=1

# Global variables
resm_dir='./'$name'-'$version
conf_dir=$resm_dir'/conf'

# Main actions 
sudo pkill resm
cd $resm_dir
make -s distclean
find ./ -name "Makefile" -exec rm {} \;
find ./ -name "Makefile.in" -exec rm {} \;
find ./ -name "*.log" -exec rm {} \;
find ./ -name "*.trs" -exec rm {} \;
rm -f configure config.log config.status install-sh missing test-driver aclocal.m4 man/resm.1 src/resm src/php/resm.php.sh src/py/resm.py.sh src/data/VERSION src/data/HELP test/php/test-suite.log test/py/test-suite.log
autoreconf -f -m -W all --install
./configure  --prefix=/usr --sysconfdir=/etc RESM_SRC=php
make -s
make -s check
sudo make -s install
sudo conf/debian/install.sh
