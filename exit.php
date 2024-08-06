<?php
session_start();
setcookie('user', '', 1);
setcookie('pass', '', 1);
session_destroy();
session_unset();
echo '<meta http-equiv="refresh" content="0;URL=/auth.php">';
exit();
