<?php
namespace LemonWay\Examples;
use LemonWay\Models\Card;
use LemonWay\Models\Wallet;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *		Case : Save a bank card for later rebills. No 3D Secure.
 *		Steps :
 *			- RegisterWallet : creating customer wallet
 *			- RegisterCard : link a bank card to the wallet
 *			- MoneyInWithCardId : debit the card once
 *			- MoneyInWithCardId : debit the card again
 */

//RegisterWallet
$wallet = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet(array('wallet' => $wallet,
    'clientMail' => $wallet.'@mail.fr',
    'clientTitle' => Wallet::UNKNOWN,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Dupond'));
if (isset($res->lwError)){
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
print '<br/>Wallet created : ' . $res->wallet->ID;

//RegisterCard
$res2 = $api->RegisterCard(array('wallet'=>$wallet,
    'cardType'=>Card::TYPE_CB,
    'cardNumber'=>ExamplesDatas::CARD_SUCCESS_WITHOUT_3D,
    'cardCode'=>ExamplesDatas::CARD_CRYPTO,
    'cardDate'=>ExamplesDatas::CARD_DATE));
if (isset($res2->lwError)){
    print 'Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
    return;
}
print '<hr/><br/>Card saved. ID : '.$res2->card->ID;
if(isset($res2->card->EXTRA)){
    print '<br/>Card EXTRA AUTH : '.$res2->card->EXTRA->AUTH;
    print '<br/>Card EXTRA CTRY : '.$res2->card->EXTRA->CTRY;
}

//MoneyInWithCardId
$res3 = $api->MoneyInWithCardId(array('wkToken'=>ExamplesDatas::getRandomId(),
    'wallet'=>$wallet,
    'amountTot'=>'10.00',
    'amountCom'=>'2.00',
    'comment'=>'comment',
    'cardId'=>$res2->card->ID,
    'autoCommission'=>'0',
    'isPreAuth'=>'0'));
if (isset($res3->lwError)){
    print 'Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
    return;
}

print '<hr/><br/>Money-in successful : ';
print '<br/>ID : '. $res3->operation->ID;
print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $res3->operation->CRED;
print '<br/>CARD : '. $res3->operation->MLABEL;
print '<br/>AUTHORIZATION NUMBER : '. $res3->operation->EXTRA->AUTH;

//MoneyInWithCardId
$res4 = $api->MoneyInWithCardId(array('wkToken'=>ExamplesDatas::getRandomId(),
    'wallet'=>$wallet,
    'amountTot'=>'11.00',
    'amountCom'=>'2.00',
    'comment'=>'comment',
    'cardId'=>(string)$res2->lwXml->CARD->ID,
    'autoCommission'=>'0',
    'isPreAuth'=>'0'));
if (isset($res4->lwError)){
    print 'Error, code '.$res4->lwError->CODE.' : '.$res4->lwError->MSG;
    return;
}

print '<hr/><br/>Another Money-in successful : ';
print '<br/>ID : '. $res4->operation->ID;
print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $res4->operation->CRED;
print '<br/>CARD : '. $res4->operation->MLABEL;
print '<br/>AUTHORIZATION NUMBER : '. $res4->operation->EXTRA->AUTH;