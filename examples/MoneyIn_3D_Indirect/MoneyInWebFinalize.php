<?php

namespace LemonWay\Examples;

use LemonWay\Models\Operation;

require_once '../ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : This follows the MoneyInWebInit case : your customer has returned to your website or you have received a
 *      POST notification from Lemon Way. You now need to find out how the payment went. Steps :
 *          - GetMoneyInTransDetails
 *      Note :
 *          - In this example, we print data, but keep in mind that if you arrive here from the Lemon Way notification
 *          (with POST data), printing will be pointless. You can log data in a file instead.
 *          - You have defined 3 return urls (success, error, cancel), but it is still recommended to make this call in
 *          order to verify the information and to make sure the POST or GET data were not maliciously modified.
 *          - If the status is SUCCESS (3) or ERROR (4), then it's a final status, it won't change.
 *          - If the status is still PENDING (0), then the status can still change : it means your customer has
 *          cancelled the payment or returned to your website, or something else that made them arrive on one of your
 *          return urls, without finishing their payment. The customer will still be able to go back to the payment
 *          form using the browser's back button, and make the payment. You should either :
 *              - just like Lemon Way, not change the payment status and still give your customer the opportunity to
 *              pay
 *              - decide to mark the payment as failed on your side, but keep in mind that this won't prevent Lemon Way
 *              from accepting the payment if the customer pays.
 */

$res = $api->GetMoneyInTransDetails([
    'transactionId'            => $moneyInID,
    'transactionComment'       => '',
    'transactionMerchantToken' => $merchantToken,
]);
if (isset($res->lwError)) {
    print '<br/>Error, code ' . $res->lwError->CODE . ' : ' . $res->lwError->MSG;

    return;
}
if (count($res->operations) != 1) {
    print '<br/>Error, too many results : ' . count($res->operations);

    return;
} else {
    if ((string) $res->operations[0]->STATUS == Operation::STATUS_SUCCES) {
        print '<br/>Money-in successful : ';
        print '<br/>ID : ' . $res->operations[0]->ID;
        print '<br/>AMOUNT : ' . $res->operations[0]->CRED;
        print '<br/>AUTHORIZATION NUMBER : ' . $res->operations[0]->EXTRA->AUTH;
    } elseif ((string) $res->operations[0]->STATUS == Operation::STATUS_ERROR) {
        print '<br/>Money-in failed : ';
        print '<br/>ID : ' . $res->operations[0]->ID;
        print '<br/>AMOUNT : ' . $res->operations[0]->CRED;
        print '<br/>AUTHORIZATION NUMBER : ' . $res->operations[0]->EXTRA->AUTH;
    } elseif ((string) $res->operations[0]->STATUS == Operation::STATUS_WAITING_FINALISATION) {
        print '<br/>Money-in pending : ';
        print '<br/>ID : ' . $res->operations[0]->ID;
        print '<br/>AMOUNT : ' . $res->operations[0]->CRED;
        print '<br/>AUTHORIZATION NUMBER : ' . $res->operations[0]->EXTRA->AUTH;
    }
}
