<?php
$conn_error='Connection failed';
$mysql_host='localhost';
$mysql_user='root';
$mysql_password='';

$connect = @mysql_connect($mysql_host,$mysql_user,$mysql_password);
if(!$connect)
{
	die($conn_error.mysq_error());
}

$db_to_use = mysql_select_db("seabattle_db");
if(!$db_to_use)
{
	die(mysq_error());
}
?>