init_ddir = @sysconfdir@/init.d
init_d_SCRIPTS = resm
CLEANFILES = $(init_d_SCRIPTS)
HELPERS = install.sh uninstall.sh
EXTRA_DIST = resm.in $(HELPERS)

resm: resm.in
	sed -e 's,@RESM_BIN_DIR@,$(bindir),g' $< > $@
	for i in $(HELPERS); do \
		if [[ -e $$i && ! -x $$i ]]; then \
			chmod +x $$i; \
		fi \
	done
