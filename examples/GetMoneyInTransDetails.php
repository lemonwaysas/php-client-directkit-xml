<?php
namespace LemonWay\Examples;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *		Case : search for money-in operation
 *		Steps :
 *			- GetMoneyInTransDetails : searching for a money-in, by your merchant token or by comment, or by ID
 *		Note :
 *			- leave parameter empty if you don't want to use it as search field
 *			- at least one search field required
 */

$res = $api->GetMoneyInTransDetails(array('transactionId'=>'',
    'transactionComment'=>'comment',
    'transactionMerchantToken'=>''));
if (isset($res->lwError))
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
else
    print '<br/>'.count($res->operations).' operations found.';