<?php
include "inc/head.php";
access();
AutorizeProtect();
global $connect;
global $usr;
?>

<head>
    <title>Камеры мирное</title>
</head>
<?
$month = date_view($_GET['date']);
$date_blyat = "$_GET[date]";
if (!isset($_GET['date'])) {
    $month = date('m');
    $year = date('y');
    $month = month_view(date('m'));
    $date = date("Y-m-d");
    $date_blyat = substr($date, 0, -3);
}
?>

<ul class="list-group">
    <li class="list-group-item" style="padding: 0; border: none;">

        <?
        if ($usr['admin'] == "1" || $usr['name'] == "RutBat") {
        ?>
            <table class="table" style="margin-bottom: 0rem;">
                <thead>
                    <tr>
                        <th scope="col">Техник</th>
                        <th scope="col">Сколько точек делал</th>
                        <th scope="col">За камеры</th>
                    </tr>
                </thead>
                <tbody style="background: rgb(222,252,186);
background: linear-gradient(180deg, rgba(222,252,186,0.8155637254901961) 5%, rgba(224,255,203,0.6362920168067228) 16%, rgba(229,252,217,0.8015581232492998) 74%);">
                    <?


                    $sql = "SELECT * FROM `user` WHERE `region` = '" . $usr['region'] . "' ORDER BY `id` desc";
                    $res_data = mysqli_query($connect, $sql);
                    $totalSum = 0;
                    while ($tech = mysqli_fetch_array($res_data)) {


                    ?>
                        <tr>
                            <td><a style="color: black;
    font-family: cursive;
    font-weight: 100;
    font-size: small;" href="index.php?current_user=<?= $tech['fio'] ?>"><?= $tech['fio'] ?></a></td>
    <td>   
        
    <? 
    num_cam("$tech[fio]", "$month", 2023);


?>
</td>

                            <td><?
$summa = summa_cam("$tech[fio]", "$month", 2023);
echo $summa;
$totalSum += $summa;
                                ?> р.
                            </td>
                        </tr>
                    <?
                    }
                    
                    ?>
                    <tr>
                        <td>Итого</td>
                        <td>   
        
        <? 
        sum_cam("$month", 2023);
    
    
    ?>
    </td>
                        <td>
                        <?=$totalSum?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?
        }



        ?>
        <br>

    </li>
</ul>
</div>
<?php include 'inc/foot.php';
?>