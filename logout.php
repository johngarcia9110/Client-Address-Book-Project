<?php
session_start();
//did user's browser send  a cookie for session?
if( isset( $_COOKIE[ session_name()])){
    
    //empty cookie
    setcookie( session_name(), '', time()-86400, '/');
}

//clear all session variables
session_unset();

//destroy the session
session_destroy();

include('includes/header.php');
?>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8 textcenter addClient">
        <h1 id="headerSign">Logged out</h1>

        <p class="lead" id="pSign">You've been logged out. See you next time!</p>
    </div>
    <div class="col-sm-2"></div>
</div>

<?php
include('includes/footer.php');
?>