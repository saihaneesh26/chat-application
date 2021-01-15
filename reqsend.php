<?php

require("pdo.php");
session_start();


if(isset($_POST['submit'])){
	$reqid=array($_POST['request']);
	for($i=0;$i<sizeof($reqid);$i++)
	{
		$a=$reqid[$i][0];
		$stm=$pdo->prepare("UPDATE frd_req SET req=:req WHERE req_id=:req_id");
		$stm->execute(array(':req'=>"friends",':req_id'=>$a));	
		$_SESSION['success']="accepted";
	}
	header('Location:app.php?username='.$_SESSION['username']);
	return;
}

