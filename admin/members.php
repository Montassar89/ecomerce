<?php 


ob_start();
 session_start();
 $pagetitle = 'members';
    if(isset($_SESSION['Username'])){

      include "init.php";
      //pages members

 $do = "";
 if(isset($_GET['do'])){$do = $_GET['do'];}
 else{$do = 'manage';}

 if($do == 'manage'){//manage page

        $query = '';

        if(isset($_GET['page']) && $_GET['page'] == 'Pending') {

          $query = 'AND RegStatus = 0';
        }

 	      //select alla info 

           $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 $query");

           ///execute req

           $stmt->execute();

           //assigne to variable

           $rows = $stmt->fetchAll();

           if(! empty($rows)){
 	?>
        <h1 class="text-center">Manage Members</h1>
        <div class="container">
        	<div class="table-responsive">
        		<table class="main-table text-center table table-bordered ">
        			<tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>FullName</td>
                        <td>Registerd Date</td>
                        <td>Control</td>    
        			</tr>
        			<?php 
        			foreach ($rows as $row) {
        				
        			
        			echo'<tr>';
                        echo'<td>'.$row['UserID'] . '</td>';
                        echo'<td>'.$row['Username'] . '</td>';
                        echo'<td>'.$row['Email'] . '</td>';
                        echo'<td>'.$row['FullName'] . '</td>';
                        echo'<td>'.$row['Date'] . '</td>';
                        echo'<td>
                            <a href="members.php?do=edit&userid=' .$row['UserID'] . '" class="btn btn-success"><i class="fa fa-edit">
                            </i> Edit</a>
                            <a href="members.php?do=delete&userid=' .$row['UserID'] . '" class="confirme btn btn-danger">
                            <i class="fa fa-close"></i> Delete</a>';
                        
                        if($row['RegStatus'] == 0){
                        echo'<a href="members.php?do=act&userid='
                         .$row['UserID'] . '" class="active btn btn-info">
                        <i class="fa fa-check">
                        </i> Active </a>';
                        }  
                        echo'</td>';


                         

        			
        			          echo'</tr>';
        		     }
        			?>
        				   </table>	
        	</div>	
             <a href="?do=add" class="btn btn-primary"><i class="fa fa-plus"> add members</i></a>
 	        </div>
          <?php }
          else{else{
            echo '<div class="container message">thers no member to show</div>';
            echo'<div class="container">  
             <a href="?do=add" class="btn btn-primary"><i class="fa fa-plus"> add member</i></a>
                </div> '; 

                }	?>
                  
                   <?php  
}elseif($do == 'add'){//add page ?>
                <h1 class="text-center">Add Members</h1>
			    <div class="container">
			    	<form class="form-horizontal" method="post" action="?do=insert">
			    		
			    		<!-- start username field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Username</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="username" class="form-control" autocomplete="off"  required="required" placeholder="your username">
			    			</div>
			    		</div>	
			    		<!-- start end field -->
			    		<!-- start mail field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2  control-label">Email</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="email" name="mail" class="form-control" autocomplete="off"  required="required" placeholder="your email">
			    			</div>
			    		</div>	
			    		<!-- end mail field -->
			    		<!-- start password field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Password</label>
			    			<div class="col-sm-10 col-md-6">
			    			  
			                  <input type="password" name="password" class="password form-control" autocomplete="off" required="required" placeholder="your password">
			    			  <i class="show-pass fa fa-eye fa-2x"></i>
			    			</div>
			    		</div>	
			    		<!-- end password field -->
			    		<!-- start full name field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Full Name</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="full" class="form-control" required="required" placeholder="your fullname">
			    			</div>
			    		</div>	
			    		<!-- end full name field -->
			    		<!-- start button field -->
			    		<div class="form-group">
			    			
			    			<div class="col-sm-offset-2 col-sm-10 col-md-6">
			                  <input type="submit" value="Add Member" class="btn btn-primary btn-block btn-lg">
			    			</div>
			    		</div>	
			    		<!-- end buuton field -->
			    	</form>	
			    </div>	

 	



                     <?php }

       elseif( $do == 'insert'){// page insert

       

       	

       	if($_SERVER['REQUEST_METHOD'] == 'POST'){

       		echo"<h1 class='text-center'>INSERT Members</h1>";
       	    echo"<div class='container'>";

       		//get variable from the form

    	
    	$user  = $_POST['username'];
    	$email = $_POST['mail'];
    	$pass  = $_POST['password'];
    	$name  = $_POST['full'];

    	// password trick
    	$hashpass = sha1($_POST['password']);
    	

    	// validate form

    	$formErrors= '';

    	if(empty($user)){$formErrors[] = 'username cant be <strong>empty</strong>';}
    	if(strlen($user) < 4){$formErrors[] = 'username cant be lass than <strong>4 characters</strong>';}
    	if(empty($email)){$formErrors[] = 'email cant be <strong>empty</strong>';}
    	if(empty($pass)){$formErrors[] = 'password cant be <strong>empty</strong>';}
    	if(empty($name)){$formErrors[] = 'name cant be <strong>empty</strong>';}

    	foreach($formErrors as $errors){echo '<div class="alert alert-danger">' . $errors . '</div>';}



    	  //insert the database
    	if(empty($formErrors)){

    		//check user exist in data base

    	$check = checkItem("Username","users",$user);
    	
    	if($check == 1){

    		$theMsg = '<div class="alert alert-info">sorry this username is exist</div>';

    		
            redirecthome($theMsg,'back',5);

    	}	else{ 

    	$stmt = $con->prepare("INSERT INTO users(Username,Email,Password,FullName,RegStatus, Date) 
    		                          VALUES(:zuser,:zmail,:zpass,:zname,1,now() ) ");
    	$stmt->execute(array(

    		'zuser' => $user,
    	    'zmail' => $email,
    	    'zpass' => $hashpass,
    	    'zname' => $name
    	                    ));

    	 //echo success msg

    	$theMsg = '<div class="alert alert-success">'. $stmt->rowCount() .' record insert</div>';


    	redirecthome($theMsg,'back',5);


                               }
                }


       } else{


       	

       	$theMsg = '<div class="container alert alert-success">sorry you cant browse this page directly </div>';

    	redirecthome($theMsg,'back',5);

       }

       echo '</div>';


       } 





       elseif($do == 'edit'){ //edit page 

 	// check if get request is numeric

     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    //select  all  data depend of the id 

     $stmt = $con->prepare("SELECT * FROM users WHERE UserID=?  LIMIT 1");
     //excute query
    	$stmt->execute(array($userid));
    //fetch the data
        $row = $stmt->fetch();
     //row count   
    	$count = $stmt->rowCount();

    // if there such id show form	
    	if($count > 0) { ?>

			    <h1 class="text-center">Edit Members</h1>
			    <div class="container">
			    	<form class="form-horizontal" method="post" action="?do=update">
			    		<input class="hidden" name="userid" value="<?php echo $userid; ?>" />
			    		<!-- start username field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Username</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['Username']; ?>" required="required">
			    			</div>
			    		</div>	
			    		<!-- start end field -->
			    		<!-- start mail field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2  control-label">Email</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="email" name="mail" class="form-control" autocomplete="off" value="<?php echo $row['Email']; ?>" required="required">
			    			</div>
			    		</div>	
			    		<!-- end mail field -->
			    		<!-- start password field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Password</label>
			    			<div class="col-sm-10 col-md-6">
			    			  <input type="password" name="oldpassword" class="hidden" value="<?php echo $row['Password']; ?>" />
			                  <input type="password" name="newpassword" class="form-control" autocomplete="off" placeholder="Leave blank if you dont want to change">
			    			</div>
			    		</div>	
			    		<!-- end password field -->
			    		<!-- start full name field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Full Name</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="full" class="form-control" value="<?php echo $row['FullName']; ?>" required="required">
			    			</div>
			    		</div>	
			    		<!-- end full name field -->
			    		<!-- start button field -->
			    		<div class="form-group">
			    			
			    			<div class="col-sm-offset-2 col-sm-10 col-md-6">
			                  <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg">
			    			</div>
			    		</div>	
			    		<!-- end buuton field -->
			    	</form>	
			    </div>	

 	
       <?php

          }else{

          	$theMsg = '<div class="container alert alert-danger">theres no such ID</div>';


    	  redirecthome($theMsg,5);

          }

       }elseif($do =='update'){//page update

       	echo"<h1 class='text-center'>Update Members</h1>";
       	echo"<div class='container'>";

       	if($_SERVER['REQUEST_METHOD'] == 'POST'){

       		//get variable from the form

    	$id = $_POST['userid'];
    	$user = $_POST['username'];
    	$email = $_POST['mail'];
    	$name = $_POST['full'];

    	// password trick
    	$pass = '';
    	if(empty($_POST['newpassword'])){

    		$pass = $_POST['oldpassword'];

    	}
    	else{$pass = sha1($_POST['newpassword']);}

    	// validate form

    	$formErrors= '';

    	if(empty($user)){$formErrors[] = 'username cant be <strong>empty</strong>';}
    	if(strlen($user) < 4){$formErrors[] = 'username cant be lass than <strong>4 characters</strong>';}
    	if(empty($email)){$formErrors[] = 'email cant be <strong>empty</strong>';}
    	if(empty($name)){$formErrors[] = 'name cant be <strong>empty</strong>';}

    	foreach($formErrors as $errors){echo '<div class="alert alert-danger">' . $errors . '</div>';}



    	  //update the database
    	if(empty($formErrors)){

    	$stmt = $con->prepare("UPDATE users SET Username=? ,Email=?, FullName=?,Password=? WHERE UserID=?");
    	$stmt->execute(array($user,$email,$name,$pass,$id));

    	 //echo success msg

    	$theMsg = '<div class="alert alert-success">'. $stmt->rowCount() .' record update</div>';

    	redirecthome($theMsg,'back',3);
    }


       } else{

       	$theMsg ='<div class="alert alert-danger">sorry you cant browse this page directly </div>';

       	redirecthome($theMsg);

       }

       echo '</div>';

   } elseif ($do='delete') {// delete page
   	

          echo '<h1 class="text-center">Delete Members</h1>';
          echo '<div class="container">';

       $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    //select  all  data depend of the id 

     $check = checkItem('userid','users',$userid);
    
     // if there such id show form	
    	if($check > 0) { 

    		$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

    		$stmt->bindParam(":zuser",$userid);

    		$stmt->execute();

    		$theMsg = '<div class="container alert alert-success">'. $stmt->rowCount() .' record delete</div>';


            redirecthome($theMsg);

    	}	else{

    		
    		$theMsg = '<div class="container alert alert-success">this ID id not exist</div>';


            redirecthome($theMsg);

            }

        echo'</div>';    

   }elseif ($do == 'act'){


            echo '<h1 class="text-center">activate Item</h1>';
            echo '<div class="container">';

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

           //select  all  data depend of the id 

            $check = checkItem('UserID','users',$userid);
      
            // if there such id show form  
             if($check > 0) { 

                              $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE Item_ID = ?");

                              $stmt->execute(array($userid));

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

    }else{header('Location: index.php');exit();}
     ob_end_flush();

   ?>  