<?php
namespace LemonWay\Examples\MoneyInIDeal;
use LemonWay\Examples\ExamplesDatas;
require_once '../../LemonWay/Autoloader.php';
require_once '../ExamplesDatas.php';
$token = ExamplesDatas::getRandomId();

if (isset ($_GET) && sizeof($_GET) > 0){
    //user browser is returning from payment
    print 'GET : ';
    foreach ($_GET as $key => $value) {
        print ('<br/>'.$key.' : '.$value.'');
    }

    //call GetMoneyInTransDetails to retrieve payment status, and proceed depending on result.
    $merchantToken = $_GET['token'];
    include './MoneyInIDealConfirm.php';

} else {
    //initialize the 3D Secure payment
    include './MoneyInIDealInit.php';
}