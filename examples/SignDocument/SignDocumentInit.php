<?php
namespace LemonWay\Examples;
use LemonWay\Models\KycDoc;
use LemonWay\Models\SddMandate;
use LemonWay\Models\Wallet;

require_once '../ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();


/**
 * SIGNING_PHONE_NUMBER
 * Please fill a valid phone number
 * For example in France 336XXXXXXXX
 * @var string
 */
const SIGNING_PHONE_NUMBER      = '3366792XXXX';

/**
 * SIGNING_SUCCESS_URL Return url for success
 * @var string
 */
const SIGNING_SUCCESS_URL = ExamplesBootstrap::HOST.'/examples/SignDocument/index.php?url=return';

/**
 * SIGNING_ERROR_URL Return url for error
 * @var string
 */
const SIGNING_ERROR_URL = ExamplesBootstrap::HOST.'/examples/SignDocument/index.php?url=error';


/**
 *      Case : Sign Document Init
 *      Steps :
 *          - RegisterWallet : creating customer wallet
 *          - UpdateWalletStatus : updating status wallet
 *          - RegisterSddMandate : Register a new sdd madante for this wallet
 *          - SignDocumentInit : Sign previous Sdd mandate
 */
$walletID = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet(array('wallet' => $walletID,
    'clientMail' => $walletID.'@mail.fr',
    'clientTitle' => Wallet::UNKNOWN,
    'clientFirstName' => 'Paul',
    'clientLastName' => 'Atreides'));
if (isset($res->lwError)) {
    print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
} else {
    print '<br/>Wallet created : ' . $res->wallet->ID;

    $resUpdate = $api->UpdateWalletStatus(array('wallet' => $walletID, 'newStatus' => '6'));
    if (isset($resUpdate->lwError)) {
        print 'Error, code '.$resUpdate->lwError->CODE.' : '.$resUpdate->lwError->MSG;
    } else {
        print '<br/>Wallet satus updated: ' . $resUpdate->wallet->ID;

        //RegisterSddMandate
        $resSdd = $api->RegisterSddMandate(array('wallet'=>$walletID,
            'holder' => ExamplesDatas::IBAN_HOLDER,
            'bic' => ExamplesDatas::IBAN_BIC,
            'iban' => ExamplesDatas::IBAN_NUMBER,
            'isRecurring' => SddMandate::RECURRING));
        if (isset($resSdd->lwError)){
            print '<br/>Error, code '.$resSdd->lwError->CODE.' : '.$resSdd->lwError->MSG;
            return;
        } else {
            print '<br/>SDD mandate registration successful. Mandate ID : '. $resSdd->sddMandate->ID.' / Status : '.$resSdd->sddMandate->STATUS;

            // Sign Document Init
            $resSignDoc = $api->SignDocumentInit(array('wallet' => $walletID,
                'mobileNumber' => SIGNING_PHONE_NUMBER,
                'documentId' => $resSdd->sddMandate->ID,
                'documentType' => KycDoc::TYPE_SDD_MANDATE,
                'returnUrl' => htmlentities(SIGNING_SUCCESS_URL),
                'errorUrl' => htmlentities(SIGNING_ERROR_URL)
            ));
            if (isset($resSignDoc->lwError)) {
                print '<br/>Error, code '.$resSignDoc->lwError->CODE.' : '.$resSignDoc->lwError->MSG;
            } else {
                print '<br/>Token: ' . $resSignDoc->lwXml->SIGNDOCUMENT->TOKEN;


                //Sign document with WEBKIT

                $url = $api->config->wkUrl.'?signingToken='.$resSignDoc->lwXml->SIGNDOCUMENT->TOKEN;
                print '<br /><br />2 actions remaining<br />1) Call WEBKIT URL and Sign the document <a target="_blank" href="'.$url.'">'.$url.'</a>';
                print '<br />2) After the end of the step 1, <a target="_blank" href="../MoneyInSdd.php?walletID='.$walletID.'&sddMandateID='.$resSdd->sddMandate->ID.'">Test the Money In Sdd Mandate </a>';


            }
        }
    }

}


