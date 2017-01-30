<?php
namespace LemonWay\Examples;
use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : RegisterIBANExtended : Link a non-SEPA IBAN to a wallet
 *      Steps :
 *          - RegisterWallet : creating a customer wallet
 *          - RegisterIBANExtended : non-SEPA save IBAN information for wallet
 */

//RegisterWallet
$walletID = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet(array(
    'wallet' => $walletID,
    'clientMail' => $walletID.'@mail.fr',
    'clientTitle' => Wallet::MISTER,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Dupond'
));
if (isset($res->lwError)){
    print '<br/>Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
print '<br/>Wallet created : ' . $res->wallet->ID;

//RegisterIBAN
$res3 = $api->RegisterIBANExtended(array(
    'wallet' => $walletID,
    'accountType' => "1",
    'holderName' => ExamplesDatas::IBAN_HOLDER,
    'accountNumber' => ExamplesDatas::IBAN_NUMBER,
    'holderCountry' => ExamplesDatas::IBAN_COUNTRY,
    'bicCode' => ExamplesDatas::IBAN_BIC,
    'bankCountry' => ExamplesDatas::IBAN_COUNTRY
));

if (isset($res3->lwError)) {
    print '<br/>Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
    return;
}
print '<br/>Non-SEPA IBAN registration successful. Iban ID : '. $res3->iban->ID;
