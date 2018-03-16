man_MANS = resm.1
CLEANFILES = $(man_MANS)

resm.1:
	$(HELP2MAN) --name='@RESM_DESCRIPTION@' -N -o $@ '../src/resm --local=".."'
