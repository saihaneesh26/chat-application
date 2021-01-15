<?php
ini_set('display_errors',0);
session_start();
header("Context-Type:application/text");
$_SESSION['chats']=array();
require("pdo.php");
$stmt=$pdo->query("SELECT * FROM messages");
$result=$stmt->fetchAll();
$r=array();
foreach($result as $row){
	if($row['tmid']==$_SESSION['user_id'])
	{
		$a=array(($row['fm']),":  ",($row['message']),('<p style="font-size:10px">'.$row['time'].'</p>'));
		for($i=0;$i<sizeof($a);$i++){
			echo $a[$i];
		}	
	
	}
};
?>

