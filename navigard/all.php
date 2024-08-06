<?php

include "inc/head.php";

AutorizeProtect();
global $usr;
global $connect;
?>



<head>

    <title>Список домов</title>

</head>

<?php

if (!isset($_GET['all'])) {

    if ($usr[region] == "Сварочный отдел") {
    }else{
        button('<a href = "/all.php?all" class="btn bg-warning">Посмотреть все адреса</a>');

    }

} else {

        if ($usr[region] == "Сварочный отдел") {
    }else{
button("<a href = '/all.php' class='btn bg-warning btn-block'>Посмотреть все адреса: $usr[region]</a>");

    }

}


if ($_GET['id'] == "ok") {

    alrt("Успешно удаленно", "success", "2");

}

$pageno = isset($_GET['pageno']) ? h($_GET['pageno']) : 1;

//Тут я вместо 10 домов выставил 40

$size_page = 40;

//$size_page = $usr['result_count'];

$offset = ($pageno - 1) * $size_page;

$adrs = h($_GET['adress']);

$tech = h($_GET['tech']);

if (!empty($_GET['adress'])) {

    $sql = "SELECT * FROM `adress` WHERE adress LIKE '%$adrs%' ORDER BY `adress` LIMIT $offset, $size_page";

    $pages_sql = "SELECT COUNT(*) FROM `adress` WHERE adress LIKE '%$adrs%'";

    $split = "&adress=$adrs";

} else {

    $sql = "SELECT * FROM adress WHERE region LIKE '$usr[region]' ORDER BY `adress` LIMIT $offset, $size_page";

    $pages_sql = "SELECT COUNT(*) FROM `adress` WHERE region LIKE '$usr[region]'";

    $split = "&adress=$adrs";

    if (isset($_GET['tech'])) {

        $types = "&tech=$tech";

    } else {

        $types = "";

    }

    if (isset($_GET['all'])) {

        $sql = "SELECT * FROM adress  ORDER BY `adress` LIMIT $offset, $size_page";

        $pages_sql = "SELECT COUNT(*) FROM `adress`";

        $split = "&adress=$adrs";

        if (isset($_GET['tech'])) {

            $types = "&tech=$tech";

        } else {

            $types = "";

        }

    }


}

if ($tech == 'complete') {

    $sql = "SELECT * FROM `adress` WHERE complete LIKE '1' ORDER BY `adress` LIMIT $offset, $size_page";

    $pages_sql = "SELECT COUNT(*) FROM `adress` WHERE complete LIKE '1'";

    $split = "&adress=$adrs";

    $types = "&tech=$tech";

}

if ($tech == 'pon') {

    $sql = "SELECT * FROM `adress` WHERE pon LIKE 'Gpon' ORDER BY `adress` LIMIT $offset, $size_page";

    $pages_sql = "SELECT COUNT(*) FROM `adress` WHERE pon LIKE 'Gpon'";

    $split = "&adress=$adrs";

    $types = "&tech=$tech";

}

if ($tech == 'ethernet') {

    $sql = "SELECT * FROM `adress` WHERE pon LIKE 'Ethernet' ORDER BY `adress` LIMIT $offset, $size_page";

    $pages_sql = "SELECT COUNT(*) FROM `adress` WHERE pon LIKE 'Ethernet'";

    $split = "&adress=$adrs";

    $types = "&tech=$tech";

}

////////Поиск по адресу

//$pages_sql = "SELECT COUNT(*) FROM `adress`";

$result = mysqli_query($connect, $pages_sql);

$total_rows = mysqli_fetch_array($result)[0];

$total_pages = ceil($total_rows / $size_page);

$res_data = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_array($res_data)) {

    $color = $row['new'] == 1 ? 'text-danger' : '';

    $complete_color = $row['complete'] ? 'style = "color: forestgreen;"' : '';

    $text = $row['new'] == 1 ? 'NEW' : '';

?>

<!--Кнопка удаления дома из базы данных--->

<script type="text/javascript">

function startdel(i) {

    if (confirm("Точно удалить дом из базы?")) {

        parent.location = 'del.php?adress=<?= h($_GET["adress"]); ?>&id=' + i;

    }

}

</script>

<!--Тут я поставил padding: 0.5rem 1.25rem;-->

<li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 0 0;">


    <a style="margin-left: 15px;" <?= $complete_color ?> class="<?= $color ?> "

        href="/result?adress=<?= $row['adress'] ?>">

        <label for="exampleInputEmail1"><?= $text ?> <?= $row['adress'] ?></label>

    </a>

    <?php if ($usr['region'] == $row['region'] || $usr['admin'] == '1') { ?>

    <a href="JavaScript:startdel(<?= $row['id'] ?>)" class="close">

        <span aria-hidden="true" class = "badge btn-close" style="    padding: 10px;"> </span>
    </a>

    <?php }

       ?>
</li>
    <?php

    }

    mysqli_close($connect);

    if (isset($_GET['all'])) {

        $all = "&all";

    } else {

        $all = "";

    }

    ?>

    <div class="pagination">


        <?php

        echo "<a href='?pageno=1$split$types$all' type='button' class='col-md-1 col-sm-1   mx-auto  btn btn-warning' style = 'border-color:#000'>1</a>";

        ?>

        <a href="<?php if ($pageno <= 1) {
                        echo '#';
                 } else {
                     echo " ?pageno=" . ($pageno - 1) . $split . $types . $all;
                 } ?>" type="button" class="col-md-4 col-sm-4  col-4 mx-auto btn btn-warning-left <?php if ($pageno <= 1) {
                                                                                                                                                                                                     echo 'disabled';
                 } ?>" style="border-color:#000">

            <img src="img/icon/left.png" alt="<">

        </a>

        <div class="auto col-md-1 col-sm-1  col-1 mx-auto btn btn-warning disabled"

            style="border-color:#000;border-radius: 0;background-color: #fbfbfb;">

            <?= $pageno ?>

        </div>

        <a href="<?php if ($pageno >= $total_pages) {
                        echo '#';
                 } else {
                     echo " ?pageno=" . ($pageno + 1) . $split . $types . $all;
                 } ?>" type="button" class="col-md-4 col-sm-4 col-4 mx-auto  btn btn-warning-right <?php if ($pageno >= $total_pages) {
                                                                                                                                                                                                                 echo 'disabled';
                 } ?>" style="border-color:#000">

            <img src="img/icon/right.png" alt=">">

        </a>

        <a href="?pageno=<?= $total_pages . $split . $types . $all ?>" type="button"

            class="col-md-1 col-sm-1 mx-auto btn btn-warning" style="border-color:#000">

            <?= $total_pages ?>

        </a>

    </div>

    </div>

    <?php

    include 'inc/foot.php';

    ?>
