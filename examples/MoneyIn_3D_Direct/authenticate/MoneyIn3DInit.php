<?php
namespace LemonWay\Examples;
use LemonWay\Models\Card;
use LemonWay\Models\Wallet;

require_once '../../ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *		Case : Initialize a Money-in with 3D Secure in direct mode with atos
 *		Steps :
 *			- RegisterWallet : creating a customer wallet
 *			- MoneyIn3DInit : initializing the payment. The output will contain the url where the user should be redirected to achieve 3D secure.
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

    $token = ExamplesDatas::getRandomId();

    // Atos doesn't return anything so you must keep a ref to your operation
    $returnUrl = ExamplesBootstrap::HOST.'/examples/MoneyIn_3D_Direct/authenticate/index.php?token='.$token;

    $res2 = $api->MoneyIn3DInit(array('wkToken'=>$token,
        'wallet'=>$walletID,
        'amountTot'=>'10.00',
        'amountCom'=>'2.00',
        'comment'=>'comment for tx '.$token,
        'cardType'=>Card::TYPE_CB,
        'cardNumber'=>ExamplesDatas::CARD_SUCCESS_WITH_3D,
        'cardCode'=>ExamplesDatas::CARD_CRYPTO,
        'cardDate'=>ExamplesDatas::CARD_DATE,
        'returnUrl'=>htmlentities($returnUrl),
        'autoCommission'=>Wallet::NO_AUTO_COMMISSION));
    if (isset($res2->lwError)){
        print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
        return;
    }
    print '<br/>Init successful. GO TO : '. urldecode($res2->acs->actionUrl);
    header('Location: '.urldecode($res2->acs->actionUrl));
}
