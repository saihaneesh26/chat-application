<?php
require("pdo.php");
//ini_set('display_errors',0);
session_start();
$stmt=$pdo->query("SELECT * FROM users WHERE name LIKE '%".$_POST['search']."%'");
$result=$stmt->fetchAll();
foreach ($result as $row) {
if(isset($row['username'])){
	echo ('<form method="post">');
	echo ('<input type="checkbox" name="search[]" value='.$row['user_id'].'>'.'<img style="height:50px;width:50px;" src=data:image;base64,'.$row['dp'].'>'.$row['username'].":".$row['name'].'<br>');
}
};
if(sizeof($result)>=1){
echo '<input type="submit" name="request" value="request">';
	echo '</form>';
}

if(isset($_POST['request'])){
	$array=$_POST['search'];
	for($i=0;$i<sizeof($array);$i++)
	{
		$trid=$array[$i][0];

		$frid=$_SESSION['user_id'];
		$fm=$_SESSION['username'];
		$req="sent";
		$stm=$pdo->query("SELECT * FROM frd_req");
		$res=$stm->fetchAll();
		$flag=0;
		$tm="";
		foreach($res as $row)
		{
			if($row['frid']==$frid && $row['trid']==$trid)
			{
				$flag=1;
			}
		}	
		if($flag==1)
		{
			$_SESSION['failure']="request sent already";
		}
		else{
			$st=$pdo->prepare("INSERT INTO frd_req(frid,trid,fm,tm,req) VALUES(:frid,:trid,:fm,:tm,:req)");
			$st->execute(array(
				':frid'=>$frid,
				':trid'=>$trid,
				':fm'=>$fm,
				':tm'=>$tm,
				':req'=>$req));
			$_SESSION['success']="request sent";
		}

	}


}




if(!isset($row))
{
	echo("No Users found....");
	echo("Please be more specific");
}




?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>

</body>
</html>

<!---
	if(isset($_POST['send']))
{


	if(strlen($_POST['to'])<1)
	{
		$_SESSION['failure']="enter username";
		
	}
	else
	{

	$st=$pdo->query("SELECT * FROM users");
	$re=$st->fetchAll();
	$flag=0;
	foreach($re as $ro)
		{
			if($ro['username']==$_POST['to'])
				{
					$flag=1;
					$trid=$ro['user_id'];
					$tm=$ro['username'];
					$frid=$_SESSION['user_id'];
					$fm=$_SESSION['username'];
					$req="sent";
				}

			if($flag==1)
				{
					$s=$pdo->prepare("INSERT INTO frd_req(frid,trid,req,fm,tm) VALUES(:frid,:trid,:req,:fm,:tm);");
					$s->execute(array(
						':frid'=>$frid,
						':trid'=>$trid,
						':req'=>$req,
						':fm'=>$fm,
						':tm'=>$tm));
					$_SESSION['success']="sent";
				}

		};
		if($flag==0)
		{
			$_SESSION['failure']="username not found";
			
		}


	}

}


