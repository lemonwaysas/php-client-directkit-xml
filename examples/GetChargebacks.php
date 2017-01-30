<?php
namespace LemonWay\Examples;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *		Case : getChargebacks
 *		Steps :
 *			- GetChargebacks : Use "GetChargebacks" to retrieve the list of chargebacks recorded since a given date.
 */

//RegisterWallet
$res = $api->GetChargebacks(array('updateDate' => '1373448225'));
if (isset($res->lwError)){
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
foreach ($res->operations as $operation) {
    echo '<pre>';
    print_r($operation);
    echo '</pre>';
}
