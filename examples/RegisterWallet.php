<?php
namespace LemonWay\Examples;
use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : create wallet
 *      Steps :
 *          - RegisterWallet : creating customer wallet
 *          - UpdateWalletStatus : updating Wallet Status
 *          - GetKycStatus : looking for user, document, IBAN, modified since an entry date
 *
 *
 *      Note :
 *          - wallet must be unique
 *          - clientMail must be unique
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
    $creationTime = time() - 60*10; // Will be used by GetKycStatus
    $res = $api->UpdateWalletStatus(array('wallet' => $walletID, 'newStatus' => Wallet::STATUS_KYC_2));
    if (isset($res->lwError)) {
        print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
    } else {
        print '<br/>Wallet satus updated: ' . $res->wallet->ID;

        $resk = $api->GetKycStatus(array('updateDate'=>$creationTime));
        if (isset($resk->lwError)){
            print '<br/>Error, code '.$resk->lwError->CODE.' : '.$resk->lwError->MSG;
            return;
        }
        print '<hr/><br/>Modified elements found : '.count($resk->wallets);
        foreach ($resk->wallets as $wallet)
        {
            print '<br/>WALLET ID : '.$wallet->ID;
        }
    }
}


