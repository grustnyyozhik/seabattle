<?php
session_start();
include("include/connect.php");
include("include/main_frame.php");
$index = $_GET['x'];

function BuildMessage($index)
{
if($index==1)
{
$message = "<div class=\"success\">Registration passed sucessfully.</div>";
}
else if ($index==2)
{
$message = "<div class = \"warning\">Registration has failed. Email or username are in use.</div>";
}
echo $message;
}
?>

<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Prompt</title>
   <link rel="stylesheet" href="css/main.css" >
   <link rel="stylesheet" href="css/prompt.css" >
  
</head>
<body>
   <div id="main_box">	  
		<?php
		MainFrameCode();
		?>  
        <section id="center_section">
		<?php BuildMessage($index);?>
        </section>	      
		<footer id="main_footer">
			Sea Battle 2013
		</footer>
		  
   </div>
</body>
</html>
