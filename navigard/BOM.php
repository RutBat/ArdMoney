<?php
$HOME = dirname(__FILE__);
// Is this a Windows host ? If it is, change this line to $WIN = 1;
$WIN = 0;
// That's all I need
?>
<!DOCTYPE html>
<html lang="ru">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>UTF8 BOM FINDER and REMOVER</title>
        <style>
        body {
            font-size: 10px;
            font-family: Arial, Helvetica, sans-serif;
            background: #FFF;
            color: #000;
        }

        .FOUND {
            color: #F30;
            font-size: 14px;
            font-weight: bold;
        }
        </style>
    </head>

    <body>
        <?php
		$BOMBED = array();
		RecursiveFolder($HOME);
		echo '<h2>These files had UTF8 BOM, but i cleaned them:</h2><p class="FOUND">';
			foreach ($BOMBED as $utf) {
			echo $utf ."<br />\n";
			}
		echo '</p>';
		
		// Recursive finder
		function RecursiveFolder($sHOME) {
		global $BOMBED, $WIN;
		
		$win32 = ($WIN == 1)? "\\" : "/";
		
		$folder = dir($sHOME);
		
		$foundfolders = array();
		while($file = $folder->read()) {
		if($file != "." && $file != "..") {
		if(filetype($sHOME . $win32 . $file) == "dir"){
		$foundfolders[count($foundfolders)] = $sHOME . $win32 . $file;
		} else {
		$content = file_get_contents($sHOME . $win32 . $file);
		$BOM = SearchBOM($content);
		if($BOM) {
		$BOMBED[count($BOMBED)] = $sHOME . $win32 . $file;
		// Remove first three chars from the file
		$content = substr($content,3);
		// Write to file
		file_put_contents($sHOME . $win32 . $file, $content);
		}
		}
		}
		}
		$folder->close();
		
		if(count($foundfolders) > 0) {
		foreach ($foundfolders as $folder) {
		RecursiveFolder($folder, $win32);
		}
		}
		}
		// Searching for BOM in files
		function SearchBOM($string) {
		if(substr($string,0,3) == pack("CCC",0xef,0xbb,0xbf)) {
		return true;
		}
		return false;
		}
		?>
    </body>

</html>