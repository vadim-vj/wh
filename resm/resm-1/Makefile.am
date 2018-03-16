SUBDIRS = conf src man test
dist_doc_DATA = README INSTALL
EXTRA_DIST = debian helper.sh

uninstall-hook:
	if test -d "@docdir@"; then \
		rmdir --ignore-fail-on-non-empty "@docdir@"; \
	fi
