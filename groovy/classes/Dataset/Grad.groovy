package classes.Dataset

abstract class Grad extends classes.Dataset {
  def getTsvPath() {
    return super.tsvPath + '/Grad'
  }
}
