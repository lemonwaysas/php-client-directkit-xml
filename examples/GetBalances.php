<?php
namespace LemonWay\Examples;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *		Case : Get Balances Wallets
 *		Steps :
 *			- GetBalances : Use "GetBalances" to retrieve the list of wallets updated since a given date.
 */

//GetBalances
$res = $api->GetBalances(array('updateDate' => '1'));
if (isset($res->lwError)){
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
foreach ($res->wallets as $wallet) {
    echo '<pre>';
    print_r($wallet);
    echo '</pre>';
}
