<?php
require("pdo.php");
session_start();

$id=isset($_GET['id'])?$_GET['id']:" ";
$stmt=$pdo->prepare("SELECT * FROM messages WHERE message_id=:id AND tmid=:to");
$stmt->execute([':id'=>$id,':to'=>$_SESSION['user_id']]);
$row=$stmt->fetch(PDO::FETCH_ASSOC);

header ('content-type:'.$row['mime']);
echo base64_decode($row['file']);


?>
<!DOCTYPE html>
<html>
<head>
	<title>View</title>
</head>
<body>

</body>
</html>
<!--
	else{
echo('<iframe width="200" height="200" src="data:'.$row['mime'].';base64,'.$row['file'].'" type='.$row['mime'].' /> ');
}
