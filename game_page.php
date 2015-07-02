<?php
require_once("include/secure_session.php");
include("include/game_frame.php");

if(isset($_SESSION['user_id'], $_SESSION['nickname'])) {
     $user_id = $_SESSION['user_id'];
     $nickname = $_SESSION['nickname'];
	 if(!isset($_SESSION['gamestart']))
	 {
	 $_SESSION['gamestart'] = time();

	}
echo '<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Game Room</title>
   <link rel="stylesheet" href="css/main.css" >
   <link rel="stylesheet" href="css/game.css" >
   <link rel="stylesheet" href="css/game_page.css" >
   <script type = "text/javascript" src = "game_page.js"></script>
   <script type = "text/javascript" src = "drag.js"></script>

	</head>
	<body onload=load()>

    <div id="main_box">';
	 	
		
		GameFrameCode();
	
echo 	'<div id="user_id"  style="display: none;" >';

echo $user_id;

echo    '</div>
		<section id="left_side">
		</section>
        <section id="right_side" >
		</section>
		 <script type = "text/javascript">
		 loadPage();
		 </script>
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