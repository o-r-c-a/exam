<?php
session_start();
unset($_SESSION['userID']);
setcookie("userID", @$_POST["userID"], time() - 3600);
setcookie("username", @$_POST["username"], time() - 3600);
setcookie("password", @$_POST["password"], time() - 3600);
setcookie("logincookie", @$_POST["logincookie"], time() - 3600);
session_destroy();
header('Location: index.php');
?>