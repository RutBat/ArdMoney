<?php
include "inc/function.php";
AutorizeProtect();
access();
global $connect;
global $usr;
$material = h($_GET['material']);
$material_count = h($_GET['material_count']);
$material_delete = h($_GET['material_delete']);
$name1 = h($_GET['vid_rabot1']);
$count1 = h($_GET['count1']);
$name2 = h($_GET['vid_rabot2']);
$count2 = h($_GET['count2']);
$name3 = h($_GET['vid_rabot3']);
$count3 = h($_GET['count3']);
$name4 = h($_GET['vid_rabot4']);
$count4 = h($_GET['count4']);
$mon_id = h($_GET['mon_id']);
$summa = h($_GET['summa']);
$kajdomu = h($_GET['kajdomu']);
$other = h($_GET['other']);
$technik1 = h($_GET['technik']['0']);
$technik2 = h($_GET['technik']['1']);
$technik3 = h($_GET['technik']['2']);
$technik4 = h($_GET['technik']['3']);
$technik5 = h($_GET['technik']['4']);
$technik6 = h($_GET['technik']['5']);
$technik7 = h($_GET['technik']['6']);
$technik8 = h($_GET['technik']['7']);



if (empty($count1)) {
    $count1 = 1;
}
if (empty($count2)) {
    $count2 = 1;
}
if (empty($count3)) {
    $count3 = 1;
}
if (empty($count4)) {
    $count4 = 1;
}
if (isset($_GET['delete'])) {
    $id_del = $_GET['delete'];
    del_mon($id_del);
    edit_montaj_summa("$mon_id");
    $str = $mon_id;
    $encodedStr = base64_encode($str);
    red_index("result.php?vid_id=$encodedStr");
    exit;
}
if (!empty($material)) {
    if (empty($material_count)) {
        $material_count = 1;
    }
    $sql = "INSERT INTO used_material (name, count, id_montaj)
			VALUES (
			'$material',
			'$material_count',
			'$mon_id'
			)";
    if ($connect->query($sql) === true) {
    } else {
        echo $connect->error;
    }
}
if (!empty($_GET['material_delete'])) {
    // Получение значения, которое нужно удалить
    $sql_delete = "DELETE FROM used_material WHERE id = $_GET[material_delete] AND id_montaj = $mon_id";
    $result_delete = mysqli_query($connect, $sql_delete);
    $str = $mon_id;
    $encodedStr = base64_encode($str);
    red_index("result.php?vid_id=$encodedStr");
    exit;
}
$montaj = $connect->query("SELECT * FROM `montaj` WHERE `id` = '" . $mon_id . "' limit 1");
if ($montaj->num_rows != 0)
    $mon = $montaj->fetch_array(MYSQLI_ASSOC);
$tech1 = $mon['technik1'];
$tech2 = $mon['technik2'];
$tech3 = $mon['technik3'];
$tech4 = $mon['technik4'];
$tech5 = $mon['technik5'];
$tech6 = $mon['technik6'];
$tech7 = $mon['technik7'];
$tech8 = $mon['technik8'];
$adress_mon = $mon['adress'];
$id_mon = $mon['id'];



$array_montaj = $connect->query("SELECT * FROM `array_montaj` WHERE `mon_id` = '" . $mon_id . "' AND `name` = '" . $name1 . "'");
if ($array_montaj->num_rows == 0) {
    if (!empty($name1) and !empty($mon_id)) {
        $vid_montaj1 = $connect->query("SELECT * FROM `vid_rabot` WHERE `name` = '" . $name1 . "' limit 1");
        if ($vid_montaj1->num_rows != 0)
            $vid_mon1 = $vid_montaj1->fetch_array(MYSQLI_ASSOC);
        $pric1 = $vid_mon1['price_tech'];
        $price1 = $pric1 * $count1;
        if (!empty($other)) {
            $text = $other;
        } else {
            $text = $vid_mon1['text'];
        }
        $log   = "$date $fio $text2 $adress $new_status_home";
        $zap   = "INSERT INTO array_montaj (name, mon_id, count, price, text)
VALUES (
'$name1',
'$mon_id',
'$count1',
'$price1',
'$text'
)";
        if ($connect->query($zap) === true) {
        } else {
            echo "Ошибка: " . $sql . "<br>" . $connect->error;
        }
    }
} else {
}


$array_montaj = $connect->query("SELECT * FROM `array_montaj` WHERE `mon_id` = '" . $mon_id . "' AND `name` = '" . $name2 . "'");
if ($array_montaj->num_rows == 0) {
    if (!empty($name2) and !empty($mon_id)) {
        $vid_montaj2 = $connect->query("SELECT * FROM `vid_rabot` WHERE `name` = '" . $name2 . "' limit 1");
        if ($vid_montaj2->num_rows != 0)
            $vid_mon2 = $vid_montaj2->fetch_array(MYSQLI_ASSOC);
        $pric2 = $vid_mon2['price_tech'];
        $price2 = $pric2 * $count2;
        if (!empty($other)) {
            $text = $other;
        } else {
            $text = $vid_mon2['text'];
        }
        $log   = "$date $fio $text2 $adress $new_status_home";
        $zap   = "INSERT INTO array_montaj (name, mon_id, count, price, text)
VALUES (
'$name2',
'$mon_id',
'$count2',
'$price2',
'$text'
)";
        if ($connect->query($zap) === true) {
        } else {
            echo "Ошибка: " . $sql . "<br>" . $connect->error;
        }
    }
} else {
}

$array_montaj = $connect->query("SELECT * FROM `array_montaj` WHERE `mon_id` = '" . $mon_id . "' AND `name` = '" . $name3 . "'");
if ($array_montaj->num_rows == 0) {
    if (!empty($name3) and !empty($mon_id)) {
        $vid_montaj3 = $connect->query("SELECT * FROM `vid_rabot` WHERE `name` = '" . $name3 . "' limit 1");
        if ($vid_montaj3->num_rows != 0)
            $vid_mon3 = $vid_montaj3->fetch_array(MYSQLI_ASSOC);
        $pric3 = $vid_mon3['price_tech'];
        $price3 = $pric3 * $count3;
        if (!empty($other)) {
            $text = $other;
        } else {
            $text = $vid_mon3['text'];
        }
        $log   = "$date $fio $text2 $adress $new_status_home";
        $zap   = "INSERT INTO array_montaj (name, mon_id, count, price, text)
VALUES (
'$name3',
'$mon_id',
'$count3',
'$price3',
'$text'
)";
        if ($connect->query($zap) === true) {
        } else {
            echo "Ошибка: " . $sql . "<br>" . $connect->error;
        }
    }
} else {
}


$array_montaj = $connect->query("SELECT * FROM `array_montaj` WHERE `mon_id` = '" . $mon_id . "' AND `name` = '" . $name4 . "'");
if ($array_montaj->num_rows == 0) {
    if (!empty($name4) and !empty($mon_id)) {
        $vid_montaj4 = $connect->query("SELECT * FROM `vid_rabot` WHERE `name` = '" . $name4 . "' limit 1");
        if ($vid_montaj4->num_rows != 0)
            $vid_mon4 = $vid_montaj4->fetch_array(MYSQLI_ASSOC);
        $pric4 = $vid_mon4['price_tech'];
        $price4 = $pric4 * $count4;
        if (!empty($other)) {
            $text = $other;
        } else {
            $text = $vid_mon4['text'];
        }
        $log   = "$date $fio $text2 $adress $new_status_home";
        $zap   = "INSERT INTO array_montaj (name, mon_id, count, price, text)
VALUES (
'$name4',
'$mon_id',
'$count4',
'$price4',
'$text'
)";
        if ($connect->query($zap) === true) {
        } else {
            echo "Ошибка: " . $sql . "<br>" . $connect->error;
        }
    }
} else {
}

if (!empty($technik1)) {
    $upd_tech   = "UPDATE montaj SET `technik1` = '$technik1' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
} else {
    $upd_tech   = "UPDATE montaj SET `technik1` = '' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
}
if (!empty($technik2)) {
    $upd_tech   = "UPDATE montaj SET `technik2` = '$technik2' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
} else {
    $upd_tech   = "UPDATE montaj SET `technik2` = '' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
}
if (!empty($technik3)) {
    $upd_tech   = "UPDATE montaj SET `technik3` = '$technik3' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
} else {
    $upd_tech   = "UPDATE montaj SET `technik3` = '' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
}
if (!empty($technik4)) {
    $upd_tech   = "UPDATE montaj SET `technik4` = '$technik4' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
} else {
    $upd_tech   = "UPDATE montaj SET `technik4` = '' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
}
if (!empty($technik5)) {
    $upd_tech   = "UPDATE montaj SET `technik5` = '$technik5' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
} else {
    $upd_tech   = "UPDATE montaj SET `technik5` = '' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
}
if (!empty($technik6)) {
    $upd_tech   = "UPDATE montaj SET `technik6` = '$technik6' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
} else {
    $upd_tech   = "UPDATE montaj SET `technik6` = '' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
}
if (!empty($technik7)) {
    $upd_tech   = "UPDATE montaj SET `technik7` = '$technik7' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
} else {
    $upd_tech   = "UPDATE montaj SET `technik7` = '' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
}
if (!empty($technik8)) {
    $upd_tech   = "UPDATE montaj SET `technik8` = '$technik8' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
} else {
    $upd_tech   = "UPDATE montaj SET `technik8` = '' WHERE `id` = $mon_id";
    if ($connect->query($upd_tech) === true) {
    } else {
        echo "Ошибка: " . $sql . "<br>" . $connect->error;
    }
}

edit_montaj_summa("$mon_id");
$str = $mon_id;
$encodedStr = base64_encode($str);
$material     = h($_GET['material']);
$material_delete = h($_GET['material_delete']);
unset($material, $material_delete, $name1, $name2, $name3, $name4, $name2, $count1, $count2, $count3, $count4,  $mon_id, $summa, $kajdomu, $other);
red_index("result.php?vid_id=$encodedStr");
