<?php
include "inc/head.php";
AutorizeProtect();
access();
global $connect;
global $usr;
?>

<head>
    <title>Добавить работу</title>
</head>
<form method="GET" action="add_mon.php" style="
    font-family: system-ui;
">
    <div class="mb-3" style="padding: 10px 10px 0px;">
        <br>
        <div class="montaj_input">
            <input autofocus list="provlist" id="search" type="text" name="adress" class="form-control" required title="Введите от 4 символов" placeholder="Введите адрес">
            <div id="display"></div>
        </div>
        <script type="text/javascript" src="/js/searcher.js"></script>
        <br>
        <div class="mb-3" style="padding: 1rem 0rem 0rem;">
            <textarea placeholder="Что там делал(кратко)" name="text" class="form-control montaj_textarea" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <ul id="search-results" class="list-group"></ul>










        <script>
            $(document).ready(function() {
                // Функция поиска
                function search() {
                    var searchTerm = $("#exampleFormControlTextarea1").val();
                    $.ajax({
                        url: "/search_4todelal.php", // путь к обработчику запросов
                        method: "POST",
                        data: {
                            search: searchTerm
                        },
                        success: function(data) {
                            // Очищаем список результатов
                            $("#search-results").empty();
                            // Если есть результаты поиска, выводим их в виде списка
                            if (data.length > 0) {
                                var results = JSON.parse(data);
                                for (var i = 0; i < results.length; i++) {
                                    $("#search-results").append("<li class='search-result list-group-item pizdec'>" + results[i].text + "</li>");
                                }
                                // При нажатии на результат, записываем его в поле ввода
                                $(".search-result").click(function() {
                                    var selectedText = $(this).text();
                                    $("#exampleFormControlTextarea1").val(selectedText);
                                    $("#search-results").empty();
                                });
                            }
                        }
                    });
                }

                // Выполняем поиск при каждом вводе в поле ввода
                $("#exampleFormControlTextarea1").on("input", function() {
                    search();
                });
            });
        </script>







        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Varela+Round&amp;display=swap'>
        <link rel="stylesheet" href="css/checbox.css">
        <br>
        <div class='form-text text-center fw-bold pb-4'>Кто был?</div>
        <?
        $sql = "SELECT * FROM `user` WHERE `region` = '" . $usr['region'] . "' ORDER BY `brigada` ";
        $res_data = mysqli_query($connect, $sql);
        while ($tech = mysqli_fetch_array($res_data)) {
        ?>
            <div class="form-check">





                <div id="checklist" class="form-check">
                    <input type="checkbox" value="<?= $tech['fio'] ?>" name="technik[]" id="flexCheckDefault<?= $tech['id'] ?>">
                    <label for="flexCheckDefault<?= $tech['id'] ?>"> <?= $tech['fio'] ?></label>

                </div>
            </div>
        <?
        }
        ?>
        <input type="hidden" value="<?= $usr['region'] ?>" name="region">
    </div>
    <br>
    </div>
    <div data-role="footer">
        <div class="d-grid gap-2 ">
            <button type="submit" class="btn btn-lg" style="background: #445e3b;
    border-radius: 0px;
    border: 2px solid #2c3c26d1;color:#fff">Добавить монтаж</button>
        </div>
    </div>

</form>
<?php include 'inc/foot.php';
