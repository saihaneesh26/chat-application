<?php
$host=ec2-52-205-61-60.compute-1.amazonaws.com;
$username=oygvnaphenntha;
 $pass=45bd7bcf0a71f96b94a827d1e61e0ef9b52ab0fb77366f6cb7f621eb79cc7e1c;
$port=5432;
$dbname=dc85gdddpisuug;
$pdo=new PDO('pgsql:host='.$host.';port='.$port.';dbname='.$dbname,$username,$pass);
?>
