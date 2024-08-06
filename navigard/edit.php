<?php
include "inc/function.php";
AutorizeProtect();
global $connect;
global $usr;
$id         = h($_GET['id']);
$adress     = h($_GET['adress']);
$results    = $connect->query("SELECT * FROM adress WHERE adress LIKE '$adress' LIMIT 1");
$this_house = $results->num_rows == 1 ? $results->fetch_array(MYSQLI_ASSOC) : '';
//Если данных нет то осталяем без изменений, если есть добавляем их в переменную
$complete   = empty(h($_GET['check'])) ? 0 : h($_GET['check']);
$dopzamok   = empty(h($_GET['dopzamok'])) ? $this_house['dopzamok'] : h($_GET['dopzamok']);
$vihod1     = h($_GET['vihod']['0']);
$vihod2     = h($_GET['vihod']['1']);
$vihod3     = h($_GET['vihod']['2']);
$vihod4     = h($_GET['vihod']['3']);
$vihod5     = h($_GET['vihod']['4']);
//Сам не понял зачем написал такой алгоритм проверки
// $vihod1 =  empty(h($_GET['vihod']['0'])) ? $this_house['vihod'] : h($_GET['vihod']['0']);
// $vihod2 =  empty(h($_GET['vihod']['1'])) ? $this_house['vihod2'] : h($_GET['vihod']['1']);
// $vihod3 =  empty(h($_GET['vihod']['2'])) ? $this_house['vihod3'] : h($_GET['vihod']['2']);
// $vihod4 =  empty(h($_GET['vihod']['3'])) ? $this_house['vihod4'] : h($_GET['vihod']['3']);
// $vihod5 =  empty(h($_GET['vihod']['4'])) ? $this_house['vihod5'] : h($_GET['vihod']['4']);
$kluch      = empty(h($_GET['kluch'])) ? $this_house['kluch'] : h($_GET['kluch']);
$krisha     = empty(h($_GET['krisha'])) ? $this_house['krisha'] : h($_GET['krisha']);
$link     = empty(h($_GET['link'])) ? $this_house['link'] : h($_GET['link']);
$pitanie     = empty(h($_GET['pitanie'])) ? $this_house['pitanie'] : h($_GET['pitanie']);
$podjezd    = empty(h($_GET['podjezd'])) ? $this_house['podjezd'] : h($_GET['podjezd']);
$pon        = empty(h($_GET['pon'])) ? $this_house['pon'] : h($_GET['pon']);
$oboryda    = empty(h($_GET['oboryda'])) ? $this_house['oboryda'] : h($_GET['oboryda']);
$lesnica    = empty(h($_GET['lesnica'])) ? $this_house['lesnica'] : h($_GET['lesnica']);
$pred       = empty(h($_GET['pred'])) ? $this_house['pred'] : h($_GET['pred']);
$phone      = empty(h($_GET['phone'])) ? $this_house['phone'] : h($_GET['phone']);
$region     = empty(h($_GET['region'])) ? $this_house['region'] : h($_GET['region']);
//$text       = empty(h($_GET['text'])) ? $this_house['text'] : h($_GET['text']);

$history = $this_house['history'];



if($adress != $this_house['adress']){
    $log1 = "Смена адреса дома <br>";
}
if($complete != $this_house['complete']){
    $log2 = "Смена статуса завершенности дома <br>";
}
if($dopzamok != $this_house['dopzamok']){
    $log3 = "Смена статуса допзамков <br>";
}
// if($vihod1 != $this_house['vihod0'] or $vihod2 != $this_house['vihod1'] or $vihod3 != $this_house['vihod2'] or $vihod4 != $this_house['vihod3'] or $vihod5 != $this_house['vihod4']){
//     $log4 = "Смена статуса подъезда с выходом <br>";
// }
if($kluch != $this_house['kluch']){
    $log5 = "Смена статуса ключей <br>";
}
if($krisha != $this_house['krisha']){
    $log6 = "Смена статуса крыши <br>";
}
if($podjezd != $this_house['podjezd']){
    $log7 = "Смена статуса подъездов <br>";
}
if($pon != $this_house['pon']){
    $log8 = "Смена статуса типа сети <br>";
}
if($oboryda != $this_house['oboryda']){
    $log9 = "Смена размещения оборудования <br>";
}
if($lesnica != $this_house['lesnica']){
    $log10 = "Смена наличия лестницы <br>";
}
if($pred != $this_house['pred']){
    $log11 = "Смена информации о председателе <br>";
}
if($phone != $this_house['phone']){
    $log12 = "Смена номера телефона председателя <br>";
}
if($region != $this_house['region']){
    $log13 = "Смена региона дома <br>";
}
if(!empty($text)){
    $log14 = "Добавленно новое примечание <br>";
}


$new_status_home = "<br> $log1 $log2 $log3 $log5 $log6 $log7 $log8 $log9 $log10 $log11 $log12 $log14";

$text = h($_GET['text']);
$date  = date("d.m.Y H:i:s");
$fio  = $usr['fio'];
$text_new = "[$date] $fio $text";
$text = $text_new ."<br>". $this_house['text'];
//////////////////////////////////////////////////////////////////////////////////////////////
$new        = 0;
if (empty($adress)) {
    echo 'Введите адрес дома';
    exit();
}

$text2 = 'отредактировал дом -';
$log   = "$date $fio $text2 $adress $new_status_home";
$zap   = "INSERT INTO log (kogda, log)
VALUES (
'$date',
'$log'
)";
$log = "$log <br> $history";
if ($connect->query($zap) === false) {
    echo "Ошибка: " . $zap . "<br>" . $connect->error;
}




if(empty($_GET['text'])){
$sql = "UPDATE adress SET
adress = '$adress',
vihod = '$vihod1',
vihod2 = '$vihod2',
vihod3 = '$vihod3',
vihod4 = '$vihod4',
vihod5 = '$vihod5',
oboryda = '$oboryda',
dopzamok = '$dopzamok',
kluch = '$kluch',
pred = '$pred',
phone = '$phone',
krisha = '$krisha',
lesnica = '$lesnica',
link = '$link',
pitanie = '$pitanie',
pon = '$pon',
podjezd = '$podjezd',
editor = '$fio',
region = '$region',
new = '$new',
complete = '$complete',
history = '$log'
WHERE id = '$id'";
}else{
$sql = "UPDATE adress SET
adress = '$adress',
vihod = '$vihod1',
vihod2 = '$vihod2',
vihod3 = '$vihod3',
vihod4 = '$vihod4',
vihod5 = '$vihod5',
oboryda = '$oboryda',
dopzamok = '$dopzamok',
kluch = '$kluch',
pred = '$pred',
phone = '$phone',
krisha = '$krisha',
lesnica = '$lesnica',
link = '$link',
pitanie = '$pitanie',
pon = '$pon',
podjezd = '$podjezd',
text = '$text',
editor = '$fio',
region = '$region',
new = '$new',
complete = '$complete',
history = '$log'
WHERE id = '$id'";
}










if ($connect->query($sql) === true) {
    red_index("/result.php?adress=$adress&success");
    exit;
} else {
    echo "Ошибка: " . $sql . "<br>" . $connect->error;
}
include 'inc/foot.php';