<?php
session_start();
require "pdo.php";
header("Context-Type:application/text");
ini_set('display_errors',0);
$_SESSION['copy']=$_POST['copy'];
$a= $_SESSION['copy'];
echo $a;



