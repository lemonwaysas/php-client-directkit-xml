<?php

namespace LemonWay\Examples;

use LemonWay\Models\SddMandate;
use LemonWay\Models\Wallet;

require_once 'ExamplesBootstrap.php';
$api = ExamplesBootstrap::getApiInstance();

/**
 *      Case : Get wallet details
 *      Steps :
 *          - RegisterWallet : creating customer wallet
 *          - RegisterSddMandate : attach an SDD mandate to the wallet
 *          - GetWalletDetails : get wallet details to check mandate
 *          - UnRegisterSddMandate : Detach an SDD mandate to the wallet
 *          - GetWalletDetails : get wallet details to check mandate
 */

//RegisterWallet
$walletID = ExamplesDatas::getRandomId();
$res = $api->RegisterWallet([
    'wallet'          => $walletID,
    'clientMail'      => $walletID . '@mail.fr',
    'clientTitle'     => Wallet::UNKNOWN,
    'clientFirstName' => 'Paul',
    'clientLastName'  => 'Dupond',
]);
if (isset($res->lwError)) {
    print 'Error, code ' . $res->lwError->CODE . ' : ' . $res->lwError->MSG;

    return;
}
print '<br/>Wallet created : ' . $res->wallet->ID;

//RegisterSddMandate
$res2 = $api->RegisterSddMandate([
    'wallet'      => $walletID,
    'holder'      => ExamplesDatas::IBAN_HOLDER,
    'bic'         => ExamplesDatas::IBAN_BIC,
    'iban'        => ExamplesDatas::IBAN_NUMBER,
    'isRecurring' => SddMandate::RECURRING,
]);
if (isset($res2->lwError)) {
    print '<br/>Error, code ' . $res2->lwError->CODE . ' : ' . $res2->lwError->MSG;

    return;
}
print '<br/>SDD mandate registration successful. Mandate ID : ' . $res2->sddMandate->ID;

//GetWalletDetails
$res5 = $api->GetWalletDetails(['wallet' => $walletID]);
if (isset($res5->lwError)) {
    print '<br/>Error, code ' . $res5->lwError->CODE . ' : ' . $res5->lwError->MSG;

    return;
}
print '<hr/><br/>Wallet details found : ';
print '<br/>ID : ' . $res5->wallet->ID;
print '<br/>FULL NAME : ' . $res5->wallet->NAME;
print '<br/>EMAIL : ' . $res5->wallet->EMAIL;
print '<br/>BALANCE : ' . $res5->wallet->BAL;
print '<br/>STATUS : ' . $res5->wallet->STATUS;
print '<br/>BLOCKED : ' . ($res5->wallet->BLOCKED == Wallet::WALLET_BLOCKED ? 'BLOCKED' : 'NOT BLOCKED');

foreach ($res5->wallet->sddMandates as $sddMandate) {
    print '<br/><br/>SDD Mandate found :';
    print '<br/>ID : ' . $sddMandate->ID;
    print '<br/>STATUS : ' . ($sddMandate->STATUS == SddMandate::DEACTIVATED ? 'DEACTIVATED'
            : 'VALIDATED OR WAITING VALIDATION');
    print '<br/>IBAN NUMBER : ' . $sddMandate->IBAN;
    print '<br/>BIC : ' . $sddMandate->BIC;
}

//UnregisterSddMandante
$resc = $api->UnregisterSddMandate([
    'wallet'       => $walletID,
    'sddMandateId' => $res2->sddMandate->ID,
]);
if (isset($resc->lwError)) {
    print 'Error, code ' . $resc->lwError->CODE . ' : ' . $resc->lwError->MSG;

    return;
}
print '<hr/><br/>SDD mandate unregistration successful. Mandate ID : ' . $resc->sddMandate->ID;
print '<br/>SDD Mandate Status : ' . $resc->sddMandate->STATUS;

//GetWalletDetails
$res5 = $api->GetWalletDetails(['wallet' => $walletID]);
if (isset($res5->lwError)) {
    print '<br/>Error, code ' . $res5->lwError->CODE . ' : ' . $res5->lwError->MSG;

    return;
}
print '<hr/><br/>Wallet details found : ';
print '<br/>ID : ' . $res5->wallet->ID;
print '<br/>FULL NAME : ' . $res5->wallet->NAME;
print '<br/>EMAIL : ' . $res5->wallet->EMAIL;
print '<br/>BALANCE : ' . $res5->wallet->BAL;
print '<br/>STATUS : ' . $res5->wallet->STATUS;
print '<br/>BLOCKED : ' . ($res5->wallet->BLOCKED == Wallet::WALLET_BLOCKED ? 'BLOCKED' : 'NOT BLOCKED');

foreach ($res5->wallet->sddMandates as $sddMandate) {
    print '<br/><br/>SDD Mandate found :';
    print '<br/>ID : ' . $sddMandate->ID;
    print '<br/>STATUS : ' . ($sddMandate->STATUS == SddMandate::DEACTIVATED ? 'DEACTIVATED'
            : 'VALIDATED OR WAITING VALIDATION');
    print '<br/>IBAN NUMBER : ' . $sddMandate->IBAN;
    print '<br/>BIC : ' . $sddMandate->BIC;
}
