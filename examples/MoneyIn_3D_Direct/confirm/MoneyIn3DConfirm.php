<?php
namespace LemonWay\Examples;

use LemonWay\Models\Operation;
use LemonWay\Models\Wallet;

require_once '../../ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : This follows the MoneyIn3DInit case : your customer has returned to your website or you have received a POST notification from Lemon Way.
 *              You now need to find out how the payment went.
 *      Steps :
 *          - GetMoneyInTransDetails
 *          - MoneyIn3DConfirm
 */

$res = $api->GetMoneyInTransDetails(array('transactionMerchantToken'=>$merchantToken));
if (isset($res->lwError)) {
    print '<br/>Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
if (count($res->operations) != 1) {
    print '<br/>Error, too many results : '.count($res->operations);
    //TODO : error to handle. Check if your merchant Token is unique
    return;
} else {
    $current = $res->operations[0];

    // Now you need to confirm with the transaction id
    $res2 = $api->MoneyIn3DConfirm(array('transactionId'=>$current->ID,
                                            'isPreAuth'=>Wallet::NO_ATOS_PRE_AUTH));
    if (isset($res2->lwError)) {
        print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
        return;
    }

    if ((string)$res2->operation->STATUS == Operation::STATUS_SUCCES) {
        print '<br/>Money-in successful : ';
        print '<br/>ID : '. $res2->operation->ID;
        print '<br/>AMOUNT : '. $res2->operation->CRED;
        print '<br/>AUTHORIZATION NUMBER : '. $res2->operation->EXTRA->AUTH;
        /* TODO: examples of things to do :
            -display a payment successful message
            -mark the payment as successful in your database
            -send a confirmation email if it wasn't already sent
        */
    } elseif ((string)$res2->operation->STATUS == Operation::STATUS_ERROR) {
        print '<br/>Money-in failed : ';
        print '<br/>ID : '. $res2->operation->ID;
        print '<br/>AMOUNT : '. $res2->operation->CRED;
        print '<br/>AUTHORIZATION NUMBER : '. $res2->operation->EXTRA->AUTH;
        /* TODO: examples of things to do :
            -if $isFromGET = true, display a payment failed message
            -mark the payment as failed in your database
        */
    } elseif ((string)$res2->operation->STATUS == Operation::STATUS_AWAITING_VALIDATION) {
        print '<br/>Money-in pending : ';
        print '<br/>ID : '. $res2->operation->ID;
        print '<br/>AMOUNT : '. $res2->operation->CRED;
        print '<br/>AUTHORIZATION NUMBER : '. $res2->operation->EXTRA->AUTH;
        /* TODO: examples of things to do :
            -display a payment pending message.
            -you are here if you use 'isPreAuth'=>Wallet::ATOS_PRE_AUTH and delayedDays
                so you'll have X days to do MoneyInValidate
        */
    }
}
