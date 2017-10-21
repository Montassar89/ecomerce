<?php

 $do = "";
 if(isset($_GET['do'])){

 	$do = $_GET['do'];
 }
 else{

 	$do = 'manage';
 }

 if($do == 'manage'){

 	echo 'welcome you are in manage category page';
 	echo '<a href="pages.php?do=add">add new category +</a>';
 }
 elseif($do == 'add'){

 	echo 'welcome you are in add category page';
 }

 elseif($do == 'insert'){

 	echo 'welcome you are in insert category page';
 }
 else{

  echo 'error theres no page with this name' ;
 }