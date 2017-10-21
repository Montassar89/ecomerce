<?php 

ob_start();
 session_start();
    $pagetitle = 'catrgories';
    if(isset($_SESSION['Username'])){

       include "init.php";
      //pages catrgories

       $do = "";
    if(isset($_GET['do'])){$do = $_GET['do'];}
    else{$do = 'manage';}

    if($do == 'manage'){//mange page

 //select alla info 

           $stmt = $con->prepare("SELECT
                                      items.*,
                                      categories.Name AS category_name,
                                      users.Username   
                                  FROM 
                                      items
                                  INNER JOIN
                                      categories
                                  ON
                                      categories.ID = items.Cat_ID
                                  INNER JOIN
                                      users
                                  ON 
                                       users.UserID = items.Member_ID        
                                      ");

           ///execute req

           $stmt->execute();

           //assigne to variable

           $items = $stmt->fetchAll();

           if(! empty($items)){
 	?>
        <h1 class="text-center">Manage Items</h1>
        <div class="container">
        	<div class="table-responsive">
        		<table class="main-table text-center table table-bordered ">
        			<tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Username</td>
                        <td>Category</td>
                        <td>Control</td>    
        			</tr>
        			<?php 
        			foreach ($items as $item) {
        				
        			
        			echo'<tr>';
                        echo'<td>'.$item['Item_ID'] . '</td>';
                        echo'<td>'.$item['Name'] . '</td>';
                        echo'<td>'.$item['Description'] . '</td>';
                        echo'<td>'.$item['Price'] . '</td>';
                        echo'<td>'.$item['Add_Date'] . '</td>';
                        echo'<td>'.$item['Username'] . '</td>';
                        echo'<td>'.$item['category_name'] . '</td>';
                        echo'<td>
                            <a href="items.php?do=edit&itemid=' .$item['Item_ID'] . '" class="btn btn-success"><i class="fa fa-edit">
                            </i> Edit</a>
                            <a href="items.php?do=delete&itemid=' .$item['Item_ID'] . '" class="confirme btn btn-danger">
                            <i class="fa fa-close"></i> Delete</a>';
                        
                             if($item['Approve'] == 0){
                            echo'<a href="items.php?do=approve&itemid='
                            .$item['Item_ID'] . '" class="active btn btn-info">
                            <i class="fa fa-check"></i> Approve </a>';
                             } 
                          
        			echo'</td>';
        			echo'</tr>';
        		     }
        			?>
        				   </table>	
        	</div>	
             <a href="?do=add" class="btn btn-primary"><i class="fa fa-plus"> add item</i></a>
 	        </div>	
            <?php 
          } else{
            echo '<div class="container message">thers no item to show</div>';
            echo'<div class="container">  
             <a href="?do=add" class="btn btn-primary"><i class="fa fa-plus"> add item</i></a>
                </div> '; 

                }
             ?>
            
<?php }elseif ($do == 'add'){//add page ?>

        <h1 class="text-center">Add New Items</h1>
			    <div class="container">
			    	<form class="form-horizontal" method="post" action="?do=insert">
			    		
			    		<!-- start name field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Name</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="name" class="form-control" autocomplete="off"  required="required" placeholder="Name of the item">
			    			</div>
			    		</div>	
			    		<!-- start end field -->
			    		<!-- start description field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2  control-label">Description</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="description" class="form-control" placeholder="Describe of the item">
			    			</div>
			    		</div>	
			    		<!-- end mail field -->
			    		<!-- start Price field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Price</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <input type="text" name="price" class="form-control" placeholder="Price of the item">
                            </div>
			    		</div>	
			    		<!-- end Price field -->
			    		<!-- start country field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Country</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <input type="text" name="country" class="form-control" placeholder="country of made">
                            </div>
			    		</div>	
			    		<!-- end Status field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Status</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <select  name="Status">
                                    <option value="0">Choisir</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
			    	          </select>
                            </div>
			    		</div>	
			    		<!-- end Status field -->
			    		<!-- end start users field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Members</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <select  name="member">
			    	          	<option value="0">Choisir</option>
                                    <?php 

                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user) {
                                    	echo '<option value="'. $user['UserID'] .'">'. $user['Username'].'</option>';
                                    }
                                    ?>
                                    
			    	          </select>
                            </div>
			    		</div>	
			    		<!-- end start users field -->
			    		<!-- end start cat field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Category</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <select  name="cat">
			    	          	<option value="0">Choisir</option>
                                    <?php 

                                    $stmt1 = $con->prepare("SELECT * FROM categories");
                                    $stmt1->execute();
                                    $cats = $stmt1->fetchAll();
                                    foreach ($cats as $cat) {
                                    	echo '<option value="'. $cat['ID'] .'">'. $cat['Name'].'</option>';
                                    }
                                    ?>
                                    
			    	          </select>
                            </div>
			    		</div>	
			    		<!-- end start cat field -->
			    		
			    		<!-- start button field -->
			    		<div class="form-group">
			    			
			    			<div class="col-sm-offset-2 col-sm-10 col-md-6">
			                  <input type="submit" value="Add Item" class="btn btn-primary btn-block btn-lg">
			    			</div>
			    		</div>	
			    		<!-- end buuton field -->
			    	</div>

			    </div>	

 	

              
    <?php 
    }elseif ($do == 'insert'){//page insert

    	if($_SERVER['REQUEST_METHOD'] == 'POST'){

       		echo"<h1 class='text-center'>INSERT Item</h1>";
       	    echo"<div class='container'>";

       		//get variable from the form

    	
    	$name    = $_POST['name'];
    	$desc    = $_POST['description'];
    	$price   = $_POST['price'];
    	$country = $_POST['country'];
    	$status  = $_POST['Status'];
    	$member  = $_POST['member'];
    	$cat     = $_POST['cat'];


        // validate form

    	$formErrors= '';

    	if(empty($name)){$formErrors[] = 'name cant be <strong>empty</strong>';}
        if(empty($desc)){$formErrors[] = 'description cant be <strong>empty</strong>';}
        if(empty($price)){$formErrors[] = 'price cant be <strong>empty</strong>';}
        if(empty($country)){$formErrors[] = 'country cant be <strong>empty</strong>';}
        if($status == 0){$formErrors[] = 'Status cant be <strong>empty</strong>';}
        if($member == 0){$formErrors[] = 'member cant be <strong>empty</strong>';}
        if($cat == 0){$formErrors[] = 'cat cant be <strong>empty</strong>';}

    	foreach($formErrors as $errors){echo '<div class="alert alert-danger">' . $errors . '</div>';}

        //insert the database
    	if(empty($formErrors)){

        $stmt = $con->prepare("INSERT INTO items(Name,Description,Price,Add_Date,Country_Made,Status,Cat_ID,Member_ID) 
    		                          VALUES(:zname,:zdesc,:zprice,now(),:zcountry,:zstatus,:zcat,:zmember ) ");
    	$stmt->execute(array(

    		'zname'    => $name,
    	    'zdesc'    => $desc,
    	    'zprice'   => $price,
    	    'zcountry' => $country,
    	    'zstatus'  => $status,
    	    'zcat'     => $cat,
    	    'zmember'  => $member
    	                    ));

    	 //echo success msg

    	$theMsg = '<div class="alert alert-success">'. $stmt->rowCount() .' record insert</div>';


    	redirecthome($theMsg,'back',5);


                              }
         } else{$theMsg = '<div class="container alert alert-success">sorry you cant browse this page directly </div>';

    	        redirecthome($theMsg,'back',5);}

       echo '</div>';

       

    }elseif ($do == 'edit'){//pge edit

           $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    //select  all  data depend of the id 

     $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID=?");
     //excute query
    	$stmt->execute(array($itemid));
    //fetch the data
        $item = $stmt->fetch();
     //row count   
    	$count = $stmt->rowCount();

    // if there such id show form	
    	if($count > 0) { ?>
             
              <h1 class="text-center">Edit Items</h1>
			    <div class="container">
			    	<form class="form-horizontal" method="post" action="?do=update">
			    		<input class="hidden" name="itemid" value="<?php echo $itemid; ?>" />
			    		
			    		<!-- start name field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Name</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="name" class="form-control" value="<?php echo $item['Name']; ?>"  required="required" placeholder="Name of the item">
			    			</div>
			    		</div>	
			    		<!-- start end field -->
			    		<!-- start description field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2  control-label">Description</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="description" class="form-control" value="<?php echo $item['Description']; ?>" placeholder="Describe of the item">
			    			</div>
			    		</div>	
			    		<!-- end mail field -->
			    		<!-- start Price field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Price</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <input type="text" name="price" class="form-control" value="<?php echo $item['Price']; ?>" placeholder="Price of the item">
                            </div>
			    		</div>	
			    		<!-- end Price field -->
			    		<!-- start country field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Country</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <input type="text" name="country" class="form-control" value="<?php echo $item['Country_Made']; ?>" placeholder="country of made">
                            </div>
			    		</div>	
			    		<!-- end Status field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Status</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <select  name="Status">
                                    <option value="1" <?php if($item['Status']==1){echo 'selected';} ?>>New</option>
                                    <option value="2" <?php if($item['Status']==2){echo 'selected';} ?>>Like New</option>
                                    <option value="3" <?php if($item['Status']==3){echo 'selected';} ?>>Used</option>
			    	          </select>
                            </div>
			    		</div>	
			    		<!-- end Status field -->
			    		<!-- end start users field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Members</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <select  name="member">
                                    <?php 
                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user) {
                                    	echo '<option value="'. $user['UserID'] .'"';
                                    	if($item['Member_ID']==$user['UserID']){echo 'selected';}
                                    	echo '>'. $user['Username'].'</option>';
                                    }
                                    ?>
                                    
			    	          </select>
                            </div>
			    		</div>	
			    		<!-- end start users field -->
			    		<!-- end start cat field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Category</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <select  name="cat">
			    	          	<?php 

                                    $stmt1 = $con->prepare("SELECT * FROM categories");
                                    $stmt1->execute();
                                    $cats = $stmt1->fetchAll();
                                    foreach ($cats as $cat) {
                                    	echo '<option value="'. $cat['ID'] .'"';
                                    	if($item['Cat_ID']==$cat['ID']){echo 'selected';}
                                    	echo'>'. $cat['Name'].'</option>';
                                    }
                                    ?>
                                    
			    	          </select>
                            </div>
			    		</div>	
			    		<!-- end start cat field -->
			    		
			    		<!-- start button field -->
			    		<div class="form-group">
			    			
			    			<div class="col-sm-offset-2 col-sm-10 col-md-6">
			                  <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg">
			    			</div>
			    		</div>	
			    		<!-- end buuton field -->
			    	</div>	
            <?php 
             $stmt = $con->prepare("SELECT
                                      comments.*,users.Username AS Usercom 
                                  FROM 
                                      comments
                                 
                                  INNER JOIN
                                      users
                                  ON 
                                       users.UserID = comments.user_id  
                                  WHERE item_id =?           
                                      ");
            ///execute req

           $stmt->execute(array($itemid));

           //assigne to variable

           $come = $stmt->fetchAll();

           if(! empty($come)){
       ?>
        <h1 class="text-center">Manage [<?php echo $item['Name']; ?>] Comment</h1>
        <div class="container">
          <div class="table-responsive">
            <table class="main-table text-center table table-bordered ">
              <tr>
                        
                        <td>Comment</td>
                        <td>Username</td>
                        <td>ADD Date</td>
                        <td>Control</td>
                           
              </tr>
              <?php 
              foreach ($come as $com) {
                
              
              echo'<tr>';
                        
                        echo'<td>'.$com['comment'] . '</td>';
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
            <?php } ?>
          </div>  
                  
          
			    	

			   
       <?php

          }else{

          	$theMsg = '<div class="container alert alert-danger">theres no such ID</div>';


    	  redirecthome($theMsg,5);

          }


    
             
    }elseif ($do == 'update'){// page update

    		echo"<h1 class='text-center'>Update Item</h1>";
       	echo"<div class='container'>";

       	if($_SERVER['REQUEST_METHOD'] == 'POST'){

       		//get variable from the form

    	$id      = $_POST['itemid'];
        $name    = $_POST['name'];
    	$desc    = $_POST['description'];
    	$price   = $_POST['price'];
    	$country = $_POST['country'];
    	$status  = $_POST['Status'];
    	$member  = $_POST['member'];
    	$cat     = $_POST['cat'];


        // validate form

    	$formErrors= '';

    	if(empty($name)){$formErrors[] = 'name cant be <strong>empty</strong>';}
        if(empty($desc)){$formErrors[] = 'description cant be <strong>empty</strong>';}
        if(empty($price)){$formErrors[] = 'price cant be <strong>empty</strong>';}
        if(empty($country)){$formErrors[] = 'country cant be <strong>empty</strong>';}
        if($status == 0){$formErrors[] = 'Status cant be <strong>empty</strong>';}
        if($member == 0){$formErrors[] = 'member cant be <strong>empty</strong>';}
        if($cat == 0){$formErrors[] = 'cat cant be <strong>empty</strong>';}

    


    	  //update the database
    	if(empty($formErrors)){

    	$stmt = $con->prepare("UPDATE items SET Name=? ,Description=?,
    	                              Price=?,Country_Made=?,Status=?,Member_ID=?,Cat_ID=? 
    	                        WHERE Item_ID=?");
    	$stmt->execute(array($name,$desc,$price,$country,$status,$member,$cat,$id));

    	 //echo success msg

    	$theMsg = '<div class="alert alert-success">'. $stmt->rowCount() .' record update</div>';

    	redirecthome($theMsg,'back',3);
    }


       } else{

       	$theMsg ='<div class="alert alert-danger">sorry you cant browse this page directly </div>';

       	redirecthome($theMsg);

       }

       echo '</div>';


    }elseif ($do == 'delete'){//dlete page

    	echo '<h1 class="text-center">Delete Item</h1>';
          echo '<div class="container">';

       $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    //select  all  data depend of the id 

     $check = checkItem('Item_ID','items',$itemid);
    
     // if there such id show form	
    	if($check > 0) { 

    		$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

    		$stmt->bindParam(":zid",$itemid);

    		$stmt->execute();

    		$theMsg = '<div class="container alert alert-success">'. $stmt->rowCount() .' record delete</div>';


            redirecthome($theMsg);

    	}	else{

    		
    		$theMsg = '<div class="container alert alert-success">this ID id not exist</div>';


            redirecthome($theMsg);

            }

        echo'</div>';    


    }elseif ($do == 'approve'){


            echo '<h1 class="text-center">Approve Item</h1>';
            echo '<div class="container">';

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

           //select  all  data depend of the id 

            $check = checkItem('Item_ID','items',$itemid);
      
            // if there such id show form  
             if($check > 0) { 

                              $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

                              $stmt->execute(array($itemid));

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