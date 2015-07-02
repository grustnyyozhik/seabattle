<?php
include("include/connect.php");
header('Content-Type: text/xml');
$user_id = $_POST['user_id'];

//find out who is partner
$sql = "SELECT * FROM current_games WHERE player_one_id = '$user_id' OR player_two_id = '$user_id'";
$result =  mysql_query($sql);
if (!$result)
	{
		die('Coud not select in database:'.mysql_error());
	}

$row = mysql_fetch_assoc($result);
if($row['player_one_id'] == $user_id)
{
$partner_id = $row['player_two_id'];
}
else
{
$partner_id = $row['player_one_id'];
}



//get board of the player, free ships he has

$sql = "SELECT * FROM games WHERE user_id='$user_id'";
$result1 =  mysql_query($sql);
if (!$result1)
	{
		die('Coud not select in database:'.mysql_error());
	}
	
$player_row = mysql_fetch_assoc($result1);	
$board = $player_row['board'];
if($board != ''){
$board_arr = explode(',', $board);
}
else
{
$board_arr = NULL;
}
$free_ships = $player_row['free_ships'];
$player_submit = $player_row['submit'];
$turn = $player_row['turn'];
$winner=$player_row['winner'];

//get board of the partner 
$sql = "SELECT * FROM games WHERE user_id='$partner_id'";
$result2 =  mysql_query($sql);
if (!$result2)
	{
		die('Coud not select in database:'.mysql_error());
	}
$partner_row = mysql_fetch_assoc($result2);	
$partner_submit = $partner_row['submit'];
$partner_board = $partner_row['board'];
if($partner_board != ''){
$partner_board_arr = explode(',', $partner_board);
}
else
{
$partner_board_arr = NULL;
}


//determine first turn

if ($turn=='none' && $player_submit=='yes' && $partner_submit=='yes')
{
$res = rand(1, 2);
if($res==1){
$turn = $user_id;
}
else{
$turn = $partner_id;
}
$sql  = "UPDATE games SET turn='$turn' WHERE  user_id='$user_id' OR user_id='$partner_id'";
$result3 =  mysql_query($sql);
if (!$result3)
	{
		die('Coud not update in database:'.mysql_error());
	}
	
}

//build xml response

$response  =  '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
$response .= '<BOARD>';


$response .= '<TURN>'. $turn.'</TURN>';
$response .= '<FREESHIPS>'.$free_ships.'</FREESHIPS>';
$response .= '<SUBMIT>'.$player_submit .'</SUBMIT>';
$response .= '<USER>' . $user_id .'</USER>';
$response .= '<WINNER>' . $winner .'</WINNER>';
if($board_arr != NULL)
{
foreach ($board_arr as $key => $value)
{
$response .='<SHIP>';
$response .='<COORD>'. $key .'</COORD>';
if ($value != 'none' && $value != 'missed')
{
$ship_num = explode('_', $value);
$response .= '<NUM>' . $ship_num[0] .'</NUM>';
$response .='<STATE>'. $ship_num[1] .'</STATE>';
}
else{
$response .='<STATE>'. $value .'</STATE>';
}
$response .= '</SHIP>';
}
}

if($partner_board_arr != NULL)
{
foreach ($partner_board_arr as $key => $value)
{
if ($value != 'none' && $value != 'missed')
{
$temp = explode('_', $value);
$value= $temp[1];
}
$response .='<PBOX>';
$response .= '<PSHIP>'.$value.'</PSHIP>';
$response .='<COORD>'. $key .'</COORD>';
$response .= '</PBOX>';

}
}
$response .=  '</BOARD>';
echo $response;



?>