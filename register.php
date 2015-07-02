<?php
require_once("include/secure_session.php");
include("include/new_connect.php");
require_once("include/main_frame.php");

if(isset($_POST['submit']))
{
$error=array();

//username
if(empty($_POST['username']))
{
$error[] = "Enter the username. ";
}
else if(ctype_alnum($_POST['username']))
{
$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
}
else{
$error[] = "Username includes only letters and numbers. ";
}
//nickname
if(empty($_POST['nickname']))
{
$error[] = "Enter nicknmae. ";
}
else if(ctype_alnum($_POST['nickname']))
{
$nickname = htmlspecialchars($_POST['nickname'], ENT_QUOTES, 'UTF-8');
}
else{
$error[] = "Nickname includes only letters and numbers. ";
}
//password
if(empty($_POST['password']))
{
$error[] = "Enter password. ";
}
else if(preg_match ("((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20}) " , $_POST['password']))
{
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
}
else
{
$error[] = "Password is weak. ";
}
if(empty($error))
{
//prepare for database  $password $nickname $ username

if (!($stmt = $mysqli->prepare("SELECT username FROM users WHERE nickname=? OR username=?"))) {
     echo "Prepare failed: (" . $mysql->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param('ss',$nickname, $username)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->execute();
$stmt->bind_result($res);
$ans = $stmt->fetch();
$stmt->close();
if (!$ans)
{
//not found
if (!($stmt = $mysqli->prepare("INSERT INTO users(user_id, role, username, password, nickname) VALUES('', 'user', ?, ?, ?)"))) {
     echo "Prepare failed: (" . $mysql->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param('sss',$username, $password, $nickname)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->close();
header('Location:prompt.php?x=1');
}
else
{
$stmt->close();
header('Location:prompt.php?x=2');
}

}
else
{
$error_message = '<span class="error">';
foreach($error as $key => $values)
{
$error_message .= $values ;
$error_message .= '<br><br>' ;
}
$error_message .= '</span ><br>';
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Register</title>
   <link rel="stylesheet" href="css/main.css">
   <link rel="stylesheet" href="css/forms.css">
   <link rel="stylesheet" href="css/register.css">
	</head>
<body>
   <div id="main_box">
	 	  
		<?php MainFrameCode();?>
		<aside id="left_side">	
			<img src="images/sea_battle.jpg" />
		</aside>

	      
        <section id="right_side">
		<form id="generalform" class="container" method="post" action="">
		<h3 align="center">Register</h3>
		
		<?php if (isset($error_message)) {echo $error_message;}?>
		
		<div class="field">
			<label for="username">Username:</label>
			<input  type="text" class="input" id="username" placeholder="Max 30 letters or numbers.." name="username" maxlength="30"/>
		</div>
		
		<div class="field">
				<label for="nickname">Nickname:</label>
				<input  type="text" class="input" placeholder="Max 30 letters or numbers.." id="nickname" name="nickname" maxlength="30"/>
		</div>
		
		<div class="field">
			<label for="password">Password:</label>
			<input  type="password" class="input" placeholder="Max 30 signs.." id="password" name="password" maxlength="30"/>
		</div>
		
		<input type="submit" name="submit" id="submit" class="button" value="Submit"\>
		
		</form>
        </section>
  
		<footer id="main_footer">
			Sea Battle 2013
		</footer>
		  
   </div>
</body>
</html>