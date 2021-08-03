<?php
setcookie("user", $user['roleID'], time()-3600*24, "/");
header('Location:../index.php');