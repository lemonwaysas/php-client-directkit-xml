<?php
namespace LemonWay\Examples;

use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Money-in SDD Mandate
 *      Steps :
 *          - MoneyInSddInit : debiting 15 EUR from SDD Mandate, and automatically sending 1 EUR to your wallet (merchant).
 *
 *       Note :
 *          - Lemon Way will automatically debit its fees from merchant wallet
 */

$walletID = $_GET['walletID'];
$sddMandateID = $_GET['sddMandateID'];

// MoneyIn SDD Init
$resMoney = $api->MoneyInSddInit(array('wallet' => $walletID,
    'amountTot' => '15.00',
    'amountCom' => '1.00',
    'comment' => 'comment',
    'autoCommission' => Wallet::NO_AUTO_COMMISSION,
    'sddMandateId' => $sddMandateID
));
if (isset($resMoney->lwError)) {
    print '<br/>Error, code '.$resMoney->lwError->CODE.' : '.$resMoney->lwError->MSG;
} else {
    print '<br/>ID : '. $resMoney->operation->ID;
    print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $resMoney->operation->CRED;
    print '<br/>COM : '. $resMoney->operation->COM;
}


// GetMoneyInSdd
$resGetMoney = $api->GetMoneyInSdd(array('updateDate' => time() - 60*10));
if (isset($resGetMoney->lwError)) {
    print '<br/>Error, code '.$resGetMoney->lwError->CODE.' : '.$resGetMoney->lwError->MSG;
} else {
    print '<br/>'.count($resGetMoney->operations).' operations found.';
}
