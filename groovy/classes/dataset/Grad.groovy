package classes.dataset

abstract class Grad extends classes.Dataset {
  def getTsvPath() {
    return super.tsvPath + '/Grad'
  }
}
