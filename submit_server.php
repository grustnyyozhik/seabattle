<?php
include("include/connect.php");
header('Content-Type: text/xml');

$free_ships = 20;
$board_info_string=$_POST["board_info"];
$board_info = explode(',', $board_info_string);
$user_id = array_pop($board_info);
$board = implode(',', $board_info);
$answer = "ok";

//count free ships
foreach ($board_info as $value)
{
if ($value != 'none')
{
$free_ships--;
}
}

//insert current board, free ships, submit
$sql = "UPDATE games SET free_ships='$free_ships', board='$board', submit='yes' WHERE user_id='$user_id'" ;
$result =  mysql_query($sql);
if (!$result)
	{
		die('Coud not select in database:'.mysql_error());
		$answer = "error";
	}

$response  =  '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
$response .= '<BOARD>';


$response .= $answer;
$response .=  '</BOARD>';
echo $response;

?>