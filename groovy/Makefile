.PHONY: clean compile run-java run-groovy run all

build_dir		:= build
main_script	:= aggregate
script_opts	:= --type=grad.Two
extension   := groovy

all: clean compile run-java run-groovy

run: run-groovy

run-java:
		java -classpath "$(build_dir):/snap/groovy/current/lib/*" $(main_script) $(script_opts)

run-groovy:
		groovy $(main_script) $(script_opts)

compile: clean
		groovyc -d=$(build_dir) $(main_script).$(extension) `find ./classes/ -name "*.$(extension)"`

clean:
		rm -rf $(build_dir)/*
