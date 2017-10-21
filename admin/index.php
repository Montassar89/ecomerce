<?php 
    session_start();
    $noNavBar  = '';
    $pagetitle = 'Login';
    if(isset($_SESSION['Username'])){
       header('Location: dashboard.php');//redirection page dash.php
    }

    include "init.php";
    

    // check method request

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    	$username = $_POST['user'];
    	$password = $_POST['pass'];
    	$hashedPass = sha1($password);
        

    // check if thr user exist in database

    	$stmt = $con->prepare("SELECT UserID,Username, Password FROM users WHERE Username=? AND Password=? AND groupID=1 LIMIT 1");
    	$stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
    	$count = $stmt->rowCount();

    //if count() > 0 user exist	

    if( $count > 0){
    	$_SESSION['Username'] = $username;//register session name
        $_SESSION['User'] = $row['UserID'];//register session id
    	header('Location: dashboard.php');
    	exit();

    }	

    }
?>

			<form class="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<h1 class="text-center">admin login</h1>
				<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
				<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="off" />
				<button class="btn btn-primary btn-block">Login</button>
			</form>
             

<?php 
    include $tpl . "footer.php";
?>