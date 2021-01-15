<?php
require "pdo.php";
ini_set('display_errors', 0);
session_start();
if(!isset($_GET['key'])){
	die("not reachable");
}
else{
	$key=$_GET['key'];
	$time=time();
	if($key==$_SESSION['forget_pass'] && $time<=$_SESSION['time_pass']+60000)
	{
		$_SESSION['edit']=true;
		$_SESSION['editpass']="confirmed";
		header("Location:editpass.php?username=".$_SESSION['username']);
		return;
	}
	else{
		echo("ERROR!! please try later");
	}
}
?>
<!DOCTYPE html>
<html>
<head><title>forget password</title>
</head>
<body>

</body>
</html>
