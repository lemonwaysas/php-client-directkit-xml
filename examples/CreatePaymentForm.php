<?php
namespace LemonWay\Examples;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Create Payment Form
 *      Steps :
 *          - CreatePaymentForm : Use "CreatePaymentForm" to create a payment form.
 *          - Click on "Disable this payment form" to disable it
 */

$res = $api->CreatePaymentForm(array(
    'optId' => 'SDKTEST'
));

if (isset($res->lwError)){
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}

echo '<pre>';
print ("<a target='_blank' href='" . $api->config->wkUrl . "payment-page/?fId=" . $res->lwXml->FORM->id . "' >" . $api->config->wkUrl . "payment-page/?fId=" . $res->lwXml->FORM->id . "</a>");
print ("<br /><a target='_blank' href='DisablePaymentForm.php?id=" . $res->lwXml->FORM->id . "'>Disable this payment form</a>");
echo '</pre>';

?>