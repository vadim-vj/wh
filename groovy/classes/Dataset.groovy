package classes

abstract class Dataset {
  def getTsvPath() {
    'dataset'
  }

  void process() {
    println tsvPath
  }
}
