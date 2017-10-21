<?php 


ob_start();
 session_start();
    if(isset($_SESSION['Username'])){

    	$pagetitle = 'dashboard';

      include "init.php";

     ?>

     <div class="home-stats">
     	<div class="container text-center">
     		<h1>Dashboard</h1>
     		<div class="row">
     			<div class="col-lg-3">
     				<div class="stat st-Members">
                        <i class="fa fa-users"></i>
                        <div class="info">
     					Totals Members
     					<span><a href="members.php"><?php echo CountItems('UserID','users') ?></a></span>
                        </div>
     				</div>
                </div>
                <div class="col-lg-3">
     				<div class="stat st-Pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
     					Pending Members
     					<span><a href="members.php?do=manage&page=Pending"><?php echo checkItem('RegStatus','users',0) ?></a></span>
                        </div>
     				</div>
                </div>
                <div class="col-lg-3">
     				<div class="stat st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
     					 Totals Items
     					 <span><a href="items.php"><?php echo CountItems('Item_ID','items') ?></a></span>
                        </div>
     				</div>
                </div>
                <div class="col-lg-3">
     				<div class="stat st-comments">
                        
                        <i class="fa fa-comments"></i>
                        <div class="info">
     					Totals Comments
     					<span><a href="comments.php"><?php echo CountItems('C_ID','comments') ?></a></span>
                        </div>
     				</div>
                </div>
            </div>
        </div>
      </div>


     <div class="lastes">
     	<div class="container">
     		
     		<div class="row">
     			<div class="col-sm-6">
     			 <div class="panel panel-default">
     			 	<?php $latestuser = 4;?>
	     			  <div class="panel panel-heading">
	     			  <i class="fa fa-users"></i> Lastes <?php echo $latestuser?> Users 
                      <span class="toggle-info pull-right">
                          <i class="fa fa-plus fa-lg"></i>
                      </span>
	     			  </div>
	     			  <div class="panel panel-body">
	     			  	<ul class="latest-users list-unstyled">
		     			  <?php 
	                           $theLatest = getLatest("*","users","UserID",$latestuser);
                             if(! empty($theLatest)){
	                           foreach ($theLatest as $user) {
	                           	
	                           	echo '<li>' . $user['Username'] .
	                           	'<a href="members.php?do=edit&userid=' .$user['UserID'] .'">
	                           	<span class="btn btn-success pull-right">
	                           	<i class="fa fa-edit"></i>
	                           	 Edit</span>';
	                           	 if($user['RegStatus'] == 0){
                                   echo'<a href="members.php?do=activate&userid='
                                   .$user['UserID'] . '" class="active btn btn-info pull-right">
                                    <i class="fa fa-check"></i> Active </a>';
                                                          }
	                           	 
	                           	 echo'</a></li></a>';
                              }
	                           	   
	                           }
                             else{echo 'thers no record to show';}
                           ?>
                          </ul> 
	     			  </div> 
	     	     </div>
	     	    </div>

	     	    <div class="col-sm-6">
     			    <div class="panel panel-default">
                    <?php $latestitems = 4;?>
	     			    <div class="panel panel-heading">
	     			  <i class="fa fa-tag"></i> Lastes Items
                      <span class="toggle-info pull-right">
                          <i class="fa fa-plus fa-lg"></i>
                      </span> 
	     			    </div>
	     			  <div class="panel panel-body">
	     			     <ul class="latest-users list-unstyled">
                          <?php 
                               $theLatest = getLatest("*","items","Item_ID",$latestitems);
                               if(! empty($theLatest)){
                                   foreach ($theLatest as $item) {
                                    
                                    echo '<li>' . $item['Name'] .
                                    '<a href="items.php?do=edit&itemid=' .$item['Item_ID'] .'">
                                    <span class="btn btn-success pull-right">
                                    <i class="fa fa-edit"></i>
                                     Edit</span>';
                                     if($item['Approve'] == 0){
                                       echo'<a href="items.php?do=approve&itemid='
                                       .$item['Item_ID'] . '" class="active btn btn-info pull-right">
                                        <i class="fa fa-check"></i> Active </a>';
                                                              }
                                        echo'</a></li></a>';
                                }
                               }
                               else{echo 'thers no record to show';}
                                   
                           ?>
                          </ul> 
	     			  </div> 
	     	     </div>
	     	    </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="panel panel-default">
                 <?php $latestuser = 4;?>
                    <div class="panel panel-heading">
                       <i class="fa fa-comments-o"></i> Lastes Comments 
                      <span class="toggle-info pull-right">
                          <i class="fa fa-plus fa-lg"></i>
                      </span>
                    </div>
                    <div class="panel panel-body">
                        <?php
                                  $stmt = $con->prepare("SELECT
                                      comments.*, users.Username AS Usercom FROM 
                                      comments INNER JOIN users ON users.UserID = comments.user_id");
                                  $stmt->execute();
                                  $come = $stmt->fetchAll();
                                  if(! empty($come)){
                                      foreach ($come as $com) {
                                          echo'<div class="box">';
                                                  echo'<span class="member-n">' . $com['Usercom']. '</span> ';
                                                  echo'<p class="member-c">' . $com['comment']. '</p>';
                                          echo'</div>';
                                                               }                           
                                  }
                                  else{echo 'thers no record to show';}
                        ?>

                    </div> 
                </div>
              </div>
            </div>

	     	   
	     	</div>
	    </div>
    </div>


     <?php

      include $tpl . "footer.php";

    }

    else{

    header('Location: index.php');

    exit();
    }
    ob_end_flush();

   ?> 