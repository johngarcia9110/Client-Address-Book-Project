<?php
session_start();

//if user is not logged in
if( !$_SESSION['loggedInUser']){
    
    //send them packin!
    header("Location: index.php");
}

//get ID sent by GET collection
$clientID = $_GET['id'];

include('includes/connection.php');
include('includes/functions.php');

$query = "SELECT * FROM clients WHERE id='$clientID'";
$result = mysqli_query( $conn, $query);

if( mysqli_num_rows($result) > 0){
    while( $row = mysqli_fetch_assoc($result)){
        $clientName     = $row['name'];
        $clientEmail    = $row['email'];
        $clientPhone    = $row['phone'];
        $clientAddress  = $row['address'];
        $clientCompany  = $row['company'];
        $clientNotes    = $row['notes'];
    }
    
}else {
    $alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='clients.php'>Head back</a>.</div>";
}
//if update button was pressed
if ( isset($_POST['update'])){
        $clientName     = validateFormData( $_POST['clientName']);
        $clientEmail    = validateFormData( $_POST['clientEmail']);
        $clientPhone    = validateFormData( $_POST['clientPhone']);
        $clientAddress  = validateFormData( $_POST['clientAddress']);
        $clientCompany  = validateFormData( $_POST['clientCompany']);
        $clientNotes    = validateFormData( $_POST['clientNotes']);
    //new db query and result
    
    $query = "UPDATE clients 
    SET name='$clientName',
    email='$clientEmail',
    phone='$clientPhone',
    address='$clientAddress',
    company='$clientCompany',
    notes='$clientNotes'
    WHERE id='$clientID'";
    
    $result = mysqli_query( $conn, $query);
    if( $result ){
        header("Location:clients.php?alert=updatesuccess");
    }else{
        echo "Error updating record:".mysqli_error($conn);
    }
}
if(isset($_POST['delete'])){
    $alertMessage = "<div class='alert alert-danger'>
    <p>Are you sure you want to delete this client?</p><br>
    <form action='". htmlspecialchars( $_SERVER["PHP_SELF"])."?id=$clientID' method='post'>
    <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
    <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Opps, no Thanks!</a>
    </div>";
}
if( isset($_POST['confirm-delete'])){
    $query = "DELETE FROM clients WHERE id='$clientID'";
    $result = mysqli_query($conn, $query);
    
    if( $result){
        header("Location: clients.php?alert=deleted");
    }else{
        echo "Error updating record:".mysqli_error($conn);
    }
}
if($conn){mysqli_close($conn);}

include('includes/header.php');
?>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8 addClient">
        <h1 id="clientTitle">Update <?php echo $clientName;?>'s Info</h1>
        <hr>
        <?php echo $alertMessage; ?>
        <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>?id=<?php echo $clientID; ?>" method="post" class="row">
            <div class="form-group col-sm-6">
                <label for="client-name">Name</label>
                <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $clientName;?>">
            </div>
            <div class="form-group col-sm-6">
                <label for="client-email">Email</label>
                <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $clientEmail;?>">
            </div>
            <div class="form-group col-sm-6">
                <label for="client-phone">Phone</label>
                <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $clientPhone;?>">
            </div>
            <div class="form-group col-sm-6">
                <label for="client-address">Address</label>
                <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="<?php echo $clientAddress;?>">
            </div>
            <div class="form-group col-sm-6">
                <label for="client-company">Company</label>
                <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo $clientCompany;?>">
            </div>
            <div class="form-group col-sm-6">
                <label for="client-notes">Notes</label>
                <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"><?php echo $clientNotes;?></textarea>
            </div>
            <div class="col-sm-12">
                <hr>
                <button type="submit" class="btn btn-lg btn-sm btn-danger pull-left" name="delete">Delete</button>
                <div class="pull-right">
                    <a href="clients.php" type="button" class="btn btn-lg btn-sm btn-default">Cancel</a>
                    <button type="submit" class="btn btn-lg btn-sm btn-success" name="update">Update</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-2"></div>
</div>

<?php
include('includes/footer.php');
?>