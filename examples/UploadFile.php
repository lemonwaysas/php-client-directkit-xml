<?php
namespace LemonWay\Examples;
use LemonWay\Models\Wallet;
use LemonWay\Models\KycDoc;

require_once '../LemonWay/Autoloader.php';
require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 * 		Case : Upload a file for KYC (Know Your Customer) control
 *		Steps :
 *			- RegisterWallet : creating customer wallet
 *			- UploadFile : upload a file
 *		Note :
 *			- Up to 4MB
 *			- type = 1 means it's a proof of address. Please check documentation for full list of types
 *			- after the successful upload, the file will be pending review. You won't be able to upload a file of the same type for the same wallet until the first one is reviewed.
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
$buffer = file_get_contents(ExamplesDatas::FILE_UPLOAD, true);

$res2 = $api->UploadFile(array('wallet'=>$walletID,
    'fileName'=>'thefilename.jpeg',
    'type'=>KycDoc::TYPE_PROOF_OF_ADDRESS,
    'buffer'=>$buffer));
if (isset($res2->lwError)){
    print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
    return;
}
print '<br/>Upload successful, file ID : '.$res2->kycDoc->ID;