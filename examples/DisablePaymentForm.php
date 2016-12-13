<?php
namespace LemonWay\Examples;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Disable Payment Form
 *      Steps :
 *          - DisablePaymentForm : Use "DisablePaymentForm" to disable a payment form.
 */

$formId = $_GET['id'];

$res = $api->DisablePaymentForm(array(
    'formId' => $formId
));

if (isset($res->lwError)){
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}

echo '<pre>';
print ($res->lwXml->message);
print ("<br />This <a target='_blank' href='" . $api->config->wkUrl . "payment-page/?fId=" . $formId . "'>payment form</a> has been disabled.");
echo '</pre>';
?>