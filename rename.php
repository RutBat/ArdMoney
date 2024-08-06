<?php
$target_dir = "uploads/";

if (isset($_POST["oldFileName"]) && isset($_POST["newFileName"])) {
    $oldFileName = $_POST["oldFileName"];
    $newFileName = $_POST["newFileName"];

    $oldFullPath = $target_dir . $oldFileName;
    $newFullPath = $target_dir . $newFileName;

    if (file_exists($oldFullPath)) {
        if (rename($oldFullPath, $newFullPath)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    } else {
        echo json_encode(array('success' => false));
    }
} else {
    echo json_encode(array('success' => false));
}
