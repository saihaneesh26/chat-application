<?php
session_start();
ini_set('display_errors',0);
require("pdo.php");
if(!isset($_SESSION['username']))
{
	die(header('Location:login.php'));
}
$time=time();

if(isset($_POST['edit']))
{
	$_SESSION['edit']=true;
	header('location:edit.php?username= '.urlencode($_SESSION['username']));
	return;
}
if(isset($_SESSION['copy'])){
	$copy=$_SESSION['copy'];
}
$me=$_SESSION['username'];

//send msg
if(isset($_POST['send']))
{
	if(isset($_POST['to'])&&strlen($_POST['to'])>1)
	{
		$stmt=$pdo->query("SELECT * FROM users");
		$row=$stmt->fetchAll();
		foreach($row as $res)
		{
			if($res['username']==$me){$fmid=$res['user_id'];}
			if($res['username']==$_POST['to']){$tmid=$res['user_id'];}
		};

			if(isset($fmid)&&isset($tmid))
			{
				
				
				$file_data=base64_encode(file_get_contents($_FILES['file']['tmp_name']));			
				$file_name=$_FILES['file']['name'];
				$type=$_FILES['file']['type'];
				$stmt1=$pdo->prepare("INSERT INTO messages(fm,tm,message,file,fmid,tmid,mime,filename) VALUES (:fm,:tm,:message,:file,:fmid,:tmid,:mime,:filename);");
				$stmt1->execute(array(
					':fm'=>$_SESSION['username'],
					':tm'=>$_POST['to'],
					':message'=>$_POST['msg'],
					':file'=>$file_data,
					':fmid'=>$fmid,
					':tmid'=>$tmid,
					':mime'=>$type,
					':filename'=>$file_name));
				$_SESSION['success']="message sent";
				unset($_SESSION['failure']);
			
			}
			else{
				$_SESSION['failure']="invalid username";
			}	
					
		


	}
	else
		{
			$_SESSION['failure']="enter username";
		}

}



//logout
if(isset($_POST['logout']))
{
	session_destroy();
	header('location:login.php');
	return;
}
if(isset($_POST['refresh']))
{
	?> <script type="text/javascript">location.reload();return;</script>  <?php 
}
?>







<!DOCTYPE html>
<html>
<head>
	
	<link rel="icon" href="images/favicon.ico" type="image/ico" >
	<title>ChAtOtAlKZ</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body id="body">

	<span id="name">


		<?php 
		$user_id=$_SESSION['user_id'];
$stm=$pdo->query("SELECT * FROM users");
$res=$stm->fetchAll();
for($i=0;$i<sizeof($res);$i++)
{
		if($res[$i]['username']==$_SESSION['username'])
		{
			if(strlen($res[$i]['dp'])>1)
			{

			echo ('<img class="dp" style="height:100px;width:100px;"  src=data:image;base64,'.$res[$i]['dp'].'><br>'.'<p id="dp-name" class="dp" >'.htmlentities($_SESSION['name']).'</p>'.'<br>');


			}
		else{
				echo '<p class="dp">NO DP</p><br>'.'<p class="dp" >'.htmlentities($_SESSION['name']).'</p>';
			}
		}
}
	 ?>
	 
<span id="dp-logo">ChAtOtAlKZ</span>
	<nav class="slide">
		<a href="#" id="btn-open" onclick="openslide()">
			<svg width="30" height="30">
			<path d="M0,5 30,5" stroke="white" stroke-width="5"/>
			<path d="M0,14 30,14" stroke="white" stroke-width="5"/>
			<path d="M0,23 30,23" stroke="white" stroke-width="5"/>	
			</svg></a>
	</nav>
</span>
	<div class="bar">
	<span id="logo">ChAtOtAlKZ</span><form method="POST">
<input type="submit" name="edit" value="Edit Profile">   <input type="submit" name="logout" value="Logout">   <input type="submit" name="refresh"  value="Refresh"> <input type="text" name="search" id="search" placeholder="search"> <a  id="navreq" href="#" ondblClick="reqclose()" onClick="req()">requests</a> <a href="#" onClick="friends()" ondblclick="friends_close()" id="friends-btn">friends</a>
</form></div>
<div id="slidebar">
		<a href="#" id="btn-close" onClick="closeslide()">&times;</a><form method="POST">
			<li><span id="logo1">ChAtOtAlKZ</span></li>
		<li><input type="submit" name="edit" value="Edit Profile"></li> <li> <input type="submit" name="logout" value="Logout"></li><li><input type="submit" name="refresh" value="Refresh"></li><li><a href="#" id="req" onClick="req()" ondblclick="reqclose()">requests</a></li></form>
	</div>
<div class="s_result"></div>
<div id="req-div">
</div>
<div id="friends"></div>
<div id="send">
	<?php
	if(isset($_SESSION['failure']))
	{
		echo '<p style="color:red;">'.$_SESSION['failure']."</p>";
		unset($_SESSION['failure']);
	}
	if(isset($_SESSION['success']))
	{
		echo '<p style="color:green">'."message sent"."</p>";
		($_SESSION['success']="");
	}
	?>

<h3>Message here:</h3>
<form method="post" enctype="multipart/form-data" >
	<p>TO:</p><input type="text" name="to" placeholder="username of reciever" size="40" value="<?php echo $copy; ?>">
	<p>Message</p><textarea type="text" name="msg"></textarea>
	<br>
	<br>
	

<p>send files:</p>
<input type="file" name="file">
<br/>
<input type="submit" name="send" value="Send">
	</form>
</div>
<h2 style="color:white; background-color:black; width:190px;padding:2px;opacity:0.78;">YOUR MESSAGES:</h2>
<form method="POST">
<a href="#" id="update_mode" onclick="update_mode();">inbox</a>
<a href="#" id="filter_mode" onclick="filter_mode();">filter</a>
<a href="#" id="image_mode" onclick="image_mode()">files</a>
<input type="text" name="s_filter" placeholder="filter" id="s_filter" method="post" value="<?php if(isset($copy)){ echo $copy;  }?>">
<a href="#" id="copy_fill" onclick="copy_fill()">filter the chat</a>
</form>

<div id="message_inbox">
	<img src="images/spinner2.gif" style="opacity:78%;background-color:transparent;" alt="Loading....">
	<p>No messages.</p>
</div>
<div id="message_filter">
	<img src="images/spinner2.gif" style="opacity:78%;background-color:transparent;" alt="Loading....">
	<p>Please enter the name in filter.</p>
</div>
<div id="image_inbox">
	<img src="images/spinner2.gif" style="opacity:78%;background-color:transparent;" alt="Loading....">
	<p>No images</p>
	
</div>
<div id="chat_filter">
	<img src="images/spinner2.gif" style=" height:50px;opacity:78%;background-color:transparent;" alt="Loading....">
	<p>No messages</p>
</div>

<script type="text/javascript">
document.getElementById('message_filter').style.width="0px";
document.getElementById('message_inbox').style.width="0px";
	function update(){
		
		window.console&&console.log('requesting');
		$.ajax({url:"data.php",dataType:"text",success:function(data){
			window.console&&console.log("recieved");
			//window.console&&console.log(data);
			$('#message_inbox').empty();

			$('#message_inbox').append(data);	
		}
	});
		
	}
	
</script>
<script type="text/javascript">
//screen off logout
function stats_update(){
$.ajax({url:"update_frds.php",success:function(){}});

}
setInterval(function(){stats_update();},5000);
function filter()
{
	$('#s_filter').keyup(function(){
	var text1=$('#s_filter').val();
	if(text1!=''){
		window.console&&console.log(text1);
		window.console&&console.log('filtering');
		$.ajax({url:"filter.php",data:{s_filter:text1},method:"post",dataType:"text",success:function(data)
			{
				//window.console&&console.log(data);
				window.console&&console.log("filtered");
				$('#message_filter').empty();
				$('#message_filter').append(data);
			}

		});
	}

	else{
		text1="";
		$('#message_filter').empty();
		$('#message_filter').append("no messages");
	}
	
});



};
function friends(){
	document.getElementById('friends').style.width="auto";
	document.getElementById('friends').style.height="84%";
	document.getElementById('friends').style.transition="0.6s";
	document.getElementById('friends').style.minWidth="200px";
	document.getElementById('friends').style.position="absolute";
	document.getElementById('friends').style.display="inline-block";
	document.getElementById('friends').style.backgroundColor="black";
	$.ajax({url:"friends.php",dataType:"text",method:"post",success:function(data){
		$('#friends').empty();
		$('#friends').append(data);
	}
});
	

}



function copy_fill(){
	 var copy='<?php echo $copy;?>';
	 	$('#s_filter').val()=copy;
	var text1=$('#s_filter').val();
document.getElementById('message_inbox').style.width="0px";
document.getElementById('message_inbox').style.height="0px";
document.getElementById('message_inbox').style.marginLeft="0px";
document.getElementById('message_filter').style.width="0px";
document.getElementById('message_filter').style.marginLeft="0px";
document.getElementById('image_inbox').style.width='0px';
document.getElementById('image_inbox').style.height='0px';
document.getElementById('message_filter').style.height='0px';
		document.getElementById('image_inbox').style.marginLeft='0px';
		document.getElementById('chat_filter').style.height='';
		document.getElementById('chat_filter').style.width='100%';
	 function copy_update() {

	if(text1!=''){
		window.console&&console.log(text1);
		window.console&&console.log('filtering');
		$.ajax({url:"filter.php",data:{s_filter:text1},method:"post",dataType:"text",success:function(data)
			{
				//window.console&&console.log(data);
				window.console&&console.log("filtered");
				$('#chat_filter').empty();
				$('#chat_filter').append(data);
			}

		});
	}

	else{
		text1="";
		$('#chat_filter').empty();
		$('#chat_filter').append("no messages");
	}

}
setInterval(function(){
console.log("not active");
copy_update();

},3000);




}


function friends_close(){
	document.getElementById('friends').style.width="0px";
	document.getElementById('friends').style.height="0px";
	document.getElementById('friends').style.display="none";



}



function update_mode(){
	document.getElementById('message_filter').style.width="0px";
	document.getElementById('message_filter').style.marginLeft="0px";
	document.getElementById('message_inbox').style.width="100%";
		document.getElementById('message_inbox').style.height="";
		document.getElementById('image_inbox').style.width='0px';
		document.getElementById('image_inbox').style.marginLeft='0px';
		document.getElementById('chat_filter').style.marginLeft='0px';
		document.getElementById('chat_filter').style.width='0px';
		//document.getElementById('message_inbox').scrollDown=(0,scrollHeight);
		window.scrollTo(0,document.body.scrollHeight);
		
	update();
	setInterval(function(){
		update();
	},3000);

	
}
function filter_mode(){
document.getElementById('message_inbox').style.width="0px";
document.getElementById('message_inbox').style.height="0px";
document.getElementById('message_inbox').style.marginLeft="0px";
document.getElementById('message_filter').style.width="100%";
document.getElementById('message_filter').style.height="";
document.getElementById('image_inbox').style.width='0px';
document.getElementById('chat_filter').style.marginLeft='0px';
		document.getElementById('chat_filter').style.width='0px';
		document.getElementById('image_inbox').style.marginLeft='0px';
		//document.getElementById('message_filter').scrollDown=scrollHeight;
filter();
setInterval(function(){
	filter();
},3000);
}

function image(){
	$.ajax({url:"images.php",data:"image",success:function(data){
			if(data)
			{
				$('#image_inbox').empty();
				$('#image_inbox').append(data);
			}
		}
	});
}

function image_mode(){
document.getElementById('message_inbox').style.width="0px";
document.getElementById('message_inbox').style.height="0px";
document.getElementById('message_inbox').style.marginLeft="0px";
document.getElementById('message_filter').style.width="0px";
document.getElementById('message_filter').style.height="0px";
document.getElementById('image_inbox').style.width='100%';
document.getElementById('chat_filter').style.marginLeft='0px';
		document.getElementById('chat_filter').style.width='0px';
//document.getElementById('image_inbox').scrollDown=scrollHeight;	

	image();
	setInterval(function(){
		image();
		
	},3000);

}




	$('#search').keyup(function(){
		var text=$(this).val();
		if(text!='')
		{
			window.console&&console.log(text);
			window.console&&console.log("searching");
			
			$.ajax({url:"search.php",data:{search:text},method:"post",dataType:"text",success:function(data)
			{
				window.console&&console.log("searched");
				window.console&&console.log((data));
				$('.s_result').empty();
				$('.s_result').append((data));
			}
			});
		}
		else{
			$('.s_result').empty();
		}
	});


function openslide(){
	document.getElementById('slidebar').style.width='250px';
	document.getElementById('slidebar').style.height='100%';
	document.getElementById('slidebar').style.position='absolute';
	document.getElementById('send').style.marginLeft='250px';
	document.getElementById('message_filter').style.paddingLeft='250px';
	document.getElementById('message_inbox').style.paddingLeft='250px';
	document.getElementById('search').style.marginLeft='100px';
	document.getElementById('update_mode').style.marginLeft='250px';
	
}
function closeslide(){
document.getElementById('slidebar').style.width='0px';
document.getElementById('slidebar').style.position='absolute';
	document.getElementById('send').style.marginLeft='0px';
	document.getElementById('message_filter').style.paddingLeft='0px';
	document.getElementById('message_inbox').style.paddingLeft='0px';
	document.getElementById('update_mode').style.marginLeft='0px';

}
function requests(){
	$.ajax({url:"req.php",success:function(data){
		//console.log(data);
		if(data!="no requests")
		{
			$('#req-div').empty();
		$('#req-div').append(data);
		}
		else{
			$('#req-div').empty();
		}
		
	}
});
}
function req(){
document.getElementById('req-div').style.width="auto";
document.getElementById('req-div').style.height="auto";
document.getElementById('req-div').diplay="inline";
	

	requests();
}
function reqclose(){
	$('#req-div').empty();
	document.getElementById('req-div').display="none";
	document.getElementById('req-div').style.width="0px";
	document.getElementById('req-div').style.height="0px";
	document.getElementById('req-div').style.fontSize="0px";
		document.getElementById('req-div').style.marginLeft="0px";
	

}


	</script>

</body>
<footer style="font-size: 7px;color:white;">IMAGE TAKEN FROM GOOGLE</footer>
</html>
