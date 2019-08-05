<?php
namespace LemonWay\Examples;

use LemonWay\Models\Card;
use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Send a payment from one wallet to another
 *      Steps :
 *          - RegisterWallet : creating 2 customer wallets
 *          - MoneyIn : crediting the first wallet
 *          - SendPayment : sending the remaining amount to another wallet
 *          - GetPaymentDetails : search the payment
 */

//Create first wallet
$wallet1 = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet(array('wallet' => $wallet1,
    'clientMail' => $wallet1.'@mail.fr',
    'clientTitle' => Wallet::UNKNOWN,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Dupond'));
if (isset($res->lwError)) {
    print '<br/>Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
print '<br/>Wallet1 created : ' . $res->wallet->ID;

//Credit first wallet
$res2 = $api->MoneyIn(array('wkToken'=>ExamplesDatas::getRandomId(),
    'wallet'=>$wallet1,
    'amountTot'=>'10.00',
    'amountCom'=>'2.00',
    'comment'=>'comment',
    'cardType'=>Card::TYPE_CB,
    'cardNumber'=>ExamplesDatas::CARD_SUCCESS_WITHOUT_3D,
    'cardCrypto'=>ExamplesDatas::CARD_CRYPTO,
    'cardDate'=>ExamplesDatas::CARD_DATE,
    'autoCommission'=>Wallet::NO_AUTO_COMMISSION,
    'isPreAuth'=>Wallet::NO_ATOS_PRE_AUTH));
if (isset($res2->lwError)) {
    print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
    return;
}
print '<br/>Money-in successful. ID: '. $res2->operation->ID;

//Create second wallet
$wallet2 = ExamplesDatas::getRandomId();
$res3 = $api->RegisterWallet(array('wallet' => $wallet2,
    'clientMail' => $wallet2.'@mail.fr',
    'clientTitle' => Wallet::UNKNOWN,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Dupond2'));
if (isset($res3->lwError)) {
    print '<br/>Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
    return;
}
print '<br/>Wallet2 created : ' . $res3->wallet->ID;

//Send money from wallet1 to wallet2
$amount = $res2->operation->CRED;
$res4 = $api->SendPayment(array('debitWallet' => $wallet1,
    'creditWallet' => $wallet2,
    'amount' => $amount,
    'message' => 'my message'));
if (isset($res4->lwError)) {
    print '<br/>Error, code '.$res4->lwError->CODE.' : '.$res4->lwError->MSG;
    return;
}
print '<br/>Payment successful : '. $res4->operation->ID;

//GetPaymentDetails
$res5 = $api->GetPaymentDetails(array('transactionId' => '',
    'transactionComment' => 'my message',
    'privateData' => ''));
if (isset($res5->lwError)) {
    print '<br/>Error, code '.$res5->lwError->CODE.' : '.$res5->lwError->MSG;
    return;
}
print '<br/>Payment Details : <br />';
print '<br/>Payment ID : '. $res5->operations[0]->ID;
print '<br/>Payment Date : '. $res5->operations[0]->DATE;
print '<br/>Payment Sen : '. $res5->operations[0]->SEN;
print '<br/>Payment Rec : '. $res5->operations[0]->REC;
print '<br/>Payment Deb : '. $res5->operations[0]->DEB;
print '<br/>Payment Com : '. $res5->operations[0]->COM;
print '<br/>Payment Msg : '. $res5->operations[0]->MSG;
print '<br/>Payment Status : '. $res5->operations[0]->STATUS;
print '<br/>Payment Private data : '. $res5->operations[0]->PRIVATE_DATA;
print '<br/>Payment scheduled date : '. $res5->operations[0]->SCHEDULED_DATE;
