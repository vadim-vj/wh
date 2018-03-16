#Init
AC_INIT([RESM],[1],[vsj.vadim@gmail.com])
AM_SILENT_RULES([yes])

# For autoreconf --install
AM_INIT_AUTOMAKE([-Wall -Werror foreign])

# Defaul values
RESM_PORT=10000
RESM_RCNT=10
RESM_RPREF="r"
RESM_TMOD="On"

# Ability to choose source, port, resources' count and prefix
AC_ARG_VAR(
    [RESM_SRC],
    [Ability to choose source: "python" (default) or "php". 
        Value without parentheses ("./configure RESM_SRC=py" or "./configure RESM_SRC=php")]
)
AC_ARG_VAR(
    [RESM_ADDR],
    [Ability to choose IP-address for socket to listen on 
        ("0.0.0.0" by default (so called "any IPv4 address at all" or INADDR_ANY)) 
        - the same way ro pass: ./configure RESM_ADDR=(n.n.n.n|localhost|<some_any>).
        It is better to not change this option]
)
AC_ARG_VAR(
    [RESM_PORT],
    [Ability to choose port number (10000 by default) - the same way ro pass: ./configure RESM_PORT=<num>]
)
AC_ARG_VAR(
    [RESM_RCNT], 
    [Ability to choose resource count (10 by default) - the same way ro pass: ./configure RESM_RCNT=<num>]
)
AC_ARG_VAR(
    [RESM_RPREF],
    [Ability to choose resources name prefix ("r" by default) - the same way ro pass: ./configure RESM_RPREF=<string>]
)
AC_ARG_VAR(
    [RESM_TMOD],
    [Test mode; ability to display some additional info ("On" by default) - the same way ro pass: ./configure RESM_TMOD=<string>]
)

# For manpage
AM_MISSING_PROG(HELP2MAN, help2man, $missing_dir)

# Default source
AS_IF([[[[ "$RESM_SRC" != "py" && "$RESM_SRC" != "php" ]]]], [RESM_SRC="py"])

# Set source
AS_CASE([$RESM_SRC], ["php"], [prog="php"; RESM_ADDR="0.0.0.0"], [prog="python"; RESM_ADDR=""])
AC_PATH_PROG([INTERPRETER_PATH], [$prog])
AS_IF([test -z "$INTERPRETER_PATH"], AC_MSG_FAILURE([Program "$prog" ($INTERPRETER_PATH) is not installed]))

# Check for interpreter support
AC_SYS_INTERPRETER
AS_IF([test "$interpval" == "no"], AC_MSG_FAILURE(AS_HELP_STRING([Scripts using #! may not be invoked properly])))

# Substitute vars
AC_SUBST([RESM_SRC],        [$RESM_SRC])
AC_SUBST([RESM_INADDR_ANY], [$RESM_ADDR])
AC_SUBST([RESM_PORT],       [$RESM_PORT])
AC_SUBST([RESM_CNT],        [$RESM_RCNT])
AC_SUBST([RESM_PREF],       [$RESM_RPREF])
AC_SUBST([RESM_TEST_MODE],  [$RESM_TMOD])

AC_SUBST([RESM_DESCRIPTION], ["simple resource manager"])

AM_CONDITIONAL([IS_PHP], [test "$RESM_SRC" == "php"])

# Substitute files
AC_CONFIG_FILES([
    Makefile
    conf/Makefile
    conf/debian/Makefile
    conf/resm.conf
    src/Makefile
    src/data/Makefile
    src/data/VERSION
    src/data/HELP
    src/py/Makefile
    src/php/Makefile
    src/$RESM_SRC/resm.sh
    man/Makefile
    test/Makefile
    test/resm.conf
])
AC_CONFIG_FILES([test/compiler.sh], [chmod +x test/compiler.sh])
AC_CONFIG_FILES([test/start.sh], [chmod +x test/start.sh])
AC_CONFIG_FILES([test/stop.sh], [chmod +x test/stop.sh])

# Write
AC_OUTPUT
