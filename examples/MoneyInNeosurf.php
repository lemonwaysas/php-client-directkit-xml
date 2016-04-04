<?php
namespace LemonWay\Examples;
use LemonWay\Models\Wallet;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

$ticketNeoSurf = '2651261983'; //PROVIDED BY LEMONWAY API DOC

/**
 *      Case : Money-in Neosurf
 *      Steps :
 *          - RegisterWallet : creating customer wallet
 *          - MoneyInNeosurf : Payment 15 EUR with neosurf, and automatically sending 1 EUR to your wallet (merchant).
 *          - GetWalletTransHistory : get transactions history of the wallet
 *
 *       Note :
 *          - Lemon Way will automatically debit its fees from merchant wallet
 */

$walletID = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet(array('wallet' => $walletID,
    'clientMail' => $walletID.'@mail.fr',
    'clientTitle' => Wallet::MISTER,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Dupond'));
if (isset($res->lwError))
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
else {
    print '<br/>Wallet created : ' . $res->wallet->ID;

    //MoneyIn Neosurf
    $res2 = $api->MoneyInNeosurf(array('wallet' => $walletID,
        'amountTot' => '15.00',
        'amountCom' => '1.00',
        'comment' => 'comment',
        'idTicket' => $ticketNeoSurf,
        'isNeocode' => '0',
        'wkToken' => ExamplesDatas::getRandomId()));
    if (isset($res2->lwError)){
        print '<br />Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
        return;
    }

    print '<br/>ID : '. $res2->operation->ID;
    print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $res2->operation->CRED;
    print '<br/>COMMISSION : '. $res2->operation->COM;
    print '<br/>STATUS : '. $res2->operation->STATUS;

    //Transaction history
    $res = $api->GetWalletTransHistory(array('wallet' => $walletID));
    if (isset($res->lwError)) {
        print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    } else {
        foreach ($res->operations as $operation) {
            echo '<pre>';
            print_r($operation);
            echo '</pre>';
        }
    }
}
