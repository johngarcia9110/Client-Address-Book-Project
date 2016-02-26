<?php
session_start();

//if user is not logged in
if( !$_SESSION['loggedInUser']){
    
    //send to login page
    header("Location: index.php");
}
//connect to db
include('includes/connection.php');

//query and result
$query = "SELECT * FROM clients";
$result = mysqli_query( $conn, $query);

//check for query string
if( isset( $_GET['alert'])){
    if($_GET['alert'] == 'success'){
        $alertMessage = "<div class='alert alert-success'>A new client has been added!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }elseif( $_GET['alert'] == 'updatesuccess'){
        $alertMessage = "<div class='alert alert-success'>A client has been updated!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }elseif($_GET['alert'] == 'deleted'){
        $alertMessage = "<div class='alert alert-success'>Client deleted!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}
//close the mysql connection
if($conn){mysqli_close($conn);}
include('includes/header.php');
?>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-xs-12 addClient">
        <h1 id="clientTitle">Client Address Book</h1>
        <hr>
        <?php echo "$alertMessage";?>
        
            <table class="table footable ">
               <thead>
                    <tr>
                        <th>Name</th>
                        <th data-hide="phone">Email</th>
                        <th data-hide="phone">Phone</th>
                        <th data-hide="phone">Address</th>
                        <th>Company</th>
                        <th data-hide="phone">Notes</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if( mysqli_num_rows($result) > 0){
                        while( $row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>".$row['name']. "</td><td>".$row['email']."</td><td>".$row['phone']."</td><td>".$row['address']."</td><td>".$row['company']."</td><td>".$row['notes']."</td>";

                            echo '<td><a href="edit.php?id='.$row['id'].'" type="button" class="btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></a></td>';
                            echo "</tr>";
                        }
                    }else{
                        echo "<div class='alert alert-warning'>You have no clients!</div>";
                    }



                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
                    </tr>
                </tfoot>
            </table>
        
    </div>
    <div class="col-sm-2"></div>
</div>
<?php
include('includes/footer.php');
?>