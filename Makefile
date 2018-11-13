CC=g++-8
CFLAGS=-Wall -Weffc++ -ggdb3 -pedantic -std=c++2a -iquote.
LIBS=
SOURCES=src/*.cc

all: $(SOURCES)
	$(CC) $(CFLAGS) $(SOURCES) $(LIBS)

clean:
	rm -f *.о
	rm -f *.so
	rm -f *.а
	rm -f *.out
	rm -f *.s
