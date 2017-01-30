<?php
namespace LemonWay\Examples;
use LemonWay\Models\Card;
use LemonWay\Models\Operation;
use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Money-in without 3D Secure
 *      Steps :
 *          - RegisterWallet : creating customer wallet
 *          - MoneyIn : debiting 10 EUR from card, and automatically sending 2 EUR to your wallet (merchant).
 *          - GetWalletTransHistory : get transactions history of the wallet
 *
 *       Note :
 *          - Lemon Way will automatically debit its fees from merchant wallet
 *          - After the MoneyIn call, 8 EUR will remain on customer wallet
 *          - The wkToken input can later be used to search for this payment
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
