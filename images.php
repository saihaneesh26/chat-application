<?php
session_start();
require "pdo.php";
//ini_set('display_errors',0);
$stmt=$pdo->query("SELECT * FROM messages");
$res=$stmt->fetchAll();
for($i=0;$i<sizeof($res);$i++)
{
	if(strlen($res[$i]['file'])>1)
	{
		if($res[$i]['tmid']==$_SESSION['user_id'])
		{
			echo($res[$i]['fm'].": ".$res[$i]['message'].": "."<a style='color: blue;'target='_blank' href='view.php?id=".$res[$i]['message_id']."'>".$res[$i]['filename']."</a>".": ".$res[$i]['time']."<br/>");
		}
	}
}





?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	
</head>
<body>

</body>



</html>




<!--
for($i=0;$i<sizeof($res);$i++){
		echo ('<img style="height:100px;width:100px; src=data:image;base64,'.$res[$i]['image'].'>');
	}





echo ($res[$i]['fm'].":".'<img style="height:100px;width:100px;" src=data:image;base64,'.$res[$i]['image'].'>'.'<p style="font-size:10px;">'.$res[$i]['time'].'</p><br>');