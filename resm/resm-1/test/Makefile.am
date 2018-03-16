TESTS = \
	start.sh \
	1_allocate_alice.req \
	2_allocate_bob.req \
	3_allocate_alice.req \
	4_allocate_bob.req \
	5_deallocate_t2.req \
	6_deallocate_t2.req \
	7_deallocate_any.req \
	8_list.req \
	9_list_alice.req \
	10_list_bob.req \
	11_reset.req \
	12_list.req \
	13_bad_request.req \
	stop.sh
TEST_EXTENSIONS = .req
REQ_LOG_COMPILER = ./compiler.sh
LOG_COMPILER = $(SHELL)
EXTRA_DIST = $(TESTS)
CLEANFILES = $(REQ_LOG_COMPILER) resm.conf start.sh stop.sh .pid

AM_TESTS_ENVIRONMENT = top_srcdir=$(top_srcdir); export top_srcdir;
