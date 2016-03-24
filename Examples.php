<?php
class Examples {

	private static $myUrls = array ('returnUrl' => 'http://www.yourwebsite.com/index.php?url=return',
							'cancelUrl' => 'http://www.yourwebsite.com/index.php?url=cancel',
							'errorUrl' => 'http://www.yourwebsite.com/index.php?url=error',
							'cssUrl' => 'https://www.lemonway.fr/mercanet_lw.css');
									
	private static $testCard = array ('number' => '5017670000001800',
										'crypto' => '123',
										'date' => '12/2017');
	
	private static $testFileToUpload = 'images/lemonway_logo.jpeg';
	
	private static $testIban = array('holder' => 'My Name',
									'iban' => 'FR1420041010050500013M02606',
									'bic' => 'ABCDEFGHIJK',
									'address1' => 'Center branch',
									'address2' => 'Paris');
	
	/*
		Generate random ID for wallet IDs or tokens
	*/
	private function getRandomId(){
		return str_replace('.', '', microtime(true).rand());
	}
	
	/*
		Case : create wallet
		Steps :
			- RegisterWallet : creating customer wallet
		Note : 
			- wallet must be unique
			- clientMail must be unique
	*/
	public function RegisterWallet(){
		$wallet = self::getRandomId();
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet, 
												'clientMail' => $wallet.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError))
			print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
		else
			print '<br/>Wallet created : ' . $res->wallet->ID;
	}
	
	/*
		Case : Money-in without 3D Secure
		Steps :
			- RegisterWallet : creating customer wallet
			- MoneyIn : debiting 10 EUR from card, and automatically sending 2 EUR to your wallet (merchant).
		Note :
			- Lemon Way will automatically debit its fees from merchant wallet
			- After the MoneyIn call, 8 EUR will remain on customer wallet
			- The wkToken input can later be used to search for this payment
	*/
	public function MoneyIn(){
		$wallet = self::getRandomId();
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet, 
												'clientMail' => $wallet.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError))
			print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
		else {
			print '<br/>Wallet created : ' . $res->wallet->ID;
			$res2 = LemonWayKit::MoneyIn(array('wkToken'=>self::getRandomId(),
											  'wallet'=>$wallet,
											  'amountTot'=>'10.00',
											  'amountCom'=>'2.00',
											  'comment'=>'comment',
											  'cardType'=>'0',
											  'cardNumber'=>self::$testCard['number'],
											  'cardCrypto'=>self::$testCard['crypto'],
											  'cardDate'=>self::$testCard['date'],
											  'autoCommission'=>'0',
											  'isPreAuth'=>'0'));
			if (isset($res2->lwError)){
				print 'Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
				return;
			}
			
			if ((string)$res2->operations[0]->STATUS == '3') //if isPreAuth = 0
				print '<br/>Money-in successul : '; 
			elseif ((string)$res2->operations[0]->STATUS == '16') //if isPreAuth = 1
				print '<br/>Money-in successul (pending validation) : ';
			print '<br/>ID : '. $res2->operations[0]->ID;
			print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $res2->operations[0]->CRED;
			print '<br/>CARD : '. $res2->operations[0]->MLABEL;
			print '<br/>AUTHORIZATION NUMBER : '. $res2->operations[0]->EXTRA->AUTH;
		}
	}
	
	/*
		Case : Upload a file for KYC (Know Your Customer) control
		Steps :
			- RegisterWallet : creating customer wallet
			- UploadFile : upload a file
		Note :
			- Up to 4MB
			- type = 1 means it's a proof of address. Please check documentation for full list of types
			- after the successful upload, the file will be pending review. You won't be able to upload a file of the same type for the same wallet until the first one is reviewed.
	*/
	public function UploadFile(){
		//RegisterWallet
		$wallet = self::getRandomId();
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet, 
												'clientMail' => $wallet.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError)){
			print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
			return;
		} 
		print '<br/>Wallet created : ' . $res->wallet->ID;
		
		//UploadFile
		$file = file_get_contents(self::$testFileToUpload, true);
		$buffer = base64_encode ($file);
		$res2 = LemonWayKit::UploadFile(array('wallet'=>$wallet,
										  'fileName'=>'thefilename.jpeg',
										  'type'=>'1',
										  'buffer'=>$buffer));
		if (isset($res2->lwError)){
			print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
			return;
		}
		print '<br/>Upload successful, file ID : '.$res2->kycDoc->ID;
	}

	/*
		Case : Send a payment from one wallet to another
		Steps :
			- RegisterWallet : creating 2 customer wallets
			- MoneyIn : crediting the first wallet
			- SendPayment : sending the remaining amount to another wallet
	*/
	public function SendPayment(){
		//Create first wallet
		$wallet1 = self::getRandomId();		
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet1, 
												'clientMail' => $wallet1.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError)){
			print '<br/>Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
			return;
		}
		print '<br/>Wallet1 created : ' . $res->wallet->ID;
		
		//Credit first wallet
		$res2 = LemonWayKit::MoneyIn(array('wkToken'=>self::getRandomId(),
										  'wallet'=>$wallet1,
										  'amountTot'=>'10.00',
										  'amountCom'=>'2.00',
										  'comment'=>'comment',
										  'cardType'=>'0',
										  'cardNumber'=>self::$testCard['number'],
										  'cardCrypto'=>self::$testCard['crypto'],
										  'cardDate'=>self::$testCard['date'],
										  'autoCommission'=>'0',
										  'isPreAuth'=>'0'));
		if (isset($res2->lwError)){
			print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
			return;
		}
		print '<br/>Money-in successul. ID: '. $res2->operations[0]->ID;
		
		//Create second wallet
		$wallet2 = self::getRandomId();
		$res3 = LemonWayKit::RegisterWallet(array('wallet' => $wallet2, 
												'clientMail' => $wallet2.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res3->lwError)){
			print '<br/>Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
			return;
		}
		print '<br/>Wallet2 created : ' . $res3->wallet->ID;
		
		//Send money from wallet1 to wallet2
		$amount = $res2->operations[0]->CRED;
		$res4 = LemonWayKit::SendPayment(array('debitWallet' => $wallet1,
											'creditWallet' => $wallet2,
											'amount' => $amount,
											'message' => ''));
		if (isset($res4->lwError)){
			print '<br/>Error, code '.$res4->lwError->CODE.' : '.$res4->lwError->MSG;
			return;
		}
		print '<br/>Payment successul : '. $res4->operations[0]->ID;
	}
	
	/*
		Case : Money-out : debit a wallet's balance to a bank account
		Steps :
			- RegisterWallet : creating a customer wallet
			- MoneyIn : debiting 10 EUR from card, and automatically sending 2 EUR to your merchant wallet
			- RegisterIBAN : save IBAN information for wallet
			- MoneyOut : debiting the 8 EUR remaining on the customer's wallet, and automatically sending 1 EUR to your merchant wallet. 7 EUR will be sent to the customer's bank account
		Note : 
			- You can register many IBANs on the same wallet
			- When you call for a MoneyOut, you can either specify the destination IBAN's ID in ibanId parameter, or leave it empty. If left empty, the latest registered IBAN will be used
			- The "message" parameter in MoneyOut can be displayed on the customer's bank statement. Please contact support for more information
	*/
	public function MoneyOut(){
		//RegisterWallet
		$wallet = self::getRandomId();
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet, 
												'clientMail' => $wallet.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError)){
			print '<br/>Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
			return;
		}
		print '<br/>Wallet created : ' . $res->wallet->ID;
		
		//MoneyIn
		$res2 = LemonWayKit::MoneyIn(array('wkToken'=>self::getRandomId(),
										  'wallet'=>$wallet,
										  'amountTot'=>'10.00',
										  'amountCom'=>'2.00',
										  'comment'=>'comment',
										  'cardType'=>'0',
										  'cardNumber'=>self::$testCard['number'],
										  'cardCrypto'=>self::$testCard['crypto'],
										  'cardDate'=>self::$testCard['date'],
										  'autoCommission'=>'0',
										  'isPreAuth'=>'0'));
		if (isset($res2->lwError)){
			print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
			return;
		}
		print '<br/>Money-in successul. ID: '. $res2->operations[0]->ID;
		
		//RegisterIBAN
		$res3 = LemonWayKit::RegisterIBAN(array('wallet'=>$wallet,
										  'holder' => self::$testIban['holder'],
										  'bic' => self::$testIban['bic'],
										  'iban' => self::$testIban['iban'],
										  'dom1' => self::$testIban['address1'],
										  'dom2' => self::$testIban['address1']));
		if (isset($res3->lwError)){
			print '<br/>Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
			return;
		}
		print '<br/>IBAN registration successul. Iban ID : '. $res3->iban->ID;
		
		//MoneyOut
		$amount = (string)$res2->operations[0]->CRED;
		$res4 = LemonWayKit::MoneyOut(array('wallet' => $wallet,
											  'ibanId' => '',
											  'amountTot' => $amount,
											  'amountCom' => '1.00',
											  'message' => '',
											  'autoCommission' => '0'));
		if (isset($res4->lwError)){
			print '<br/>Error, code '.$res4->lwError->CODE.' : '.$res4->lwError->MSG;
			return;
		}
		print '<br/>Money-out successul. ID: '. $res4->operations[0]->ID;
	}
	
	/*
		Case : Initialize a Money-in with 3D Secure and using secured Atos/BNP card forms
		Steps :
			- RegisterWallet : creating a customer wallet
			- MoneyInWebInit : initializing the payment. The output will be a token generated by Lemon Way, that you will need to pass to the WEBKIT
		Note :
			- Make sure you use a unique wkToken in input. You will use it to search for the payment when the customer comes back to your website after paying.
			- Atos/BNP test site has an invalid certificate. Please ignore the warning displayed by your browser and proceed.
	*/
	public function MoneyInWebInit(){
		$wallet = self::getRandomId();
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet, 
												'clientMail' => $wallet.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError))
			print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
		else {
			print '<br/>Wallet created : ' . $res->wallet->ID;
			$res2 = LemonWayKit::MoneyInWebInit(array('wkToken'=>self::getRandomId(),
											  'wallet'=>$wallet,
											  'amountTot'=>'10.00',
											  'amountCom'=>'2.00',
											  'comment'=>'comment',
											  'returnUrl'=>urlencode(self::$myUrls['returnUrl']),
											  'cancelUrl'=>urlencode(self::$myUrls['cancelUrl']),
											  'errorUrl'=>urlencode(self::$myUrls['errorUrl']),
											  'autoCommission'=>'0'));
			if (isset($res2->lwError)){
				print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
				return;
			}
			print '<br/>Init successul. LWTOKEN: '. $res2->lwXml->MONEYINWEB->TOKEN;
			LemonWayKit::printCardForm($res2->lwXml->MONEYINWEB->TOKEN, self::$myUrls['cssUrl']);
		}
	}

	/*
		Case : This follows the MoneyInWebInit case : your customer has returned to your website or you have received a POST notification from Lemon Way. You now need to find out how the payment went.
		Steps :
			- GetMoneyInTransDetails
		Note :
			- In this example, we print data, but keep in mind that if you arrive here from the Lemon Way notification (with POST data), printing will be pointless. You can log data in a file instead.
			- You have defined 3 return urls (success, error, cancel), but it is still recommended to make this call in order to verify the information and to make sure the POST or GET data were not maliciously modified.
			- If the status is SUCCESS (3) or ERROR (4), then it's a final status, it won't change. 
			- If the status is still PENDING (0), then the status can still change : it means your customer has cancelled the payment or returned to your website, or something else that made them arrive on one of your return urls, without finishing their payment. The customer will still be able to go back to the payment form using the browser's back button, and make the payment. You should either : 
				- just like Lemon Way, not change the payment status and still give your customer the opportunity to pay
				- decide to mark the payment as failed on your side, but keep in mind that this won't prevent Lemon Way from accepting the payment if the customer pays. 
	*/
	public function MoneyInWebFinalize($merchantToken, $moneyInId, $isFromGET){
		$res = LemonWayKit::GetMoneyInTransDetails(array('transactionId'=>$moneyInId,
											  'transactionComment'=>'',
											  'transactionMerchantToken'=>$merchantToken));
		if (isset($res->lwError)){
			print '<br/>Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
			return;
		}
		if (count($res->operations) != 1){
			print '<br/>Error, too many results : '.count($res->operations);
			//TODO : error to handle. Check if your merchant transactionMerchantToken is unique 
			return;
		} else {
			if ((string)$res->operations[0]->STATUS == '3'){
				print '<br/>Money-in successul : '; 
				print '<br/>ID : '. $res->operations[0]->ID;
				print '<br/>AMOUNT : '. $res->operations[0]->CRED;
				print '<br/>AUTHORIZATION NUMBER : '. $res->operations[0]->EXTRA->AUTH;
				/* TODO: examples of things to do : 
					-if $isFromGET = true, display a payment successful message
					-mark the payment as successful in your database
					-send a confirmation email if it wasn't already sent
				*/
			} elseif ((string)$res->operations[0]->STATUS == '4'){
				print '<br/>Money-in failed : '; 
				print '<br/>ID : '. $res->operations[0]->ID;
				print '<br/>AMOUNT : '. $res->operations[0]->CRED;
				print '<br/>AUTHORIZATION NUMBER : '. $res->operations[0]->EXTRA->AUTH;
				/* TODO: examples of things to do : 
					-if $isFromGET = true, display a payment failed message 
					-mark the payment as failed in your database
				*/
			} elseif ((string)$res->operations[0]->STATUS == '0'){
				print '<br/>Money-in pending : '; 
				print '<br/>ID : '. $res->operations[0]->ID;
				print '<br/>AMOUNT : '. $res->operations[0]->CRED;
				print '<br/>AUTHORIZATION NUMBER : '. $res->operations[0]->EXTRA->AUTH;
				/* TODO: examples of things to do : 
					-if $isFromGET = true, display a payment pending message. It is possible that the customer goes back to the Atos card payment form and decides to pay
				*/
			}
		}
	}
	
		/*
		Case : search for money-in operation
		Steps :
			- GetMoneyInTransDetails : searching for a money-in, by your merchant token or by comment, or by ID
		Note : 
			- leave parameter empty if you don't want to use it as search field
			- at least one search field required
	*/
	public function GetMoneyInTransDetails(){
		$res = LemonWayKit::GetMoneyInTransDetails(array('transactionId'=>'',
											  'transactionComment'=>'my comment',
											  'transactionMerchantToken'=>''));
		if (isset($res->lwError))
			print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
		else
			print '<br/>'.count($res->operations).' operations found.';
	}
	
	/*
		Case : Get wallet details
		Steps :
			- RegisterWallet : creating customer wallet
			- UploadFile : upload a file
			- RegisterIBAN : attach an IBAN to the wallet
			- RegisterSddMandate : attach an SDD mandate to the wallet
			- GetWalletDetails : get wallet details, will return basic info plus KYC that was uploaded, IBANs and SDD mandates attached to it
	*/
	public function GetWalletDetails(){
		//RegisterWallet
		$wallet = self::getRandomId();
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet, 
												'clientMail' => $wallet.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError)){
			print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
			return;
		} 
		print '<br/>Wallet created : ' . $res->wallet->ID;
		
		//UploadFile
		$file = file_get_contents(self::$testFileToUpload, true);
		$buffer = base64_encode ($file);
		$res2 = LemonWayKit::UploadFile(array('wallet'=>$wallet,
										  'fileName'=>'thefilename.jpeg',
										  'type'=>'1',
										  'buffer'=>$buffer));
		if (isset($res2->lwError)){
			print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
			return;
		}
		print '<br/>Upload successful, file ID : '.$res2->kycDoc->ID;
		
		//RegisterIBAN
		$res3 = LemonWayKit::RegisterIBAN(array('wallet'=>$wallet,
										  'holder' => self::$testIban['holder'],
										  'bic' => self::$testIban['bic'],
										  'iban' => self::$testIban['iban'],
										  'dom1' => self::$testIban['address1'],
										  'dom2' => self::$testIban['address1']));
		if (isset($res3->lwError)){
			print '<br/>Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
			return;
		}
		print '<br/>IBAN registration successul. Iban ID : '. $res3->iban->ID;
		
		//RegisterSddMandate
		$res4 = LemonWayKit::RegisterSddMandate(array('wallet'=>$wallet,
										  'holder' => self::$testIban['holder'],
										  'bic' => self::$testIban['bic'],
										  'iban' => self::$testIban['iban'],
										  'isRecurring' => '1'));
		if (isset($res4->lwError)){
			print '<br/>Error, code '.$res4->lwError->CODE.' : '.$res4->lwError->MSG;
			return;
		}
		print '<br/>SDD mandate registration successul. Mandate ID : '. $res4->sddMandate->ID;
		
		//GetWalletDetails
		$res5 = LemonWayKit::GetWalletDetails(array('wallet'=>$wallet));
		if (isset($res5->lwError)){
			print '<br/>Error, code '.$res5->lwError->CODE.' : '.$res5->lwError->MSG;
			return;
		}
		print '<br/>Wallet details found : ';
		print '<br/>ID : '.$res5->wallet->ID;
		print '<br/>BALANCE : '.$res5->wallet->BAL;
		print '<br/>FULL NAME : '.$res5->wallet->NAME;
		print '<br/>EMAIL : '.$res5->wallet->EMAIL;
		print '<br/>BALANCE : '.$res5->wallet->BAL;
		print '<br/>STATUS : '.$res5->wallet->STATUS;
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
	}
	
	/*
		Case : Save a bank card for later rebills. No 3D Secure.
		Steps :
			- RegisterWallet : creating customer wallet
			- RegisterCard : link a bank card to the wallet
			- MoneyInWithCardId : debit the card once
			- MoneyInWithCardId : debit the card again
	*/
	public function Rebill(){
		//RegisterWallet
		$wallet = self::getRandomId();
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet, 
												'clientMail' => $wallet.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError)){
			print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
			return;
		}
		print '<br/>Wallet created : ' . $res->wallet->ID;
		
		//RegisterCard
		$res2 = LemonWayKit::RegisterCard(array('wallet'=>$wallet,
										  'cardType'=>'0',
										  'cardNumber'=>self::$testCard['number'],
										  'cardCode'=>self::$testCard['crypto'],
										  'cardDate'=>self::$testCard['date']));
		if (isset($res2->lwError)){
			print 'Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
			return;
		}
		print '<br/>Card saved. ID : '.$res2->lwXml->CARD->ID;
		
		//MoneyInWithCardId
		$res3 = LemonWayKit::MoneyInWithCardId(array('wkToken'=>self::getRandomId(),
											  'wallet'=>$wallet,
											  'amountTot'=>'10.00',
											  'amountCom'=>'2.00',
											  'comment'=>'comment',
											  'cardId'=>(string)$res2->lwXml->CARD->ID,
											  'autoCommission'=>'0',
											  'isPreAuth'=>'0'));
		if (isset($res3->lwError)){
			print 'Error, code '.$res3->lwError->CODE.' : '.$res3->lwError->MSG;
			return;
		}
		
		print '<br/>Money-in successul : '; 
		print '<br/>ID : '. $res3->operations[0]->ID;
		print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $res3->operations[0]->CRED;
		print '<br/>CARD : '. $res3->operations[0]->MLABEL;
		print '<br/>AUTHORIZATION NUMBER : '. $res3->operations[0]->EXTRA->AUTH;
		
		//MoneyInWithCardId
		$res4 = LemonWayKit::MoneyInWithCardId(array('wkToken'=>self::getRandomId(),
											  'wallet'=>$wallet,
											  'amountTot'=>'11.00',
											  'amountCom'=>'2.00',
											  'comment'=>'comment',
											  'cardId'=>(string)$res2->lwXml->CARD->ID,
											  'autoCommission'=>'0',
											  'isPreAuth'=>'0'));
		if (isset($res4->lwError)){
			print 'Error, code '.$res4->lwError->CODE.' : '.$res4->lwError->MSG;
			return;
		}
		
		print '<br/>Another Money-in successul : '; 
		print '<br/>ID : '. $res4->operations[0]->ID;
		print '<br/>AMOUNT CREDITED TO ACCOUNT (After merchant fees): '. $res4->operations[0]->CRED;
		print '<br/>CARD : '. $res4->operations[0]->MLABEL;
		print '<br/>AUTHORIZATION NUMBER : '. $res4->operations[0]->EXTRA->AUTH;
	}
	
	/*
		Case : UpdateWalletDetails
		Steps :
			- RegisterWallet : creating customer wallet
			- UpdateWalletDetails : update wallet information. In this example, we change the email and the address
	*/
	public function UpdateWalletDetails(){
		//RegisterWallet
		$wallet = self::getRandomId();
		$res = LemonWayKit::RegisterWallet(array('wallet' => $wallet, 
												'clientMail' => $wallet.'@mail.fr', 
												'clientTitle' => 'U', 
												'clientFirstName' => 'Paul', 
												'clientLastName' => 'Dupond'));
		if (isset($res->lwError)){
			print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
			return;
		}
		print '<br/>Wallet created : ' . $res->wallet->ID;
		
		//UpdateWalletDetails
		$res2 = LemonWayKit::UpdateWalletDetails(array('wallet'=>$wallet,
										  'newEmail'=>$wallet.'@mail2.fr',
										  'newStreet'=>'My street',
										  'newPostCode'=>'1234567',
										  'newCity'=>'My city',
										  'newCtry'=>'FRA'));
		if (isset($res2->lwError)){
			print 'Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
			return;
		}
		print '<br/>Wallet updated : ' . $res2->wallet->ID;
	}
}


?>