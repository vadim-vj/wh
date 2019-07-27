def scriptName = this.getClass().getName()

def cli = new CliBuilder(usage: """groovy $scriptName [options]
  OR java -classpath \"build:<groovy-libdir>\" $scriptName [options]""")
cli.t(longOpt: 'type', args: 1, 'dataset type')
cli.h(longOpt: 'help', 'display usage')

def options = cli.parse(args)

if (options) {
  if (options.h) {
    cli.usage()

  } else if (options.t) {
    try {
      def className = "classes.dataset.$options.t"
      Class.forName(className); // throw ClassNotFoundException if not exists

      def classLoaded = this.getClass().classLoader.loadClass(className);

      if (
        !classLoaded
        || !(classLoaded in classes.Dataset)
        || java.lang.reflect.Modifier.isAbstract(classLoaded.getModifiers())
      ) {
        throw new ClassNotFoundException();
      }

      classLoaded.newInstance().process()

    } catch (ClassNotFoundException e) {
      println "Unknown dataset type: $options.t"
    }

  } else {
    println 'Unknown options'
    System.exit(-1)
  }
}
