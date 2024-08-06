$(document).ready(function () {
  // Обработчик события keyup, сработает после того как пользователь отпустит кнопку, после ввода чего-либо в поле поиска.
  // Поле поиска из файла 'index.php' имеет id='search'
  $("#search").keyup(function () {
    // Присваиваем значение из поля поиска, переменной 'name'.
    var name = $("#search").val();

    // Проверяем если значение переменной 'name' является пустым
    if (name === "") {
      // Если переменная 'name' имеет пустое значение, то очищаем блок div с id = 'display'
      $("#display").html("");
    } else {
      // Иначе, если переменная 'name' не пустая, то вызываем ajax функцию.

      $.ajax({
        type: "POST", // Указываем что будем обращатся к серверу через метод 'POST'
        url: "lifesearch.php", // Указываем путь к обработчику. То есть указывем куда будем отправлять данные на сервере.
        data: {
          // В этом объекте, добавляем данные, которые хотим отправить на сервер
          search: name, // Присваиваем значение переменной 'name', свойству 'search'.
        },
        success: function (response) {
          // Если ajax запрос выполнен успешно, то, добавляем результат внутри div, у которого id = 'display'.
          $("#display").html(response).show();
        },
      });
    }
  });
});

function fill(Value) {
  // Функция 'fill', является обработчиком события 'click'.
  // Она вызывается, когда пользователь кликает по элементу из результата поиска.

  $("#search").val(Value); // Берем значение элемента из результата поиска и добавляем его в значение поля поиска

  $("#display").hide(); // Скрываем результаты поиска
}
