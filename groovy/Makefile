.PHONY: clean compile run-java run-groovy run all

BUILD_DIR		:= build
MAIN_SCRIPT	:= aggregate
SCRIPT_OPTS	:= --type=Grad.Two
EXTENSION   := groovy

all: clean compile run-java run-groovy

run: run-groovy

run-java:
		java -classpath '$(BUILD_DIR):/snap/groovy/15/lib/*' $(MAIN_SCRIPT) $(SCRIPT_OPTS)

run-groovy:
		groovy $(MAIN_SCRIPT) $(SCRIPT_OPTS)

compile: clean
		groovyc -d=$(BUILD_DIR) $(MAIN_SCRIPT).$(EXTENSION) `find ./classes/ -name "*.$(EXTENSION)"`

clean:
		rm -rf $(BUILD_DIR)/*
