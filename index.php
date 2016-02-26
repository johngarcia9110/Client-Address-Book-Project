<?php
session_start();

include('includes/functions.php');

//if login form was sumbited
if( isset( $_POST['login'])){
    
   //create variables
    $formEmail = validateFormData( $_POST['email'] );
    $formPass = validateFormData( $_POST['password'] );
    
    //connect to database
    include('includes/connection.php');
    
    //create query
    $query = "SELECT name, password FROM users WHERE email='$formEmail'";
    
    //store the result
    $result = mysqli_query($conn, $query);
    
    //verify if result is returned
    if( mysqli_num_rows($result) > 0){
        
        //store basic user data in variables
        while( $row = mysqli_fetch_assoc($result)){
            $name       = $row['name'];
            $hashedPass = $row['password'];
        }
        
        //verify hashed password with submitted password
        if( password_verify( $formPass, $hashedPass)){
            
            //correct login details
            //store data in session variables
            $_SESSION['loggedInUser'] = $name;
            
            //redirect user to clients page
            header("Location: clients.php");
            
        }else{//hashed password did not verify
            
            //error message
            $loginError = "<div class='alert alert-danger'>Wrong username/password combination. Please try again.<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    }else{//no results in database
        //error message
        $loginError = "<div class='alert alert-danger'>This user does not exist. Please try again.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}

//close connection
if($conn){mysqli_close($conn);}


include('includes/header.php');

//$password = password_hash("mysecretpassword", PASSWORD_DEFAULT);
//echo $password;

?>

<div class="row">
   <div class="col-sm-4 center-block" id="loginArea">
        <h1 id="headerSign">Client Address Book</h1>
        <p class="lead" id="pSign">Log in to your account.</p>
        
        <?php echo $loginError; ?>
       
        <form class="form-inline" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']);?>" method="post">
            <div class="form-group">
                <label for="login-email" class="sr-only">Email</label>
                <input type="text" class="form-control" id="login-email" placeholder="email" name="email" value="<?php echo $formEmail;?>">
            </div>
            <div class="form-group">
                <label for="login-password" class="sr-only">Password</label>
                <input type="password" class="form-control" id="login-password" placeholder="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" id="btn-purple" name="login">Login</button>
        </form>
    </div>
</div>
<?php
include('includes/footer.php');
?>