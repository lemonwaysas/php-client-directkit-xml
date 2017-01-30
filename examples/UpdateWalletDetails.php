<?php
namespace LemonWay\Examples;
use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *		Case : UpdateWalletDetails
 *		Steps :
 *			- RegisterWallet : creating customer wallet
 *			- UpdateWalletDetails : update wallet information. In this example, we change the email and the address
 */

//RegisterWallet
$walletID = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet(array('wallet' => $walletID,
    'clientMail' => $walletID.'@mail.fr',
    'clientTitle' => Wallet::MISTER,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Dupond'));
if (isset($res->lwError)){
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
print '<br/>Wallet created : ' . $res->wallet->ID;

//UpdateWalletDetails
$res2 = $api->UpdateWalletDetails(array('wallet'=>$walletID,
    'newEmail'=>$walletID.'@mail2.fr',
    'newStreet'=>'My street',
    'newPostCode'=>'1234567',
    'newCity'=>'My city',
    'newCtry'=>'FRA'));

echo '<pre>'.$res2->lwXml->__toString().'</pre>';

if (isset($res2->lwError)){
    print 'Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
    return;
}
print '<br/>Wallet updated : ' . $res2->wallet->ID;