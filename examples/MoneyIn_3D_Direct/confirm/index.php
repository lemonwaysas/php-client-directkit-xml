<?php

//Money-in by card with 3D Secure, using Atos/BNP card form in direct mode
if (isset($_GET) && sizeof($_GET) > 0) {
    //user browser is returning from payment
    print 'GET : ';
    foreach ($_GET as $key => $value) {
        print ('<br/>GET '.$key.' : '.$value.'');
    }
    if (isset($_GET['token'])) {
        //call GetMoneyInTransDetails to retrieve payment status, and proceed depending on result.
        $merchantToken = $_GET['token'];
        include './MoneyIn3DConfirm.php';
    }
} else {
    //initialize the 3D Secure payment
    include './MoneyIn3DInit.php';
}
