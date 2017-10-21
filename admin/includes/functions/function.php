
<?php 

//title pages

  function gettitle(){

    global $pagetitle;
  	if(isset($pagetitle)){
  		echo $pagetitle;
  	}else{echo 'default';}
  }

//rederction errors

function redirecthome($theMsg,$url= null,$second =3)
  {

  	if($url= null){

  		$url = 'index.php';
        $link = 'homePage'; 

  	}else{

	  		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''){

	  		$url = $_SERVER['HTTP_REFERER'];

	  		$link = 'Previous Page '; 

	  	       } else{
               
               $url = 'index.php';
               $link = 'homePage';

	  	       }
  	     }

  	echo $theMsg;

  	echo '<div class="container alert alert-info">you well be redirected to '. $link . 'home page after '. $second .' seconds</div>';

  	
  	 header( "refresh:$second;url=$url" );

  	exit();
  }  



  //chech item user ............


  function checkItem($select,$from,$value){

    global $con;

    $statment = $con->prepare("SELECT $select FROM $from WHERE $select=? ");

    $statment->execute(array($value));

    $count = $statment->rowCount();

    return $count;

  }
// check function  count numberof items ....


  function CountItems($item,$table){

    global $con;

    $stmt = $con->prepare("SELECT COUNT($item) FROM $table");

    $stmt->execute();

    return $stmt->fetchColumn();
 }


 //function latest 
     function getLatest($select,$table,$order,$limit = 5){

    global $con;

    $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");

    $stmt->execute();

    $row = $stmt->fetchAll();

    return $row;
 }
