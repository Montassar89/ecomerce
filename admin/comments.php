<?php 

ob_start();
 session_start();
    $pagetitle = 'Comments';
    if(isset($_SESSION['Username'])){

       include "init.php";
      //pages catrgories

       $do = "";
    if(isset($_GET['do'])){$do = $_GET['do'];}
    else{$do = 'manage';}

    if($do == 'manage'){//mange page

 //select alla info 

           $stmt = $con->prepare("SELECT
                                      comments.* ,items.Name AS item_name,users.Username AS Usercom 
                                  FROM 
                                      comments
                                  INNER JOIN
                                      items
                                  ON
                                      items.Item_ID = comments.item_id
                                  INNER JOIN
                                      users
                                  ON 
                                       users.UserID = comments.user_id        
                                      ");
            ///execute req

           $stmt->execute();

           //assigne to variable

           $come = $stmt->fetchAll();
           if(! empty($come)){
 	?>
        <h1 class="text-center">Manage Comment</h1>
        <div class="container">
        	<div class="table-responsive">
        		<table class="main-table text-center table table-bordered ">
        			<tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Item Name</td>
                        <td>Username</td>
                        <td>ADD Date</td>
                        <td>Control</td>
                           
        			</tr>
        			<?php 
        			foreach ($come as $com) {
        				
        			
        			echo'<tr>';
                        echo'<td>'.$com['C_ID'] . '</td>';
                        echo'<td>'.$com['comment'] . '</td>';
                        echo'<td>'.$com['item_name'] . '</td>';
                        echo'<td>'.$com['Usercom'] . '</td>';
                        echo'<td>'.$com['comment_date'] . '</td>';
                 
                        echo'<td>
                            <a href="comments.php?do=edit&comid=' .$com['C_ID'] . '" class="btn btn-success"><i class="fa fa-edit">
                            </i> Edit</a>
                            <a href="comments.php?do=delete&comid=' .$com['C_ID'] . '" class="confirme btn btn-danger">
                            <i class="fa fa-close"></i> Delete</a>';
                        
                             if($com['status'] == 0){
                            echo'<a href="comments.php?do=approve&comid='
                            .$com['C_ID'] . '" class="active btn btn-info">
                            <i class="fa fa-check"></i> Approve </a>';
                             } 
                          
        			echo'</td>';
        			echo'</tr>';
        		     }
        			?>
        				   </table>	
        	</div>	
            
 	        </div>	
          <?php }else{echo '<div class="container message">thers no comment to show</div>';} ?>
                  
<?php  }elseif ($do == 'edit'){//pge edit

           $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

    //select  all  data depend of the id 

     $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID=?");
     //excute query
    	$stmt->execute(array($comid));
    //fetch the data
        $com = $stmt->fetch();
     //row count   
    	$count = $stmt->rowCount();

    // if there such id show form	
    	if($count > 0) { ?>
             
              <h1 class="text-center">Edit Comment</h1>
			    <div class="container">
			    	<form class="form-horizontal" method="post" action="?do=update">
			    		<input class="hidden" name="comid" value="<?php echo $comid; ?>" />
			    		
			    		<!-- start name field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Comment</label>
			    			<div class="col-sm-10 col-md-6">
			                  <textarea name="comment" class="form-control" required="required"><?php echo $com['comment']; ?></textarea>
			    			</div>
			    		</div>	
			    		<!-- start end field -->
			    		<!-- start button field -->
			    		<div class="form-group">
			    			
			    			<div class="col-sm-offset-2 col-sm-10 col-md-6">
			                  <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg">
			    			</div>
			    		</div>	
			    		<!-- end buuton field -->
			    	</div>	
			    </div>	

			   
       <?php

          }else{

          	$theMsg = '<div class="container alert alert-danger">theres no such ID</div>';


    	  redirecthome($theMsg,5);

          }


    
             
    }elseif ($do == 'update'){// page update

    		echo"<h1 class='text-center'>Update Comment</h1>";
       	echo"<div class='container'>";

       	if($_SERVER['REQUEST_METHOD'] == 'POST'){

       		//get variable from the form

    	  $id      = $_POST['comid'];
        $comment    = $_POST['comment'];
 

    	$stmt = $con->prepare("UPDATE comments SET comment=? WHERE C_ID=?");
    	$stmt->execute(array($comment,$id));

    	 //echo success msg

    	$theMsg = '<div class="alert alert-success">'. $stmt->rowCount() .' record update</div>';

    	redirecthome($theMsg,'back',3);
    }


        else{

       	$theMsg ='<div class="alert alert-danger">sorry you cant browse this page directly </div>';

       	redirecthome($theMsg);

       }

       echo '</div>';


    }elseif ($do == 'delete'){//dlete page

    	echo '<h1 class="text-center">Delete Comment</h1>';
          echo '<div class="container">';

       $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

    //select  all  data depend of the id 

     $check = checkItem('C_ID','comments',$comid);
    
     // if there such id show form	
    	if($check > 0) { 

    		$stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zid");

    		$stmt->bindParam(":zid",$comid);

    		$stmt->execute();

    		$theMsg = '<div class="container alert alert-success">'. $stmt->rowCount() .' record delete</div>';


            redirecthome($theMsg);

    	}	else{

    		
    		$theMsg = '<div class="container alert alert-success">this ID id not exist</div>';


            redirecthome($theMsg);

            }

        echo'</div>';    


    }elseif ($do == 'approve'){


            echo '<h1 class="text-center">Approve Comment</h1>';
            echo '<div class="container">';

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

           //select  all  data depend of the id 

            $check = checkItem('C_ID','comments',$comid);
      
            // if there such id show form  
             if($check > 0) { 

                              $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE C_ID = ?");

                              $stmt->execute(array($comid));

                              $theMsg = '<div class="container alert alert-success">'. $stmt->rowCount() .' record activate</div>';

                              redirecthome($theMsg);

                            } 
             else{

          
                              $theMsg = '<div class="container alert alert-success">this ID id not exist</div>';

                              redirecthome($theMsg,10);

                 }

          echo'</div>'; 
          }
    	




 include $tpl . "footer.php";

    } else{header('Location: index.php'); exit();}
 ob_end_flush();

   ?>     	