<?php
require_once("include/secure_session.php");

$_SESSION = array();
setcookie("sid", "", 1);
session_destroy();
header('Location:index.php');
?>