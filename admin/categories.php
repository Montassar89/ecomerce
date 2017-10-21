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

    if     ($do == 'manage'){//manage page

    	  $sort = "ASC";

    	  $sort_array = array("ASC","DESC");

    	  if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){

    	  	$sort = $_GET['sort'];
    	  }

          $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort ");
          $stmt->execute();
          $cats = $stmt->fetchAll(); ?>

          <?php if (! empty($cats)){ ?>


          <h1 class="text-center">Manage Categories</h1>
          <div class="container categories">
          	<div class="panel panel-default">
          		<div class="panel-heading"><i class="fa fa-edit"></i> Manage Categories
                   <div class="option pull-right">
                   	<i class="fa fa-sort"></i> Ordering:[
                   	<a class="<?php if($sort == 'ASC'){echo 'active';} ?>" href='?sort=ASC'>ASC</a> |
                   	<a class="<?php if($sort == 'DESC'){echo 'active';} ?>" href='?sort=DESC'>DESC</a> ]
                   	<i class="fa fa-eye"></i> View:[
                   	<span class="active" data-view="full">Full</span> |
                   	<span >Classic</span> ]
                   </div>
          		</div>
          		<div class="panel-body">
          			<?php 
                     foreach ($cats as $cat) {
                     echo '<div class="cat">';
                     echo '<div class="hidden-buttons">';
                     echo '<a href="categories.php?do=edit&catid='.$cat['ID'].'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>';
                     echo '<a href="categories.php?do=delete&catid='.$cat['ID'].'" class="confirme btn btn-danger btn-xs"><i class="fa fa-close"></i> Delete</a>';
                     echo '</div>';
                       echo '<h3>'.$cat['Name']. '</h3>';
                       echo '<div class="full-view">';
	                       echo '<p>'; if(empty($cat['Description']))
	                        {echo 'this description is empty';}else{echo $cat['Description'];} echo'</p>';
	                       if($cat['Visibility'] == 1){echo '<span class="visibil"><i class="fa fa-eye"></i> Hidden</span>';}
	                       if($cat['Allow_Comment'] == 1){echo '<span class="coment"><i class="fa fa-close"></i> Comment Disabled</span>';}
	                       if($cat['Allow_Ads'] == 1){echo '<span class="ads"><i class="fa fa-close"></i> Ads Disabled</span>';}
                       echo '</div>'; 
                     echo '</div>'; 
                     echo '<hr>';      

                     }

          			?>
          		</div>	
          	</div>	
          	<a class="add-cat btn btn-primary" href="categories.php?do=add"><i class="fa fa-plus"></i> Add Category</a>
          </div>
          <?php } 

                 else{
            echo '<div class="container message">thers no categories to show</div>';
            echo'<div class="container">  
             <a href="?do=add" class="btn btn-primary"><i class="fa fa-plus"> Add Category</i></a>
                </div> '; 

                }
          ?>	

   <?php }elseif ($do == 'add'){//page add ?>

     <h1 class="text-center">Add New Categories</h1>
			    <div class="container">
			    	<form class="form-horizontal" method="post" action="?do=insert">
			    		
			    		<!-- start name field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Name</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="name" class="form-control" autocomplete="off"  required="required" placeholder="Name off the category">
			    			</div>
			    		</div>	
			    		<!-- start end field -->
			    		<!-- start description field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2  control-label">Description</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="description" class="form-control" placeholder="Describe the Category">
			    			</div>
			    		</div>	
			    		<!-- end mail field -->
			    		<!-- start ordering field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Ordering</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the category">
                            </div>
			    		</div>	
			    		<!-- end password field -->
			    		<!-- start Visible field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Visible</label>
			    			<div class="col-sm-10 col-md-6">
			                  <div>
			                  	<input id="vis-yes" type="radio" name="visibility" value="0" checked>
			                  	<label for="vis-yes">Yes</label>
			                  </div>
			                    <div>
			                  	<input id="vis-no" type="radio" name="visibility" value="1" >
			                  	<label for="vis-no">No</label>
			                  </div>
			    			</div>
			    		</div>	
			    		<!-- end Visible field -->
			    		<!-- start commenting field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Allow Commenting</label>
			    			<div class="col-sm-10 col-md-6">
			                  <div>
			                  	<input id="com-yes" type="radio" name="comment" value="0" checked>
			                  	<label for="com-yes">Yes</label>
			                  </div>
			                    <div>
			                  	<input id="com-no" type="radio" name="comment" value="1" >
			                  	<label for="com-no">No</label>
			                  </div>
			    			</div>
			    		</div>	
			    		<!-- end commenting field -->
			    		<!-- start ads field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Allow Ads</label>
			    			<div class="col-sm-10 col-md-6">
			                  <div>
			                  	<input id="ads-yes" type="radio" name="ads" value="0" checked>
			                  	<label for="ads-yes">Yes</label>
			                  </div>
			                    <div>
			                  	<input id="ads-no" type="radio" name="ads" value="1" >
			                  	<label for="ads-no">No</label>
			                  </div>
			    			</div>
			    		</div>	
			    		<!-- end Ads field -->
			    		<!-- start button field -->
			    		<div class="form-group">
			    			
			    			<div class="col-sm-offset-2 col-sm-10 col-md-6">
			                  <input type="submit" value="Add Category" class="btn btn-primary btn-block btn-lg">
			    			</div>
			    		</div>	
			    		<!-- end buuton field -->
			    	</div>	
			    </div>	

 	

              
    <?php 
    } elseif ($do == 'insert'){//insert page

     	if($_SERVER['REQUEST_METHOD'] == 'POST'){

       		echo"<h1 class='text-center'>INSERT Category</h1>";
       	    echo"<div class='container'>";

       		//get variable from the form

    	
    	$name     = $_POST['name'];
    	$desc     = $_POST['description'];
    	$order    = $_POST['ordering'];
    	$Visible  = $_POST['visibility'];
    	$comment  = $_POST['comment'];
    	$ads      = $_POST['ads'];

     
    	  //insert the database
    	

    		//check category exist in data base

    	$check = checkItem("Name","categories",$name);
    	
    	if($check == 1){

    		$theMsg = '<div class="alert alert-info">sorry this category is exist</div>';

    		
            redirecthome($theMsg,'back',5);

    	}	else{ 

    	$stmt = $con->prepare("INSERT INTO categories(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads) 
    		                          VALUES(:zname,:zdesc,:zorder,:zvisible,:zcomment,:zads) ");
    	$stmt->execute(array(

    		'zname'    => $name,
    	    'zdesc'    => $desc,
    	    'zorder'   => $order,
    	    'zvisible' => $Visible,
    	    'zcomment' => $comment,
    	    'zads'     => $ads
    	                    ));

    	 //echo success msg

    	$theMsg = '<div class="alert alert-success">'. $stmt->rowCount() .' record insert</div>';

        redirecthome($theMsg,'back',5);


                               }
                }

        else{

             $theMsg = '<div class="container alert alert-success">sorry you cant browse this page directly </div>';

    	     redirecthome($theMsg,'back',5);

              }

       echo '</div>';
    }elseif ($do == 'edit'){//page edit
    	 $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

    //select  all  data depend of the id 

     $stmt = $con->prepare("SELECT * FROM categories WHERE ID=?");
     //excute query
    	$stmt->execute(array($catid));
    //fetch the data
        $cat = $stmt->fetch();
     //row count   
    	$count = $stmt->rowCount();

    // if there such id show form	
    	if($count > 0) { ?>
               

     <h1 class="text-center">Edit Categories</h1>
			    <div class="container">
			    	<form class="form-horizontal" method="post" action="?do=update">
			    		<input class="hidden" name="catid" value="<?php echo $catid; ?>" />
			    		
			    		<!-- start name field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Name</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="name" class="form-control" value="<?php echo $cat['Name']; ?>" placeholder="Name off the category">
			    			</div>
			    		</div>	
			    		<!-- start end field -->
			    		<!-- start description field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2  control-label">Description</label>
			    			<div class="col-sm-10 col-md-6">
			                  <input type="text" name="description" class="form-control" value="<?php echo $cat['Description']; ?>" placeholder="Describe the Category">
			    			</div>
			    		</div>	
			    		<!-- end mail field -->
			    		<!-- start ordering field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Ordering</label>
			    			<div class="col-sm-10 col-md-6">
			    	          <input type="text" name="ordering" class="form-control" value="<?php echo $cat['Ordering']; ?>" placeholder="Number to arrange the category">
                            </div>
			    		</div>	
			    		<!-- end password field -->
			    		<!-- start Visible field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Visible</label>
			    			<div class="col-sm-10 col-md-6">
			                  <div>
			                  	<input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility']==0){echo'checked';} ?> />
			                  	<label for="vis-yes">Yes</label>
			                  </div>
			                    <div>
			                  	<input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility']==1){echo'checked';} ?> />
			                  	<label for="vis-no">No</label>
			                  </div>
			    			</div>
			    		</div>	
			    		<!-- end Visible field -->
			    		<!-- start commenting field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Allow Commenting</label>
			    			<div class="col-sm-10 col-md-6">
			                  <div>
			                  	<input id="com-yes" type="radio" name="comment" value="0" <?php if($cat['Allow_Comment']==0){echo'checked';} ?> />
			                  	<label for="com-yes">Yes</label>
			                  </div>
			                    <div>
			                  	<input id="com-no" type="radio" name="comment" value="1" <?php if($cat['Allow_Comment']==1){echo'checked';} ?> />
			                  	<label for="com-no">No</label>
			                  </div>
			    			</div>
			    		</div>	
			    		<!-- end commenting field -->
			    		<!-- start ads field -->
			    		<div class="form-group form-group-lg">
			    			<label class="col-sm-2 control-label">Allow Ads</label>
			    			<div class="col-sm-10 col-md-6">
			                  <div>
			                  	<input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads']==0){echo'checked';} ?> />
			                  	<label for="ads-yes">Yes</label>
			                  </div>
			                    <div>
			                  	<input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads']==1){echo'checked';} ?> />
			                  	<label for="ads-no">No</label>
			                  </div>
			    			</div>
			    		</div>	
			    		<!-- end Ads field -->
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


    }elseif ($do == 'update'){//update category


       	echo"<h1 class='text-center'>Update Category</h1>";
       	echo"<div class='container'>";

       	if($_SERVER['REQUEST_METHOD'] == 'POST'){

       		//get variable from the form

    	$id      = $_POST['catid'];
    	$name     = $_POST['name'];
    	$desc     = $_POST['description'];
    	$order    = $_POST['ordering'];
    	$Visible  = $_POST['visibility'];
    	$comment  = $_POST['comment'];
    	$ads      = $_POST['ads'];

    
    	

    	$stmt = $con->prepare("UPDATE 
    		                         categories
    		                    SET 
    		                         Name=? ,Description=?, Ordering=?, Visibility=?, Allow_Comment=?, Allow_Ads=?

    		                    WHERE ID=?");
    	$stmt->execute(array($name,$desc,$order,$Visible,$comment,$ads,$id));

    	$theMsg = '<div class="alert alert-success">'. $stmt->rowCount() .' record update</div>';

    	redirecthome($theMsg,'back',3);
    
       } else{

       	$theMsg ='<div class="alert alert-danger">sorry you cant browse this page directly </div>';

       	redirecthome($theMsg);

       }

       echo '</div>';


    }
    elseif ($do == 'delete'){//delete page



          echo '<h1 class="text-center">Delete Category</h1>';
          echo '<div class="container">';

       $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

    //select  all  data depend of the id 

     $check = checkItem('ID','categories',$catid);
    
     // if there such id show form	
    	if($check > 0) { 

    		$stmt = $con->prepare("DELETE FROM categories WHERE ID = :zuser");

    		$stmt->bindParam(":zuser",$catid);

    		$stmt->execute();

    		$theMsg = '<div class="container alert alert-success">'. $stmt->rowCount() .' record delete</div>';


            redirecthome($theMsg);

    	}	else{

    		
    		$theMsg = '<div class="container alert alert-success">this ID id not exist</div>';


            redirecthome($theMsg);

            }

        echo'</div>'; 

    }



  


   include $tpl . "footer.php";

    }

    else{

       header('Location: index.php');

       exit();
        }
  ob_end_flush();

   ?> 