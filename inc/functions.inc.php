<?php 
// 1. creating a debugging functions

function debug($mavar){
    echo '<pre class="alert alert-warning">';

    var_dump($mavar);

    echo '</pre>';
}
/* we use this function only while developing the website . 
WE MUST REMOVE IT WHEN IT GOES ONLINE. NO DEBUG FUNCTIONS.
*/


// 2. creating a function to verify that the user is connected

function estConnecte(){
    if(isset($_SESSION['users'])){ // if we find an index 'users' inside the $_SESSION superglobal, it means someone is connected
        return true;
    }else{ // else...no one is connected.
        return false;
    }
}

// 3. creating a function to verify that a connected user is ADMIN.

function estAdmin(){ // we check that the user is connected and his status is == 1 in the DB, meaning admin.
    if(estConnecte() && $_SESSION['users']['statut'] == 1){
        return true;
    }else { // else is a random user, or not connected.
        return false;
    }

}
// 4. functions for cart session

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}