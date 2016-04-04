<?php

/**
 * A typical use-case: you want to allow your user to save a card for rebills (RegisterCard),
 * but first, you want to make sure that the card belongs to the user and that the user can authenticate successfully.
 */

//Money-in by card with 3D Secure, using Atos/BNP card form in direct mode
if (isset ($_GET) && sizeof($_GET) > 0){
    //user browser is returning from payment
    print 'GET : ';
    foreach ($_GET as $key => $value) {
        print ('<br/>GET '.$key.' : '.$value.'');
    }
    if (isset($_GET['token'])){
        $merchantToken = $_GET['token'];
        include './MoneyIn3DAuthenticate.php';
    }
} else {
    //initialize the 3D Secure payment
    include './MoneyIn3DInit.php';
}