/**
 * JS
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */

$(document).ready(function () {
  $('input#inputfile').change(function () {
    $('input#submit').show();
  });

  var ajaxCall = function (page) {
    var sort = $('table#products th').filter('[class~="asc"],[class~="desc"]').attr('class').split(' ');

    if (undefined === page) {
      page = parseInt($('ul#paginator li.selected').html());
      page = isNaN(page) ? 0 : Math.max(0, page - 1);
    }

    $.get(
      'index.php?action=get_products',
      {
        'category_id': $('select#category').val(),
        'page': page,
        'sort': sort[0],
        'sort_dir': sort[1]
      },
      function (data) {
        $('table#products tbody > tr:gt(0)').hide();
        $('ul#paginator').empty();

        if (0 < data['count']) {
          var pagesCount = Math.ceil(data['count'] / parseInt(data['per_page']));

          if (1 < pagesCount) {
            for (var i = 0; i < pagesCount; ++i) {
              $('ul#paginator').append($('<li>').html(i + 1).attr('class', i == page ? 'selected' : ''));
            }

            $('ul#paginator li').click(function () {
              $('ul#paginator li').removeClass();
              $(this).addClass('selected');

              ajaxCall();
            });
          }

          $.each(data['data'], function (index, object) {
            var row = $('table#products tr:eq(' + (index + 1) + ')');

            $.each(object, function (property, value) {
              row.find('td.' + property).html(value);
            });
            row.show();
          });

          $('table#products').show();
          $('ul#paginator').show();
          $('i#hint').show();

        } else {
          $('table#products').hide();
          $('ul#paginator').hide();
          $('i#hint').hide();
        }
    });
  }

  $('select#category').change(function () {
    ajaxCall(0);
  });

  $('table#products th').click(function () {
    var sortDir = 'asc' === $(this).attr('class').split(' ')[1] ? 'desc' : 'asc';

    $('table#products th').removeClass('asc desc');
    $(this).addClass(sortDir);

    ajaxCall();
  });

  $('button#delete_all').click(function () {
    if (confirm('Вы действительно хотите удалить все продукты?')) {
      window.location.replace('index.php?action=delete_all_products');
    }
  });

  $('select#category').change();
});
