<?php
namespace LemonWay\Examples;
use LemonWay\Models\KycDoc;
use LemonWay\Models\SddMandate;
use LemonWay\Models\Wallet;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';

$api = ExamplesBootstrap::getApiInstance();

/**
 *		Case : Get wallet details
 *		Steps :
 *			- RegisterWallet : creating customer wallet
 *			- UploadFile : upload a file
 * 			- RegisterIBAN : attach an IBAN to the wallet
 * 			- RegisterCard : attach a card to the wallet
 *			- RegisterSddMandate : attach an SDD mandate to the wallet
 *			- GetWalletDetails : get wallet details, will return basic info plus KYC that was uploaded, IBANs and SDD mandates attached to it
 *          - UnregisterCard : delete a card
 * 			- GetWalletDetails : get wallet details, will return basic info plus KYC that was uploaded, IBANs and SDD mandates attached to it
 */

//RegisterWallet
$walletID = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet(array('wallet' => $walletID,
    'clientMail' => $walletID.'@mail.fr',
    'clientTitle' => Wallet::UNKNOWN,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Dupond'));
if (isset($res->lwError)){
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    return;
}
print '<br/>Wallet created : ' . $res->wallet->ID;

//UploadFile
$file = file_get_contents(ExamplesDatas::FILE_UPLOAD, true);
$buffer = base64_encode ($file);

$res2 = $api->UploadFile(array('wallet'=>$walletID,
    'fileName'=>'thefilename.jpeg',
    'type'=>KycDoc::TYPE_PROOF_OF_ADDRESS,
    'buffer'=>$buffer));

if (isset($res2->lwError)){
    print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
    return;
}
print '<hr/><br/>Upload successful, file ID : '.$res2->kycDoc->ID;

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
print '<hr/><br/>IBAN registration successful. Iban ID : '. $res3->iban->ID;

//RegisterSddMandate
$res4 = $api->RegisterSddMandate(array('wallet'=>$walletID,
    'holder' => ExamplesDatas::IBAN_HOLDER,
    'bic' => ExamplesDatas::IBAN_BIC,
    'iban' => ExamplesDatas::IBAN_NUMBER,
    'isRecurring' => SddMandate::RECURRING));
if (isset($res4->lwError)){
    print '<br/>Error, code '.$res4->lwError->CODE.' : '.$res4->lwError->MSG;
    return;
}
print '<hr/><br/>SDD mandate registration successful. Mandate ID : '. $res4->sddMandate->ID;

//RegisterCard
$resc = $api->RegisterCard(array('wallet'=>$walletID,
    'cardType'=>'0',
    'cardNumber'=>ExamplesDatas::CARD_SUCCESS_WITHOUT_3D,
    'cardCode'=>ExamplesDatas::CARD_CRYPTO,
    'cardDate'=>ExamplesDatas::CARD_DATE));
if (isset($resc->lwError)){
    print 'Error, code '.$resc->lwError->CODE.' : '.$resc->lwError->MSG;
    return;
}
print '<hr/><br/>Card saved. ID : '.$resc->card->ID;
print '<br/>Card EXTRA AUTH : '.$resc->card->EXTRA->AUTH;
print '<br/>Card EXTRA CTRY : '.$resc->card->EXTRA->CTRY;

//GetWalletDetails
$res5 = $api->GetWalletDetails(array('wallet'=>$walletID));
if (isset($res5->lwError)){
    print '<br/>Error, code '.$res5->lwError->CODE.' : '.$res5->lwError->MSG;
    return;
}
print '<hr/><br/>Wallet details found : ';
print '<br/>ID : '.$res5->wallet->ID;
print '<br/>BALANCE : '.$res5->wallet->BAL;
print '<br/>FULL NAME : '.$res5->wallet->NAME;
print '<br/>EMAIL : '.$res5->wallet->EMAIL;
print '<br/>BALANCE : '.$res5->wallet->BAL;
print '<br/>STATUS : '.$res5->wallet->STATUS;
print '<br/>BLOCKED : '.($res5->wallet->BLOCKED == Wallet::WALLET_BLOCKED ? 'BLOCKED' : 'NOT BLOCKED' );
foreach ($res5->wallet->kycDocs as $kycDoc)
{
    print '<br/><br/>Kyc Document found :';
    print '<br/>ID : '.$kycDoc->ID;
    print '<br/>STATUS : '.$kycDoc->STATUS;
    print '<br/>TYPE : '.$kycDoc->TYPE;
    print '<br/>Validity limit : '.$kycDoc->VD;
}
foreach ($res5->wallet->ibans as $iban)
{
    print '<br/><br/>IBAN found :';
    print '<br/>ID : '.$iban->ID;
    print '<br/>STATUS : '.$iban->STATUS;
    print '<br/>IBAN NUMBER : '.$iban->IBAN;
    print '<br/>BIC : '.$iban->BIC;
}
foreach ($res5->wallet->sddMandates as $sddMandate)
{
    print '<br/><br/>SDD Mandate found :';
    print '<br/>ID : '.$sddMandate->ID;
    print '<br/>STATUS : '.$sddMandate->STATUS;
    print '<br/>IBAN NUMBER : '.$sddMandate->IBAN;
    print '<br/>BIC : '.$sddMandate->BIC;
}
foreach ($res5->wallet->cards as $card)
{
    print '<br/><br/>Card found :';
    print '<br/>ID : '.$card->ID;
    print '<br/>EXTRA IS3DS : '.$card->EXTRA->IS3DS;
}

//UnRegisterCard
$resun = $api->UnRegisterCard(array('wallet'=>$walletID,
    'cardId'=>$resc->card->ID));
if (isset($resun->lwError)){
    print 'Error, code '.$resun->lwError->CODE.' : '.$resun->lwError->MSG;
    return;
}
print '<hr/><br/>Card unregistered. ID : '.$resun->card->ID;


//GetWalletDetails
$res5 = $api->GetWalletDetails(array('wallet'=>$walletID));
if (isset($res5->lwError)){
    print '<br/>Error, code '.$res5->lwError->CODE.' : '.$res5->lwError->MSG;
    return;
}
print '<hr/><br/>Wallet details found : ';
print '<br/>ID : '.$res5->wallet->ID;
print '<br/>EMAIL : '.$res5->wallet->EMAIL;
if(count($res5->wallet->cards) == 0){
    print '<br/>NO CARD FOUND IN THIS WALLET';
}
foreach ($res5->wallet->cards as $card)
{
    print '<br/><br/>Card found :';
    print '<br/>ID : '.$card->ID;
    print '<br/>EXTRA IS3DS : '.$card->EXTRA->IS3DS;
}