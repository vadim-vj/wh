pkgdata_DATA = HELP VERSION
EXTRA_DIST = HELP.in VERSION.in
CLEANFILES = $(pkgdata_DATA)

uninstall-hook:
	if test -d "@datadir@/@PACKAGE@"; then \
		rmdir --ignore-fail-on-non-empty "@datadir@/@PACKAGE@"; \
	fi
