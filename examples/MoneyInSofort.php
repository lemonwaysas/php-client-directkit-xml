<?php
namespace LemonWay\Examples;
use LemonWay\Models\Wallet;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Money-in Sofort
 *      Steps :
 *          - RegisterWallet : creating customer wallet
 *          - MoneyInSofortInit : provisionning sofort payment with 15 EUR, and automatically sending 1 EUR to your wallet (merchant).
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

    //MoneyIn Sofort Init
    $res2 = $api->MoneyInSofortInit(array('wallet' => $walletID,
        'wkToken'=>ExamplesDatas::getRandomId(),
        'amountTot' => '15.00',
        'amountCom' => '1.00',
        'comment' => 'comment',
        'returnUrl' => 'https://www.yoursite.com/payment_return.php/?id=367GBD',
        'autoCommission' => Wallet::NO_AUTO_COMMISSION));
    if (isset($res2->lwError)){
        print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
        return;
    }

    print '<br/>ID : '. $res2->lwXml->SOFORTINIT->ID;
    print '<br/>Action URL: '. $res2->lwXml->SOFORTINIT->actionUrl;

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
