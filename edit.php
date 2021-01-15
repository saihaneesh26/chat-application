<?php
session_start();
ini_set('display_errors', 0);
if(!isset($_SESSION['edit']) || !isset($_GET['username']))
{
	unset($_SESSION['edit']);
	die('please log in to edit');
}
require("pdo.php");
$_SESSION['failure']=false;
$me=$_SESSION['user_id'];
if(isset($_POST['cancel']))
{
		$_SESSION['failure']="edit canceled.Try later";
		
		$_SESSION['pass']=true;
		header('Location:app.php');
		return;
}

$st=$pdo->query("SELECT * FROM users");
$re=$st->fetchAll();
for($i=0;$i<sizeof($re);$i++){
	if($re[$i]['user_id']==$me){
	$name=$re[$i]['name'];
	$username=$re[$i]['username'];
	$passw=$re[$i]['pass'];
	$dp=($re[$i]['dp']);
}
}
if(isset($_POST['dp']))
{
$image_data=base64_encode(file_get_contents(($_FILES['dp']['tmp_name'])));
}
else
{
	$image_data=$dp;
}
if(isset($_POST['edit']))
{
	if(isset($_POST['name'])&&isset($_POST['username']))
	{
		if($_POST['pass']==$_POST['pass1'] && strlen($_POST['pass'])>1)
		{
			
			$sql=("UPDATE users SET name=:name,username=:username,pass=:passwordd,dp=:dp WHERE user_id='$me';");
			$stmt=$pdo->prepare($sql);
			$stmt->execute(array(
				':name'=>$_POST['name'],
				':username'=>$_POST['username'],
				':passwordd'=>$_POST['pass'],
				':dp'=>$image_data));
			$_SESSION['success']="Successfully Edited Login again";
			$_SESSION['name']=$_POST['name'];
			$_SESSION['pass']=true;
			header('Location:login.php');
			return;
		}
		else
		{
			$_SESSION['failure']="Password Does not match.Try again";
			
		}
	}
	if(!isset($_POST['name']) || !isset($_POST['username'])|| strlen($_POST['name'])<1)
	{
		$_SESSION['failure']="enter the data";
	}
	
}



?>


<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="favicon1.ico" type="image/ico" >
	<title>edit your profile</title>
	<link rel="stylesheet" type="text/css" href="edit.css">
</head>
<body>
	<h3>Re-enter your details with updates info.</h3>
	<?php
		if(isset($_SESSION['failure']))
		{
			echo '<p style="color:red;">';
			echo htmlentities($_SESSION['failure']);
			echo '</p>';
			unset($_SESSION['failure']);
		}
		if(isset($_POST['success']))
		{
			echo '<p style="color:green">';
			echo htmlentities($_SESSION['success']);
			echo "</p>";
			unset($_SESSION['success']);
		}



	?>
	<div id="table">
	<form method="post" enctype="multipart/form-data">
		<p>Name:</p><input type="text" name="name" placeholder="name" value="<?php echo $_SESSION['name'];?>">
		<p>Username:</p><input type="text" name="username" placeholder="Username" value="<?php echo $_SESSION['username'] ; ?>">
		<p>Password:</p><input type="Password" name="pass" placeholder="Password" value="<?php echo $passw; ?>">
		<p>Re-enter Password:</p><input type="Password" name="pass1" placeholder="Re-enter password"value="<?php echo $passw; ?>">
		<p>DP</p><input type="file" name="dp" value="<?php echo($dp) ?>">
		<br>
		<input type="submit" name="edit" value="Submit">
		<br>
		<input type="submit" name="cancel" value="Cancel">
	</form>
</div>
</body>
<footer style="font-size:7px;color:lightgray">IMAGE IS TAKEN FROM GOOGLE</footer>
</html>
<!---
	if(isset($_POST['dp'])){
		$image_data=base64_encode(file_get_contents($_FILES['dp']['tmp_name']));
		$stmt=$pdo->query("SELECT dp FROM users WHERE username='$me';");
		if(strlen($stmt)>1){
			$stmt1=$pdo->prepare("UPDATE users SET dp=:dp WHERE username='$me'");
			$stmt1->execute(array(
				':dp'=>$image_data));
		}
		else{
			$stmt1=$pdo->prepare("INSERT INTO users(dp) VALUES(:dp)");
			$stmt1->execute(array(
				':dp'=>$image_data
			));
		}
		
	}