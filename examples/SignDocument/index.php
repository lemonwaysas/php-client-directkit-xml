<?php

namespace LemonWay\Examples\SigninDocument;
use LemonWay\Models\KycDoc;


/**
 * This page handles the signing document workflow :
 *
 *  1 - If not POST nor GET, launches the signing
 *  2 - Handles returns, success and error
 */
if (isset($_POST) && sizeof($_POST) > 0){
    //notification from Lemon Way's server. Will not work if you're testing using a local return URL
    foreach ($_POST as $key => $value) {
        // Write to server error log for example purpose
        error_log('<br/>'.$key.' : '.$value.'');
    }

    print('<hr/><br />POST SUCCESS');
} else if (isset ($_GET) && sizeof($_GET) > 0){
    //user browser is returning from signing
    print 'GET : ';
    foreach ($_GET as $key => $value) {
        print ('<br/>'.$key.' : '.$value.'');
    }
    if (isset($_GET['url'])){

        $response = $_GET['url'];
        if($response == KycDoc::SIGNING_SUCCESS){
            print('<hr/><br />GET SUCCESS FOR '.$_GET['signingtoken']);
        }else{
            print('<hr/><br />GET ERROR FOR '.$_GET['signingtoken']);
        }
    }
} else {
    //initialize the Signing
    include './SignDocumentInit.php';
}