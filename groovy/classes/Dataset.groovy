package classes

abstract class Dataset {
  def getTsvPath() {
    return 'dataset'
  }

  void process() {
    println tsvPath
  }
}
