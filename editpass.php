<?php
	require "pdo.php";
	session_start();
	ini_set("display_errors", 0);

	if(isset($_SESSION['failure']))
	{
		echo "<p style='color:red'>".$_SESSION['failure']."</p>";
	}
	if(isset($_GET['username']) &&strcmp("", $_SESSION['editpass']) )
	{
		echo "<h2> welcome ".$_GET['username']."</h2>";
		$username=$_GET['username'];
					$s=$pdo->query("SELECT user_id FROM users WHERE username='$username'");
					$a=$s->fetch(PDO::FETCH_ASSOC);
					foreach ($a as $key) 
					{
						$userid=$key[0];
					}
		if(isset($_POST['submit'])&&isset($_POST['pass1'])&&isset($_POST['pass2']))
		{
			if($_POST['pass1']===$_POST['pass2'])
			{
						
						$stmt=$pdo->prepare("UPDATE users SET pass=:pass WHERE user_id=$userid");
						$stmt->execute(array(
							':pass'=>$_POST['pass1']));
						$_SESSION['success']="Password changed";
						header("Location:login.php");
						return;
			}
			else
			{
				$_SESSION['failure']="passwords dont match";
			}
		}
		else if($_POST['cancel'])
		{
			$_SESSION['failure']="password change cancelled";
			header("Location:login.php");
			return;
		}
		else
		{
			$_SESSION['failure']="fill the details";
		}
	}
	else
	{
		die("error! Not authorized");
	}
?>
<!DOCTYPE html>
<html>
<head>
	
	<title>forgetpass</title>
</head>
<body>
	<form method="post">
		<p>Password:</p><input type="text" name="pass1">
		<p>Re-enter Password:</p><input type="text" name="pass2">
		<input type="submit" name="submit" value="change">
		<br/>
		<input type="submit" name="cancel" value="cancel">
	</form>
</body>
</html>
