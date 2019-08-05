<?php

namespace LemonWay\Examples;

use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Money-in Cheque
 *      Steps :
 *          - RegisterWallet : creating customer wallet
 *          - MoneyInChequeInit : provisionning cheque with 15 EUR, and automatically sending 1 EUR to your wallet
 *          (merchant).
 *          - GetMoneyInChequeDetails : search history
 *       Note :
 *          - Lemon Way will automatically debit its fees from merchant wallet
 */

$walletID = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet([
    'wallet'          => $walletID,
    'clientMail'      => $walletID . '@mail.fr',
    'clientTitle'     => Wallet::MISTER,
    'clientFirstName' => 'Paul',
    'clientLastName'  => 'Dupond',
]);
if (isset($res->lwError)) {
    print 'Error, code ' . $res->lwError->CODE . ' : ' . $res->lwError->MSG;
} else {
    print '<br/>Wallet created : ' . $res->wallet->ID;

    //MoneyIn Cheque Init
    $res2 = $api->MoneyInChequeInit([
        'wallet'         => $walletID,
        'amountTot'      => '15.00',
        'amountCom'      => '1.00',
        'comment'        => 'comment',
        'autoCommission' => Wallet::NO_AUTO_COMMISSION,
        'transferId'     => '',
    ]);
    if (isset($res2->lwError)) {
        print 'Error, code ' . $res2->lwError->CODE . ' : ' . $res2->lwError->MSG;

        return;
    }

    print '<br/>ID : ' . $res2->operation->ID;
    print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): ' . $res2->operation->CRED;
    print '<br/>COMMISSION : ' . $res2->operation->COM;

    //GetMoneyInChequeDetails history
    $res = $api->GetMoneyInChequeDetails(['updateDate' => '1373448225']);
    if (isset($res->lwError)) {
        print 'Error, code ' . $res->lwError->CODE . ' : ' . $res->lwError->MSG;
    } else {
        foreach ($res->operations as $operation) {
            echo '<pre>';
            print_r($operation);
            echo '</pre>';
        }
    }
}
