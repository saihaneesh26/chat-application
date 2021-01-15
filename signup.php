<?php
session_start();
ini_set('display_errors', 0);
//import pdo
require_once("pdo.php");
if(isset($_POST['cancel']))
{
	unset($_SESSION['success']);
	header('Location:login.php');
	return;
}
if(isset($_POST['login']))
{
	header('location:login.php');
	return;
}
$flag1=0;
if(strlen($_POST['username'])>1&&strlen($_POST['pass'])>1&&strlen($_POST['name'])>1)
{
	$flag1=1;
}
else
{
	$_SESSION['failure1']="please enter the data";
}
if($flag1==1)
{
	$flag=1;
	$sqll=("SELECT * FROM users;");
	$stmtt=$pdo->query($sqll);
	$res=$stmtt->fetchAll();
	foreach($res as $row)
	{
		if($row['username']==$_POST['username'])
		{
			$_SESSION['failure']="username already exists";
			$flag=0;

		}
	};
	if($flag==1)
	{
		if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
		if($_POST['pass']==$_POST['pass1'])
		{
			$email=$_POST['email'];
			$image_data=base64_encode(file_get_contents($_FILES['dp']['tmp_name']));
			$sql=("INSERT INTO users (name,username,pass,dp,email) VALUES (:name,:username,:passwordd,:dp,:email);");
			$stmt=$pdo->prepare($sql);
			$stmt->execute(array(
				':name'=>$_POST['name'],
				':username'=>$_POST['username'],
				':passwordd'=>$_POST['pass'],
				':dp'=>$image_data,
				':email'=>$email));
			$_SESSION['success']="Successfully signed up";
			header('Location:login.php');
			return;
		}
		else
		{
			$_SESSION['failure']="Password Does not match.Try again";
			
		}	
	}
	else{
		$_SESSION['failure']='username already exists';
	}
}
else{
	$_SESSION['failure']="Email not entered";
}	
}


//cancel
if(isset($_POST['signup']))
{
	header('location:signup.php');
	return;
}


?>
<!DOCTYPE html>
<html>
<head><title>signup page</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
	<h5 style="color:red;">FOR SIGNING UP PLEASE USE GENERAL NAMES AND PASSWORDS.PLEASE DONT USE THE PASSWORDS USED FOR YOUR PERSONAL ACCOUNTS.</h5>
<div class="form">
<?php
if(isset($_SESSION['failure']))
{
	echo ('<p style="color:red;">'.htmlentities($_SESSION['failure'])."</p>");
	unset($_SESSION['failure']);
}
if(isset($_SESSION['failure1']))
{
	echo ('<p style="color:red;">'.htmlentities($_SESSION['failure1'])."</p>");
	unset($_SESSION['failure1']);
}
?>
<form method="POST" enctype="multipart/form-data">
<input type="submit" name="login" value="Login" id="top"> <input type="submit" name="signup" value="Signup" id="top1"></form>
<form method="POST">
	<img id="icon" src="images/icon.jpg">
<p>Name:</p><input type="text" name="name" autofocus>
<p>Username:</p><input type="text" name="username">
<p>Email:</p><input type="email" name="email">
<p>Password:</p><input type="password" name="pass">
<p>Re-Enter Password</p><input type="password" name="pass1">
<p>DP:<span style="font-size:10px;">file less than 1MB</span></p><input type="file" name="dp">
<input type="submit" name="signup" value="Signup"> <input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
<footer style="font-size:7px;position: bottom;color:lightgray;">IMAGE IS TAKEN FROM GOOGLE</footer>
</html>

