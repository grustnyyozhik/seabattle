<?php
require_once("include/secure_session.php");
include("include/game_frame.php");

if(isset($_SESSION['user_id'], $_SESSION['nickname'])) {
     $user_id = $_SESSION['user_id'];
     $nickname = $_SESSION['nickname'];

echo '<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Waiting Room</title>
   <link rel="stylesheet" href="css/main.css" >
   <link rel="stylesheet" href="css/game.css" >
   <script type="text/javascript" src="free_players.js"></script>
	<script type = "text/javascript" src="wait_room_scripts/help_scripts.js"></script>

</head>
<body onload=process()>

    <div id="main_box">';
		GameFrameCode();
		
	echo '
		<aside id="left_side">	
		<img src="images/sea_battle.jpg" />
		</aside>
        <section id="right_side">
		<div id = "user_message" class="warning">
		<div id="user_id" style="display: none;"  >';
		
		echo "$user_id";
		
		echo '</div>
		Hello, 
		<label id="user_nickname">';
		
		echo "$nickname";
		
		echo '</label>
		!
		<br><br>
		<div id = "server_answer">
		<script type="text/javascript">
		chooseDirection();
		</script>
		</div>
	
		
        </section>
  
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

?>