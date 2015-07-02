<?php
include("include/connect.php");
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';

	$user_id=$_POST['user_id'];
	//check whther player is playing already
	$sql = "SELECT * FROM current_games WHERE player_one_id = '$user_id' OR player_two_id = '$user_id'";
	$result =  mysql_query($sql);
	$num = mysql_num_rows($result);
	
	$sql = "SELECT * FROM games WHERE user_id = '$user_id'";
	$result =  mysql_query($sql);
	$num = $num + mysql_num_rows($result);
	
	//player is not playing yet
	if($num == 0)
	{
	//choose free waiting player
	$sql = "SELECT * FROM active_users WHERE user_id != '$user_id'";
	$result =  mysql_query($sql);
	$num = mysql_num_rows($result);
	if($num != 0)
	{	
		$firstrow = mysql_fetch_assoc($result);
		$player_one_id = $user_id;
		$player_two_id  = $firstrow['user_id'];
		
		//active playes are playing
		$result2 = mysql_query("DELETE FROM `active_users` WHERE user_id='$player_two_id'") or die(mysql_error());
		$result3 = mysql_query("DELETE FROM `active_users` WHERE user_id='$player_one_id'") or die(mysql_error());
		$result4 = mysql_query("INSERT INTO current_games(game_id, player_one_id, player_two_id) VALUES('', '$player_one_id', '$player_two_id')");
		$result5 = mysql_query("INSERT INTO games(board_id, user_id, board, free_ships, submit, turn, winner, kills, misses) VALUES('', '$player_one_id', '' , '20', 'no', 'none', 'none', 0, 0)");
		$result6 = mysql_query("INSERT INTO games(board_id, user_id, board, free_ships, submit, turn, winner, kills, misses) VALUES('', '$player_two_id', '' , '20', 'no', 'none', 'none', 0, 0)");
		
		
		echo $player_one_id;
	
	}
	else//no active player found
	{
		echo "No active players found. Wait please.";
	}	
	
	}
	//player is playing, send to corresponding page
	else
	{
		echo $user_id;
	}
	
echo '</response>';
?>