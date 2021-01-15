<?php
require "pdo.php";
ini_set('display_errors',0);
session_start();
$s=$pdo->query("SELECT * FROM users ");
$r=$s->fetchAll();
foreach($r as $ro){
 if($ro['username']==$_POST['s_filter']){
 	$sfid=$ro['user_id'];
 }
};


$stmt=$pdo->query("SELECT * FROM messages ");
$res=$stmt->fetchAll();
$no=0;
foreach($res as $row){
	if(($row['tmid']==$_SESSION['user_id']&&$row['fmid']==$sfid)||($row['fmid']==$_SESSION['user_id']&&$row['tmid']==$sfid))
	{
		if($row['fmid']==$_SESSION['user_id']&&$row['tmid']==$sfid){
echo '<p style="border:1px solid green;color:black;background-color:white;">'.$row['fm'].":".$row['message']." : ".$row['time'].'</p>';
		}
		else{
			echo '<p style="border:1px solid green;color:white;background-color:black;">'.$row['fm'].":".$row['message']." : ".$row['time'].'</p>';
		}
		
		$no=1;
	}	
	
};
if($no==0)
{
	echo "no messages from ".$_POST['s_filter'];
}
else{
	if(!isset($row))
{
	echo("No Messages");
}
}


?>
<!---


WHERE fm like '%".$_POST['s_filter']."%';

$stmt1=$pdo->query("SELECT * FROM messages;");
$res1=$stmt1->fetchAll();
foreach($res1 as $row1){
	if(($row1['fm'])==$_SESSION['username']&&$row1['tm']==$_POST['s_filter']){
	echo '<p style="border:1px solid blue;color:black;background-color:white;">'.$row1['fm'].":".$row1['message'].'</p>';
}
}