<?php
session_start();
require("pdo.php");
$id=$_SESSION['user_id'];
$me=$_SESSION['username'];
$time=time();
$stmt=$pdo->prepare("UPDATE users SET status=:status WHERE username='$me'");
$stmt->execute(array(':status'=>$time));
