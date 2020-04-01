<?php

session_start();
session_destroy();
setcookie('_ua_',md5(1),time() - 0,'','','',true);
header('location:sign-in.php');


?>
