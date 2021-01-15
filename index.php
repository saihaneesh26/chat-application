<?php
session_start();
ini_set('display_errors',0);
//import pdo
require("pdo.php");
//cancel
$_SESSION['editpass']="";
if(isset($_POST['cancel'])){
	header('Location:login.php');
	return;
}
//forget password
if(isset($_POST['username'])&&isset($_POST['forgetpass']))
{
	$me=$_POST['username'];
	$email='';
	$statement=$pdo->query("SELECT * FROM users");
	$row=$statement->fetchAll();
	foreach ($row as $key) {
	if($key['username']==$me)
	{
		$email=$key['email'];
	}
}


/*

$mail='haneesh.inaguri@gmail.com';
$subject = "My subject";
$txt = "Hello world!";
$headers = 'From: ' .$mail . "\r\n". 
  'Reply-To: ' . $mail. "\r\n" . 
  'X-Mailer: PHP/' . phpversion();
mail($mail,$subject,$message,$headers);


	$me=$_POST['username'];
$statement=$pdo->query("SELECT * FROM users WHERE username=$me");
$row=$statement->fetch(PDO::FETCH_ASSOC);
$eemail=$row['email'];
$email=$eemail;
$hash=md5($me.time());
$_SESSION['time_pass']=time();
$_SESSION['forget_pass']=$hash;
$_SESSION['me']=$me;
$subject="temp login link";
$headers = 'From: designprjct19@gmail.com' . "\r\n". 
  'Reply-To: designprjct19@gmail.com' . "\r\n" . 
  'X-Mailer: PHP/' . phpversion();
$message= "<a href='http://localhost/project/forgetpass.php?key=$hash' >Click here for temp login</a>";

*/

}

//if entered username or not
if(isset($_POST['username'])&&isset($_POST['pass'])){
	//check wthr username mathes pass
	$stmt=$pdo->query("SELECT * FROM users");
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		if($_POST['username']==$row['username']&&$_POST['pass']==$row['pass'])
	{
		$_SESSION['last_login_time']=time();
		$_SESSION['username']=$row['username'];
		$me=$_SESSION['username'];
		
		$_SESSION['user_id']=$row['user_id'];
		$_SESSION['username']=$row['username'];
		$_SESSION['name']=$row['name'];
		$_SESSION['pass']=true;
		$_SESSION['success']="logged in";
		$_SESSION['status']="active";
		
		header("location:app.php?username= ".urlencode($_POST['username']));
		return;
	}
	if($_POST['username']==$row['username']&&$_POST['pass']!=$row['pass']){
		$_SESSION['failure']="incorrect password";
	}


	}
	
}
else{
	$_SESSION['failure']="enter username and password";
}
if(isset($_POST['login']))
{
	header('location:login.php');
	return;
}
if(isset($_POST['signup']))
{
	unset($_SESSION['failure']);
	header('location:signup.php');
	return;
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="jquery.min.js"></script>
</head>
<body>
	<div class="form">
		<img id="icon" type="image" src="images/favicon.jpg"/>
	<?php
	//failure and success flash
	if(isset($_SESSION['failure'])){
		echo ('<p style="color:red;">'.htmlentities($_SESSION['failure'])."</p>");
		unset($_SESSION['failure']);
	}
	if(isset($_SESSION['success'])){
		echo ('<p style="color:green;">'.htmlentities($_SESSION['success'])."</p>");
		unset($_SESSION['success']);
	}
	?>
<form method="post">
	<input type="submit" name="login" value="Login" id="top1"> <input type="submit" name="signup" value="Signup" id="top">
</form>
		<form method="POST">
			<p>Username:</p><input type="text" name="username" class="cu" placeholder="username" autofocus>
			<p>Password:</p><input type="Password" class="cu" name="pass" placeholder="password">
			<br>
			<input type="submit" name="login" value="LOGIN">
			<input type="submit" name="cancel" value="CANCEL">
			
		</form>
		
		<a href="signup.php">CREATE ACCOUNT</a>
	</div>
</body>
<footer style="font-size:7px;color:lightgray">IMAGE IS TAKEN FROM GOOGLE</footer>
</html>
