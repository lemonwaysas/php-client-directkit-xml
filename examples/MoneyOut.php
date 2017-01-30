<?php
namespace LemonWay\Examples;
use LemonWay\Models\Card;
use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *		Case : Money-out : debit a wallet's balance to a bank account
 *		Steps :
 *			- RegisterWallet : creating a customer wallet
 *			- MoneyIn : debiting 10 EUR from card, and automatically sending 2 EUR to your merchant wallet
 *			- RegisterIBAN : save IBAN information for wallet
 *			- MoneyOut : debiting the 8 EUR remaining on the customer's wallet, and automatically sending 1 EUR to your merchant wallet. 7 EUR will be sent to the customer's bank account
 *		Note :
 *			- You can register many IBANs on the same wallet
 *			- When you call for a MoneyOut, you can either specify the destination IBAN's ID in ibanId parameter, or leave it empty. If left empty, the latest registered IBAN will be used
 *			- The "message" parameter in MoneyOut can be displayed on the customer's bank statement. Please contact support for more information
 */

//RegisterWallet
$walletID = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet(array('wallet' => $walletID,
    'clientMail' => $walletID.'@mail.fr',
    'clientTitle' => Wallet::MISTER,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Dupond'));
if (isset($res->lwError)){
    print '<br/>Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
print '<br/>Wallet created : ' . $res->wallet->ID;

//MoneyIn
$res2 = $api->MoneyIn(array('wkToken'=>ExamplesDatas::getRandomId(),
    'wallet'=>$walletID,
    'amountTot'=>'10.00',
    'amountCom'=>'2.00',
    'comment'=>'comment',
    'cardType'=>Card::TYPE_CB,
    'cardNumber'=>ExamplesDatas::CARD_SUCCESS_WITHOUT_3D,
    'cardCrypto'=>ExamplesDatas::CARD_CRYPTO,
    'cardDate'=>ExamplesDatas::CARD_DATE,
    'autoCommission'=>Wallet::NO_AUTO_COMMISSION,
    'isPreAuth'=>Wallet::NO_ATOS_PRE_AUTH));
if (isset($res2->lwError)){
    print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
    return;
}
print '<br/>Money-in successful. ID: '. $res2->operation->ID;

//RegisterIBAN
$res3 = $api->RegisterIBAN(array('wallet'=>$walletID,
    'holder' => ExamplesDatas::IBAN_HOLDER,
    'bic' => ExamplesDatas::IBAN_BIC,
    'iban' => ExamplesDatas::IBAN_NUMBER,
    'dom1' => ExamplesDatas::IBAN_AD1,
    'dom2' => ExamplesDatas::IBAN_AD2));
if (isset($res3->lwError)){
    print '<br/>Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
    return;
}
print '<br/>IBAN registration successful. Iban ID : '. $res3->iban->ID;

//MoneyOut
$amount = (string)$res2->operation->CRED;
$res4 = $api->MoneyOut(array('wallet' => $walletID,
    'ibanId' => '',
    'amountTot' => $amount,
    'amountCom' => '1.00',
    'message' => '',
    'autoCommission' => Wallet::NO_AUTO_COMMISSION));
if (isset($res4->lwError)){
    print '<br/>Error, code '.$res4->lwError->CODE.' : '.$res4->lwError->MSG;
    return;
}
print '<br/>Money-out successful. ID: '. $res4->operation->ID;

//GetMoneyOutTransDetails
$res5 = $api->GetMoneyOutTransDetails(array('transactionId' => $res4->operation->ID));
if (isset($res5->lwError)){
    print '<br/>Error, code '.$res5->lwError->CODE.' : '.$res5->lwError->MSG;
    return;
}
foreach ($res5->operations as $operation) {
    echo '<pre>';
    print_r($operation);
    echo '</pre>';
}
