CC=g++-8
CFLAGS=-Wall -ggdb3 -pedantic -std=c++2a -Ofast
LIBS=#-lm
SOURCES=*.cpp

all: $(SOURCES)
	$(CC) $(CFLAGS) $(SOURCES) $(LIBS)

clean:
	rm -f *.о
	rm -f *.so
	rm -f *.а
	rm -f *.out
	rm -f *.s