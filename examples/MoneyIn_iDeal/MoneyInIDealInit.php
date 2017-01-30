<?php
namespace LemonWay\Examples;
use LemonWay\Models\IDeal;
use LemonWay\Models\Wallet;

require_once '../ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

$returnUrl = ExamplesBootstrap::HOST.'/examples/MoneyIn_iDeal/index.php?token='.$token;

/**
 *		Case : Initialize a Money-in with iDeal
 *		Steps :
 *			- RegisterWallet : creating a customer wallet
 *			- MoneyInIDealInit : initialize iDeal payment
 *		Note :
 *			- Make sure you use a unique wkToken in input. You will use it to search for the payment when the customer comes back to your website after paying.
 *			- Atos/BNP test site has an invalid certificate. Please ignore the warning displayed by your browser and proceed.
 */

//RegisterWallet
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
    $res2 = $api->MoneyInIDealInit(array(
        'wallet'=>$walletID,
        'amountTot'=>'10.00',
        'amountCom'=>'2.00',
        'comment'=>'comment',
        'issuerId' => IDeal::ISSUER_TEST_BANK,
        'returnUrl'=>htmlentities($returnUrl),
        'autoCommission'=>Wallet::NO_AUTO_COMMISSION));
    if (isset($res2->lwError)){
        print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
        return;
    }
    print '<br/>Init successful. ID: '. $res2->lwXml->IDEALINIT->ID;
    print '<br/>Redirecting to url ... ';
    header('Location: '.urldecode($res2->lwXml->IDEALINIT->actionUrl));
}