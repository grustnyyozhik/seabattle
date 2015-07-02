<?php
include("include/connect.php");
header('Content-Type: text/xml');

$user_id = $_POST['user_id'];

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


$winner = $partner_id;
$turn = "Game Over";

//update turn and winner

$sql  = "UPDATE games SET turn='$turn', winner='$winner' WHERE  user_id='$user_id' OR user_id='$partner_id'";
$result4 =  mysql_query($sql);
if (!$result4)
	{
		die('Coud not update in database:'.mysql_error());
	}
	
	
	
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result5 =  mysql_query($sql);
if (!$result5)
	{
		die('Coud not select in database:'.mysql_error());
	}
$row = mysql_fetch_assoc($result5);
$total_games = $row['total_games'];
$lost_games = $row['lost_games'];

$total_games++;
$lost_games++;


$sql  = "UPDATE users SET total_games='$total_games' , lost_games='$lost_games' WHERE user_id='$user_id'";
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
$won_games = $row['won_games'];

$total_games++;
$won_games++;

$sql  = "UPDATE users SET total_games='$total_games' , won_games='$won_games' WHERE user_id='$partner_id'";
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


$response  =  '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
$response .= '<response>';
$response .= '<TURN>'. $turn.'</TURN>';
$response .= '<FREESHIPS>0</FREESHIPS>';
$response .= '<SUBMIT>yes</SUBMIT>';
$response .= '<USER>' . $user_id .'</USER>';
$response .= '<WINNER>' . $winner .'</WINNER>';
$response .='</response>';

echo $response;

?>