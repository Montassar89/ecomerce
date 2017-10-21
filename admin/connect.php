<?php

$dns = 'mysql:host=localhost;dbname=shop';
$user = 'root';
$pwd = 'nida2beja';
$option = array(
       PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

try{

	$con = new PDO($dns,$user,$pwd,$option);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
   }

catch(PDOException $e){

	echo 'field to connect'. $e->getMessage();
}   