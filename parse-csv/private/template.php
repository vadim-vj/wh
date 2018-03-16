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
    <input type="hidden" name="<?php echo \Application::ACTION; ?>" value="upload_file" />

    <label for="inputfile">
      Файл с данными ("<?php echo implode('", "', $this->getAllowedFileTypes()); ?>"):
    </label>
    <input type="file" name="inputfile" id="inputfile" />

    <input type="submit" id="submit" />
  </form>

  <br />

  <?php if (0 < ($count = $model->getProductsTotalCount())): ?>
    <?php if ($categories = $model->getCategories()): ?>
      <label for="category">Категории: </label>
      <select id="category">
      <option value="">---Все продукты---</option>
      <?php foreach ($categories as $id => $data): ?>
        <option value="<?php echo $id; ?>"><?php echo $data['name'] . ' (' . $data['count'] . ')'; ?></option>
      <?php endforeach; ?>
      </select>
      <br />
    <?php endif; ?>

    <i id="hint">кликните по заголовку столбца для сортировки</i>
    <table id="products">
      <tbody>
      <tr class="header">
        <th class="p.id">#</th>
        <th class="p.name asc">Имя</th>
        <th class="p.model">Модель</th>
        <th class="b.name">Бренд</th>
        <th class="p.article">Артикль</th>
        <th class="p.size">Размеры</th>
        <th class="p.color">Цвета</th>
        <th class="p.orient">Право/лево</th>
      </tr>
      <?php for ($i = 0; $i < static::PRODUCTS_PER_PAGE; $i++): ?>
      <tr>
        <td class="id"></td>
        <td class="name"></td>
        <td class="model"></td>
        <td class="brand"></td>
        <td class="article"></td>
        <td class="size"></td>
        <td class="color"></td>
        <td class="orient"></td>
      </tr>
      <?php endfor; ?>
      </tbody>
    </table>

    <ul id="paginator"></ul>

    <br /><div style="clear: both;"></div>
    <hr />
    <b>Всего продуктов: </b><?php echo $count; ?>
    <button id="delete_all">Удалить все продукты</button>
  <?php endif; ?>
</body>

</html>
