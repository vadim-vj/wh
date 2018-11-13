CC=g++-8
CFLAGS=-Wall -ggdb3 -pedantic -std=c++2a -Ofast -iquote. -Weffc++
LIBS=#-lm
SOURCES=*.cc lib/*.cc

all: $(SOURCES)
	$(CC) $(CFLAGS) $(SOURCES) $(LIBS)

clean:
	rm -f *.о
	rm -f *.so
	rm -f *.а
	rm -f *.out
	rm -f *.s
