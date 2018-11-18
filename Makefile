CC=g++-8
CF=-iquote. -Wall -Wextra -pedantic -fdiagnostics-color=always
CPPF=-Wvector-operation-performance -Weffc++ -pedantic -std=c++2a
DEBUGF=-ggdb3
OPTF=#-Ofast
LIBS=
SOURCES=$(shell find src -type f -name *.cc)

all: $(SOURCES)
	$(strip $(CC) $(CF) $(CPPF) $(DEBUGF) $(OPTF) $(SOURCES) $(LIBS))

clean:
	rm -f *.о
	rm -f *.so
	rm -f *.а
	rm -f *.out
	rm -f *.s
