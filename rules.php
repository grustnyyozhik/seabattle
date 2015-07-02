<?php
require_once("include/secure_session.php");
include("include/main_frame.php");
?>

<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Index</title>
   <link rel="stylesheet" href="css/main.css" />
  
</head>
<body>
   <div id="main_box">	  
		<?php
		MainFrameCode();
		?>  
        <section id="center_section">
		 <article>
            <header>       
                  <h1>SeaBattle Game Rules</h1>
            </header>
			<!--rules-->
			<p>See in Wiki!</p>
			<br />
			<center>
            <a href="https://en.wikipedia.org/wiki/Battleship_(game)"><img src="images/wikipedia-logo.png" /></a>
			</center>
			<!--end of rules-->
         </article>
        </section>	      
		<footer id="main_footer">
			Sea Battle 2013
		</footer>
		  
   </div>
</body>
</html>
