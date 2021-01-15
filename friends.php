<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="icon" href="images/favicon.ico" type="image/ico" >
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>

<?php
session_start();
$time=time();
require "pdo.php";
$me=$_SESSION['user_id'];
$req="friends";
$sql="SELECT * FROM frd_req WHERE (req='$req')AND (frid='$me'OR trid='$me') ";
$stmt=$pdo->query($sql);
$res=$stmt->fetchAll();

?>
	<form method="post">
		<p style="font-size:10px;color:white;">click to chat</p>
		<?php
if(sizeof($res)==0)
{
	echo "No friends";
}

		
foreach($res as $row)
	{
		if($row['trid']==$me)
		{
		$id=$row['frid'];
		}
	else{
		$id=$row['trid'];
		}

	$s=$pdo->query("SELECT * FROM users WHERE  user_id='$id'");
	$r=$s->fetchAll();
	for($i=0;$i<sizeof($r);$i++){
	if($r[$i]['status']+10<=$time){
		$active='<p style="color:red;margin:2px;">not active</p>';	
	}
	else{
		$active='<p style="color:green;margin:2px;">active</p>';
	}
	echo '<input style="padding:2px 4px;margin:4px;outline:none;cursor:pointer; color:white;background-color: transparent;border:1px solid white;" class="copy_frds" type="submit" value='.$r[$i]['username'].'>'.'- '.$r[$i]['name'].$active.'<br>';
}

	};


?>

</form>
<div id="s_filter" style="color:black;"></div>
</body>
	

<script type="text/javascript">
	$(document).ready(function(){
		$('.copy_frds').click(function(){
	var copy_val=$(this).val();
	console.log(copy_val);
	$.ajax({url:"copy.php",method:"post",data:{copy:copy_val},dataType:"text",success:function(data){
		window.console&&console.log(data);
	}
});


	});
	});
function update_stats(){
	$.ajax({url:"friends.php",success:function(){}});

}
setInterval(function(){
	update_stats();
},10000);
</script>

</html>	
<!--
	$i=0;
foreach ($res as $row) {
	echo $row['username'].":".$row['name'].'<input type="submit" value="copy" name="copy">';

};
</form>
<form method="POST"  enctype="multipart/form-data" >
<input type="file" name="file"><input type="submit" name="submit">
</form>


php
if(isset($_POST['submit'])){
	$image_name=$_FILES['file']['name'];
	$image_data=base64_encode(file_get_contents(addslashes($_FILES['file']['tmp_name'])));
	$image_type=$_FILES['file']['type'];
	if(substr($image_type,0,5)=="image"){
	$stmt1=$pdo->query("INSERT INTO `images` VALUES('','$image_name','$image_data')");
	echo "done";
	}
	$stmt=$pdo->query("SELECT * FROM `images`");
	$res1=$stmt->fetchAll();
	for($i=0;$i<sizeof($res1);$i++){
		print_r ('<img style="height:100px;width:100px; src=data:image;base64,'.$res1[$i]['image'].'>');
	}
	
}
?>


.'<input type="submit"  value='.$a[$i].'>'
<script type="text/javascript">
	$(document).ready(function(){
		$('input').click(function(){
	var copy_val=$(this).val();
	console.log(copy_val);
	$.ajax({url:"copy.php",method:"post",data:{copy:copy_val},dataType:"text",success:function(data){
		
		window.console&&console.log(data);
		$('#s_filter').html(data);
	}
});


	});
	});

</script>







