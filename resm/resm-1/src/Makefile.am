if IS_PHP
SUBDIRS = php
else
SUBDIRS = py
endif
SUBDIRS += data
bin_SCRIPTS = resm
CLEANFILES = $(bin_SCRIPTS)

resm: @RESM_SRC@/resm.sh
	(cat "$<" \
		| sed -e 's,@RESM_DATA@,$(pkgdatadir),g' \
		| sed -e 's,@RESM_LIB@,$(pkgdatadir),g' \
		| sed -e 's,@RESM_SYSCONF@,$(sysconfdir),g' \
	) > $@
	chmod +x $@
