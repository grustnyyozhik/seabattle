<?php
require_once("include/secure_session.php");
include("include/new_connect.php");
include("include/main_frame.php");

if(isset($_SESSION['user_id'], $_SESSION['nickname'], $_SESSION['role'] ))
{
	$user_id = $_SESSION['user_id'];
	$nickname = $_SESSION['nickname'];
	$role = $_SESSION['role'];
	if($role=='user')
			{	
				if (!($stmt = $mysqli->prepare("INSERT INTO active_users(user_id) VALUES(?)"))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				if (!$stmt->bind_param('i',$user_id)) {
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				$stmt->execute();
				$stmt->close();
				header('Location:waiting_room.php');
				
			}
			else if ($role=='admin')
			{	
				header('Location:admin.php');
			}
}
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

//password
	if(empty($_POST['password']))
	{
		$error[] = "Enter password. ";
	}
	else
	{
		$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
	}

	if(empty($error))
	{
	//check in database
	
	if (!($stmt = $mysqli->prepare("SELECT user_id, nickname, role FROM users WHERE password=? AND username=?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$stmt->bind_param('ss',$password, $username)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->execute();
	$stmt->bind_result($user_id, $nickname, $role);
	
		
		if ($stmt->fetch())//if user exists
		{	
			$_SESSION['user_id'] = $user_id;
			$_SESSION['nickname'] = $nickname;
			$_SESSION['role'] = $role;
			$stmt->close();
			if($role=='user')
			{	
				if (!($stmt = $mysqli->prepare("INSERT INTO active_users(user_id) VALUES(?)"))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				if (!$stmt->bind_param('i',$user_id)) {
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				$stmt->execute();
				$stmt->close();
				header('Location:waiting_room.php');
				
			}
			else if ($role=='admin')
			{	
				header('Location:admin.php');
			}
		}
		else
		{
			$stmt->close();
			$error_message = '<span class="error">Username or password is incorrect</span><br><br>';
		}

	}
	else
	{
		$error_message = '<span class="error">';
		foreach($error as $key => $values)
		{
			$error_message .= $values ;
		}
			$error_message .= '</span ><br><br>';
	}
}
?>

<!doctype html>
<html lang="en">
<head>
   <title>Login</title>
   <link rel="stylesheet" href="css/main.css" >
   <link rel="stylesheet" href="css/forms.css" >
     <link rel="stylesheet" href="css/login.css" >
	</head>
<body>
   <div id="main_box">
	 	  
		<?php
		MainFrameCode();
		?>
		
		<aside id="left_side">	
		<img src="images/sea_battle.jpg" />
		</aside>

	      
        <section id="right_side">
		
		<form id="generalform" class="container" method="post" action="">
		<h3 align="center">Login</h3>
		<?php if (isset($error_message)) {echo $error_message;}?>
		<div class="field">
		<label for="username">Username:</label>
		<input  type="text" class="input" id="username" name="username"/>
		</div>
		<div class="field">
		<label for="password">Password:</label>
		<input  type="password" class="input" id="password" name="password"/>
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