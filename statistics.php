<?php
require_once("include/secure_session.php");
include("include/game_frame.php");
include("include/connect.php");

function GameResults($user_id, $gamelast)
{
$sql = "SELECT * FROM games WHERE user_id = '$user_id'";
$result =  mysql_query($sql);
if (!$result)
	{
		die('Coud not select in database:'.mysql_error());
	}
$num = mysql_num_rows($result);		
if($num==1)	
{	
$row = mysql_fetch_assoc($result);
$board = $row['board'];
$total_steps = $row['kills'] + $row['misses'];
$board_arr = explode(',', $board);
$own_fleet_killed = 0;

$winner = $row['winner'];
$sql = "SELECT nickname FROM users WHERE user_id = '$winner'";
$result =  mysql_query($sql);
if (!$result)
	{
		die('Coud not select in database:'.mysql_error());
	}
$row1 = mysql_fetch_assoc($result);

foreach ($board_arr as $key => $value)
{

if (strpos($value, 'killed') !== false)
{
$own_fleet_killed++;
}
}

echo '<label class="headers">Game Results:</label> <div class="field">
			<label class="headers">Winner Of The Game Is Player: ';

echo  $row1['nickname'];

echo '</label>
		</div>
		<div class="field">
			<label class="headers">The Game Last: ';
		
echo 	gmdate("H:i:s", $gamelast);
		
		
echo	'</label>
		</div>
		<div class="field">
			<label class="headers">Your Total Number Of Moves: ';
			

			echo $total_steps;
echo '</label>
		</div>
		<div class="field">
			<label class="headers">You Missed: ';
			 
echo $row['misses'];

echo '</label>
		</div>
		<div class="field">
			<label class="headers">You Killed: ';
			
echo $row['kills'];

echo '</label>	
		</div>
		
		<div class="field">
			<label class="headers">You Lost: ';
			
echo $own_fleet_killed;	

echo '</label>
		</div>';

}
else {

echo '<label class="headers">All the temporary game results are deleted.</label>';
}
}

function TotalResults($user_id)
{

$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result2 =  mysql_query($sql);
if (!$result2)
	{
		die('Coud not select in database:'.mysql_error());
	}
$row = mysql_fetch_assoc($result2);	

echo '<label class="headers">Playes General Statistics:</label>
		
		<div class="field">
			<label class="headers">Total Number Of Games: ';

echo $row['total_games'];

echo '</label>
		</div>
		<div class="field">
			<label class="headers">Lost Games: ';
echo $row['lost_games'];


echo '</label>
		</div>
		<div class="field">
			<label class="headers">Won Games: ';
echo $row['won_games'];

echo '</label>
		</div>';

$result3 = mysql_query("DELETE FROM `games` WHERE user_id='$user_id'") or die(mysql_error());
if (!$result3)
	{
		die('Coud not update in database:'.mysql_error());
	}
}


if(isset($_SESSION['user_id'], $_SESSION['nickname'],$_SESSION['gamestart'] )) {
     $user_id = $_SESSION['user_id'];
     $nickname = $_SESSION['nickname'];
	 $start = $_SESSION['gamestart'];
	 if(!isset($_SESSION['gamelast']))
	 {
		$now = time();
		$_SESSION['gamelast'] = $now - $start;
	 }
		$gamelast = $_SESSION['gamelast'];
		
echo '<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Statistics</title>
   <link rel="stylesheet" href="css/main.css" >
   <link rel="stylesheet" href="css/game.css" >
    <link rel="stylesheet" href="css/game_page.css" >

</head>
<body>

    <div id="main_box">';
	 	
		
		GameFrameCode();
echo 		'<section id="left_side">';
		
		GameResults($user_id, $gamelast);
echo	'</section>
        <section id="right_side" >';
		
		TotalResults($user_id);
		
echo   '<button id="button" class="button" type="button" onClick="exitGame()">Finish</button>
		</section>	
		<footer id="main_footer">
			Sea Battle 2013
		</footer>
		  
   </div>
</body>

<script type="text/javascript">
		function exitGame()
		{
			window.location.href="index.php";
		}
		</script>
</html>';


}
else
{
 echo 'You are not authorized to access this page, please login. <br/>';
}
