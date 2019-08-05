<?php
namespace LemonWay\Examples;

use LemonWay\Models\Card;
use LemonWay\Models\Operation;

require_once '../../ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : This follows the MoneyIn3DInit case : your customer has returned to your website after a 3DS Authentication
 *              You now want to find out how the authentication went.
 *      Steps :
 *          - GetMoneyInTransDetails to retrieve transaction id and wallet id, and proceed depending on result.
 *          - MoneyIn3DAuthenticate
 *          - RegisterCard
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
    $res2 = $api->MoneyIn3DAuthenticate(array('transactionId'=>$current->ID));
    if (isset($res2->lwError)) {
        print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
        return;
    }

    switch ($res2->lwXml->MONEYIN->O3D_CODE) {
        case Operation::OWNER_AUTHENTICATED:
            print '<br/>User authentication successful ! ';
            print '<br/>Registering card ! ';
            //RegisterCard
            $res3 = $api->RegisterCard(array('wallet'=>$current->REC,
                'cardType'=>Card::TYPE_CB,
                'cardNumber'=>ExamplesDatas::CARD_SUCCESS_WITH_3D,
                'cardCode'=>ExamplesDatas::CARD_CRYPTO,
                'cardDate'=>ExamplesDatas::CARD_DATE));
            if (isset($res3->lwError)) {
                print 'Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
                return;
            }
            print '<hr/><br/>Card saved. ID : '.$res3->card->ID;

            break;
        case Operation::OWNER_NOT_AUTHENTICATED:
            print '<br/>User authentication fail ! ';

            break;
        case Operation::OWNER_BY_PASS_ON_ACS:
            print '<br/>User authentication by-pass ! ';

            break;
    }
}
