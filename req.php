<?php
require ("pdo.php");
session_start();
ini_set('display_errors',0);
header("context-Type:application/text");
$me=$_SESSION['user_id'];

$stmt=$pdo->query("SELECT * FROM frd_req WHERE trid='$me' AND req='sent';");
$res=$stmt->fetchAll();
if(sizeof($res)>=1){
	echo "<form method='post'";
	foreach($res as $row)
{
	if($row['trid']==$_SESSION['user_id']&&$row['req']=="sent")
	{
		$trid=$row['trid'];
		$dp=$pdo->query("SELECT dp FROM users WHERE user_id='$trid'");
		$dp=$dp->fetch(PDO::FETCH_ASSOC);
		echo ('action="reqsend.php"><input type="checkbox" name="request[]" value='.$row['req_id'].'>'.'<img style="height:50px;width:50px;" src=data:image;base64,'.$dp['dp'].'>'.$row['fm']);
		
	}
};
echo '<input type="submit" name="submit" value="accept">';
echo '</br></form>';
}

else{
	echo "no requests";
}






?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>

</body>

</html>

