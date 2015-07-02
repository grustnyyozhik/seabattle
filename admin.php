<?php
require_once("include/secure_session.php");
include("include/connect.php");
include("include/main_frame.php");

function CurrentGames()
{
$sql = "SELECT * FROM current_games";
$result =  mysql_query($sql);
if (!$result)
	{
		die('Could not select in database:'.mysql_error());
	}
	if(mysql_num_rows($result))
	{	
		while ($row = mysql_fetch_assoc($result))
		{
			echo '<label class="headers">Game Runs Between:</label> <div class="field"><label class="headers">';
			$first_player = $row['player_one_id'];
			$second_player = $row['player_two_id'];
			$sql = "SELECT * FROM users WHERE user_id='$first_player' OR user_id='$second_player'";
			$result1 =  mysql_query($sql);
			if (!$result1)
			{
				die('Coud not select in database:'.mysql_error());
			}
			
			$first_row = mysql_fetch_assoc($result1);
			$second_row = mysql_fetch_assoc($result1);
			echo $first_row['nickname'];
			echo ' and ';
			echo $second_row['nickname'];
			echo '</label></div>';
			
		}
	}
	else{
	echo '<label class="headers">There are no current games.</label>';
	
	}
}

if(isset($_SESSION['user_id'], $_SESSION['nickname'], $_SESSION['role'] ))
{
echo '<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Admin</title>
   <link rel="stylesheet" href="css/main.css" >
   <link rel="stylesheet" href="css/game.css" >
    <link rel="stylesheet" href="css/game_page.css" >

</head>
<body>

    <div id="main_box">';
	 	  
		MainFrameCode();
echo '
		<aside id="left_side">	
		<img src="images/sea_battle.jpg" />
		</aside>

        <section id="right_side">';
		
		CurrentGames();

 echo '       </section>
		
		<footer id="main_footer">
			Sea Battle 2013
		</footer>
		  
   </div>
</body>
</html>';
}
else
{
 echo 'You are not authorized to access this page, please login. <br/>';
}
