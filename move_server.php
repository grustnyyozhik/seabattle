<?php
include("include/connect.php");
header('Content-Type: text/xml');
$info = $_POST['info'];
$info_arr = explode(',', $info);

$user_id=$info_arr[1];
$ship_id=$info_arr[0];

$info_arr = explode('_', $ship_id);//state + coord of box
$coord = $info_arr[0];
$state = $info_arr[1];



$finished_game = 0;

//find out who is the partner
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

/////////////////
$sql = "SELECT * FROM games WHERE user_id='$user_id'";
$result7 =  mysql_query($sql);
if (!$result7)
	{
		die('Coud not select in database:'.mysql_error());
	}
$row = mysql_fetch_assoc($result7);	
$kills= $row['kills'];
$misses = $row['misses'];
//get winner
$winner = 'none';



//get partner's board
$sql = "SELECT * FROM games WHERE user_id='$partner_id'";
$result1 =  mysql_query($sql);
if (!$result1)
	{
		die('Coud not select in database:'.mysql_error());
	}
	
$partner_row = mysql_fetch_assoc($result1);	
$board = $partner_row['board'];

if($board != ''){
$board_arr = explode(',', $board);
}
else
{
$board_arr = NULL;
}

//change state
$ship= $board_arr[$coord];

if($ship == 'none')
{
$ship = str_replace("none", $state, $ship);
$misses++;
$turn = $partner_id;
}
else
{
$ship = str_replace("ok", $state, $ship);
$kills++;
$turn = $user_id;
}

$board_arr[$coord] = $ship;

//check how many ships remained

if($kills==20)
{
$winner = $user_id;
$turn = "Game Over";
$finished_game = 1;
}

//update the board in data base
$board = implode(',', $board_arr);

$sql = "UPDATE games SET board='$board' WHERE user_id='$partner_id'" ;
$result3 =  mysql_query($sql);
if (!$result3)
	{
		die('Coud not select in database:'.mysql_error());
	}

//update turn

$sql  = "UPDATE games SET turn='$turn', winner='$winner' WHERE  user_id='$user_id' OR user_id='$partner_id'";
$result4 =  mysql_query($sql);
if (!$result4)
	{
		die('Coud not update in database:'.mysql_error());
	}
//update kills and misses
$sql  = "UPDATE games SET kills='$kills', misses='$misses' WHERE  user_id='$user_id'";
$result8 =  mysql_query($sql);
if (!$result8)
	{
		die('Coud not update in database:'.mysql_error());
	}



//update everyones number of games, losses and wins

if($finished_game == 1)
{
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result5 =  mysql_query($sql);
if (!$result5)
	{
		die('Coud not select in database:'.mysql_error());
	}
$row = mysql_fetch_assoc($result5);
$total_games = $row['total_games'];
$lost_games = $row['lost_games'];
$won_games = $row['won_games'];

$total_games++;

if($winner==$user_id)
{
$won_games++;
}
else
{
$lost_games++;
}
$sql  = "UPDATE users SET total_games='$total_games' , lost_games='$lost_games', won_games='$won_games' WHERE user_id='$user_id'";
$result5 =  mysql_query($sql);
if (!$result5)
	{
		die('Coud not update in database:'.mysql_error());
	}

$sql = "SELECT * FROM users WHERE user_id = '$partner_id'";
$result5 =  mysql_query($sql);
if (!$result5)
	{
		die('Coud not select in database:'.mysql_error());
	}
$row = mysql_fetch_assoc($result5);
$total_games = $row['total_games'];
$lost_games = $row['lost_games'];
$won_games = $row['won_games'];

$total_games++;

if($winner==$partner_id)
{
$won_games++;
}
else
{
$lost_games++;
}
$sql  = "UPDATE users SET total_games='$total_games' , lost_games='$lost_games', won_games='$won_games' WHERE user_id='$partner_id'";
$result5 =  mysql_query($sql);
if (!$result5)
	{
		die('Coud not update in database:'.mysql_error());
	}
	
$result6 = mysql_query("DELETE FROM `current_games` WHERE player_one_id='$user_id' OR player_two_id='$user_id'") or die(mysql_error());
if (!$result6)
	{
		die('Coud not update in database:'.mysql_error());
	}
}	
////////////////////////////////////////////////////////////////////////////////////////////////////////

$response  =  '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
$response .= '<BOARD>';
$response .= '<TURN>'. $turn.'</TURN>';
$response .= '<USER>' . $user_id .'</USER>';
$response .= '<WINNER>' . $winner .'</WINNER>';

if ($ship != 'none' && $ship != 'missed')
{
$temp = explode('_', $ship);
$ship= $temp[1];
}
$response .='<PBOX>';
$response .= '<PSHIP>'.$ship.'</PSHIP>';
$response .='<COORD>'. $coord .'</COORD>';
$response .= '</PBOX>';
$response .= '</BOARD>';

echo $response;

?>