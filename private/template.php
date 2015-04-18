<?php
/**
 * Main page template
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <link rel="stylesheet" href="public/main.css" type="text/css" />

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="public/main.js"></script>

  <title>Тестовое задание</title>
</head>

<body>
  <form action="index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo \Application::ACTION ?>" value="upload_file" />

    <label for="inputfile">
      Файл с данными ("<?php echo implode('", "', $this->getAllowedFileTypes()) ?>"):
    </label>
    <input type="file" name="inputfile" id="inputfile" />

    <input type="submit" id="submit" />
  </form>
</body>

</html>
