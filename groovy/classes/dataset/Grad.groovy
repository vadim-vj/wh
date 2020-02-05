package classes.dataset

abstract class Grad extends classes.Dataset {
  def getTsvPath() {
    super.tsvPath + '/Grad'
  }
}
