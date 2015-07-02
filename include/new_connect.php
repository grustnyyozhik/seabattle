<?php
$mysql_host='localhost';
$mysql_user='root';
$mysql_password='';

$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_password, "seabattle_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>