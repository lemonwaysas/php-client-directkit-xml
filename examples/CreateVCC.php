<?php
namespace LemonWay\Examples;
use LemonWay\Models\Operation;
use LemonWay\Models\Wallet;
use LemonWay\Models\Card;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Create Virtual Credit Card
 *      Steps :
 *          - RegisterWallet : creating customer wallet
 *          - MoneyIn : debiting 20 EUR from card, and automatically sending 2 EUR to your wallet (merchant).
 *          - CreateVCC : Create a Virtual Credit Card from the Wallet
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


    $res2 = $api->MoneyIn(array('wkToken'=>ExamplesDatas::getRandomId(),
        'wallet'=>$walletID,
        'amountTot'=>'20.00',
        'amountCom'=>'2.00',
        'comment'=>'comment',
        'cardType'=>Card::TYPE_CB,
        'cardNumber'=>ExamplesDatas::CARD_SUCCESS_WITHOUT_3D,
        'cardCrypto'=>ExamplesDatas::CARD_CRYPTO,
        'cardDate'=>ExamplesDatas::CARD_DATE,
        'autoCommission'=>Wallet::NO_AUTO_COMMISSION,
        'isPreAuth'=>Wallet::NO_ATOS_PRE_AUTH));
    if (isset($res2->lwError)){
        print 'Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
        return;
    }

    if ((string)$res2->operation->STATUS == Operation::STATUS_SUCCES) //if isPreAuth = 0
        print '<br/>Money-in successful : ';
    elseif ((string)$res2->operation->STATUS == Operation::STATUS_AWAITING_VALIDATION) //if isPreAuth = 1
        print '<br/>Money-in successful (pending validation) : ';
    print '<br/>ID : '. $res2->operation->ID;
    print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $res2->operation->CRED;
    print '<br/>CARD : '. $res2->operation->MLABEL;
    print '<br/>AUTHORIZATION NUMBER : '. $res2->operation->EXTRA->AUTH;



    //Create Virtual Credit Card
    $res3 = $api->CreateVCC(array('debitWallet' => $walletID,
        'amountVCC' => '10.00'));
    if (isset($res3->lwError)){
        print '<br />Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
        return;
    }

    print '<br/>ID : '. $res3->operation->ID;
    print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $res3->operation->CRED;
    print '<br/>COMMISSION : '. $res3->operation->COM;
    print '<br/>VCC :<br/> ID : '. $res3->operation->VCC->ID;
    print '<br/> NUM : '. $res3->operation->VCC->NUM;
    print '<br/> EDATE : '. $res3->operation->VCC->EDATE;
    print '<br/> CVX : '. $res3->operation->VCC->CVX;

}
