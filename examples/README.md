|API | Example | Comments |
|----|---------|----------|
|**Wallets**              |
|RegisterWallet | [RegisterWallet](RegisterWallet.php) |   |
|GetWalletDetails | [GetWalletDetails](GetWalletDetails.php) | |
|UpdateWalletDetails | [UpdateWalletDetails](UpdateWalletDetails.php) | |
|UploadFile | [UploadFile](UploadFile.php) |  |
|GetKycStatus | [RegisterWallet](RegisterWallet.php) | |
|GetWalletTransHistory | [MoneyIn](MoneyIn.php) |  |
|UpdateWalletStatus | [RegisterWallet](RegisterWallet.php), [SignDocument - SignDocumentInit](SignDocument/index.php) | _Please fill a valid phone number for this example_ |
|GetBalances | [GetBalances](GetBalances.php) |  |
|**Money-in**             |
|**_By Card_**            |
|MoneyInWebInit | [MoneyIn 3D Indirect - MoneyInWebInit](MoneyIn_3D_Indirect/index.php) |  Use _5017670000006700_ for _success without 3D Secure_.<br>Use _5017670000001800_ for _success wit 3D Secure_.  <br/> Use _5017670000000851_ for _failure_.  <br/> For date, just put _a future one_.  <br/> For crypto, _any 3 digits number_.  |
|MoneyIn | [MoneyIn](MoneyIn.php) | |
|MoneyIn3DInit | [MoneyIn 3D Direct - Confirm](MoneyIn_3D_Direct/confirm/index.php) | Use _5017670000001800_ for _success wit 3D Secure_.  <br/> Use _5017670000000851_ for _failure_.  <br/> For date, just put _a future one_.  <br/> For crypto, _any 3 digits number_.  |
|MoneyIn3DAuthenticate | [MoneyIn 3D Direct - Authenticate](MoneyIn_3D_Direct/authenticate/index.php) | Use _5017670000001800_ for _success wit 3D Secure_.  <br/> Use _5017670000000851_ for _failure_.  <br/> For date, just put _a future one_.  <br/> For crypto, _any 3 digits number_.  |
|MoneyIn3DConfirm | [MoneyIn 3D Direct - Confirm](MoneyIn_3D_Direct/confirm/index.php) | Use _5017670000001800_ for _success wit 3D Secure_.  <br/> Use _5017670000000851_ for _failure_.  <br/> For date, just put _a future one_.  <br/> For crypto, _any 3 digits number_.  |
|RegisterCard | [Rebill](Rebill.php) |  |
|UnregisterCard | [GetWalletDetails](GetWalletDetails.php) | |
|MoneyInWithCardId | [Rebill](Rebill.php) |  |
|MoneyInValidate | [MoneyInValidate](MoneyInValidate.php) | |
|**_By bank wire (SCT, Sepa Credit Transfer, IBAN)_**                                             |
|GetMoneyInIBANDetails | [GetMoneyInIBANDetails](GetMoneyInIBANDetails.php) | |
|**_By cheque_**          |
|MoneyInChequeInit | [MoneyInCheque](MoneyInCheque.php) | |
|GetMoneyInChequeDetails | [MoneyInCheque](MoneyInCheque.php) | |
|**_By SEPA Direct Debit (SDD)_** |
|RegisterSddMandate | [GetWalletDetails](GetWalletDetails.php), [SddMandate](SddMandate.php) | |
|UnregisterSddMandate | [Sdd Mandate](SddMandate.php) |  |
|SignDocumentInit | [SignDocument - SignDocumentInit](SignDocument/index.php) | _Please fill a valid phone number for this example_ |
|MoneyInSddInit | [SignDocument - SignDocumentInit](SignDocument/index.php) | _Please fill a valid phone number for this example_ |
|GetMoneyInSdd | [SignDocument - SignDocumentInit](SignDocument/index.php) | _Please fill a valid phone number for this example_ |
|**_By iDEAL_**            |
|MoneyInIDealConfirm | [MoneyIn iDeal - MoneyInIDealConfirm](MoneyIn_iDeal/index.php) | |
|MoneyInIDealInit | [MoneyIn iDeal - MoneyInIDealInit](MoneyIn_iDeal/index.php) | |
|**_By SOFORT_**          |
|MoneyInSofortInit | [MoneyInSofort](MoneyInSofort.php) | |
|**_By Neosurf_**         |
|MoneyInNeosurf | [MoneyInNeosurf](MoneyInNeosurf.php) | |
|GetMoneyInTransDetails | [MoneyIn 3D Indirect - MoneyInWebFinalize](MoneyIn_3D_Indirect/index.php) |  Use _5017670000006700_ for _success without 3D Secure_.<br>Use _5017670000001800_ for _success wit 3D Secure_.  <br/> Use _5017670000000851_ for _failure_.  <br/> For date, just put _a future one_.  <br/> For crypto, _any 3 digits number_.  |
|**Money-out**            |
|RegisterIBAN | [MoneyOut](MoneyOut.php) | |
|MoneyOut | [MoneyOut](MoneyOut.php) |  |
|GetMoneyOutTransDetails | [MoneyOut](MoneyOut.php) | |
|**P2P**                 |
|GetPaymentDetails | [SendPayment](SendPayment.php) | |
|SendPayment | [SendPayment](SendPayment.php) |  |
|**Other functions**        |
|RefundMoneyIn | [RefundMoneyIn](RefundMoneyIn.php) | |
|GetChargebacks | [GetChargebacks](GetChargebacks.php) | |
|CreateVCC | [Create VCC](CreateVCC.php) |  |
|GetWizypayAds | [GetWizypayAds](GetWizypayAds.php) |  |

