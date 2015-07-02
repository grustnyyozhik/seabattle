<?php
function MainFrameCode()
{
echo "
<header id=\"top_header\">
			<a href=\"index.php\"><img src=\"images/logo.png\" /></a>
		</header>
		  
		<div id=\"top_nav_bar\">
			<ul>
				<li><a class=\"topLinks\" href=\"index.php\">Home</a></li>
				<li><a class=\"topLinks\" href=\"rules.php\">Game Rules</a></li>
				<li><a class=\"topLinks\" href=\"login.php\">Play</a></li>";
echo "
			</ul>
		</div>
		
		<div id=\"rightAlign\">
";
		RegistrationCode();
echo "</div>

";

}

function RegistrationCode()
{
if(!isset($_SESSION['user_id'])){
	echo "
<a href=\"register.php\">Register</a> | <a href=\"login.php\">Log In</a>
";
}
else{
$temp = $_SESSION['user_id'];
echo "
<a href=\"logout.php\">Log Out</a>
";

}
}
?>