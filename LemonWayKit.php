<?php

class LemonWayKit{
	
	private static $printInputAndOutputXml = false;
	
	private static $accessConfig = array (
							'directKitUrl' => 'https://ws.lemonway.fr/mb/test/dev/directkitxml/service.asmx',
							'webkitUrl' => 'https://m.lemonway.fr/mb/test/dev/',
							'wlLogin' => 'society',
							'wlPass' => '123456',
							'language' => 'fr');
	
	public function RegisterWallet($params) {
		$res = self::sendRequest('RegisterWallet', $params, '1.1');
		if (!isset($res->lwError)){
			$res->wallet = new Wallet($res->lwXml->WALLET);
		}
		return $res;
	}
	public function MoneyIn($params) {
		$res = self::sendRequest('MoneyIn', $params, '1.1');
		if (!isset($res->lwError)){
			$res->operations = array(new Operation($res->lwXml->TRANS->HPAY));
		}
		return $res;
	}
	public function UpdateWalletDetails($params) {
		$res = self::sendRequest('UpdateWalletDetails', $params, '1.0');
		if (!isset($res->lwError)){
			$res->wallet = new Wallet($res->lwXml->WALLET);
		}
		return $res;
	}
	public function GetWalletDetails($params) {
		$res = self::sendRequest('GetWalletDetails', $params, '1.5');
		if (!isset($res->lwError)){
			$res->wallet = new Wallet($res->lwXml->WALLET);
		}
		return $res;
	}
	public function MoneyIn3DInit($params) {
		return self::sendRequest('MoneyIn3DInit', $params, '1.1');
	}
	public function MoneyIn3DConfirm($params) {
		return self::sendRequest('MoneyIn3DConfirm', $params, '1.1');
	}
	public function MoneyInWebInit($params) {
		return self::sendRequest('MoneyInWebInit', $params, '1.2');
	}
	public function RegisterCard($params) {
		return self::sendRequest('RegisterCard', $params, '1.1');
	}
	public function UnregisterCard($params) {
		return self::sendRequest('UnregisterCard', $params, '1.0');
	}
	public function MoneyInWithCardId($params) {
		$res = self::sendRequest('MoneyInWithCardId', $params, '1.1');
		if (!isset($res->lwError)){
			$res->operations = array(new Operation($res->lwXml->TRANS->HPAY));
		}
		return $res;
	}
	public function MoneyInValidate($params) {
		return self::sendRequest('MoneyInValidate', $params, '1.0');
	}
	public function SendPayment($params) {
		$res = self::sendRequest('SendPayment', $params, '1.0');
		if (!isset($res->lwError)){
			$res->operations = array(new Operation($res->lwXml->TRANS->HPAY));
		}
		return $res;
	}
	public function RegisterIBAN($params) {
		$res = self::sendRequest('RegisterIBAN', $params, '1.1');
		if (!isset($res->lwError)){
			$res->iban = new Iban($res->lwXml->IBAN);
		}
		return $res;
	}
	public function MoneyOut($params) {
		$res = self::sendRequest('MoneyOut', $params, '1.3');
		if (!isset($res->lwError)){
			$res->operations = array(new Operation($res->lwXml->TRANS->HPAY));
		}
		return $res;
	}
	public function GetPaymentDetails($params) {
		$res = self::sendRequest('GetPaymentDetails', $params, '1.0');
		if (!isset($res->lwError)){
			$res->operations = array();
			foreach ($res->lwXml->TRANS->HPAY as $HPAY){
				$res->operations[] = new Operation($HPAY);
			}
		}
		return $res;
	}
	public function GetMoneyInTransDetails($params) {
		$res = self::sendRequest('GetMoneyInTransDetails', $params, '1.6');
		if (!isset($res->lwError)){
			$res->operations = array();
			foreach ($res->lwXml->TRANS->HPAY as $HPAY){
				$res->operations[] = new Operation($HPAY);
			}
		}
		return $res;
	}
	public function GetMoneyOutTransDetails($params) {
		$res = self::sendRequest('GetMoneyOutTransDetails', $params, '1.4');
		if (!isset($res->lwError)){
			$res->operations = array();
			foreach ($res->lwXml->TRANS->HPAY as $HPAY){
				$res->operations[] = new Operation($HPAY);
			}
		}
		return $res;
	}
	public function UploadFile($params) {
		$res = self::sendRequest('UploadFile', $params, '1.1');
		if (!isset($res->lwError)){
			$res->kycDoc = new KycDoc($res->lwXml->UPLOAD);
		}
		return $res;
	}
	public function GetKycStatus($params) {
		return self::sendRequest('GetKycStatus', $params, '1.5');
	}
	public function GetMoneyInIBANDetails($params) {
		return self::sendRequest('GetMoneyInIBANDetails', $params, '1.4');
	}
	public function RefundMoneyIn($params) {
		return self::sendRequest('RefundMoneyIn', $params, '1.2');
	}
	public function GetBalances($params) {
		return self::sendRequest('GetBalances', $params, '1.0');
	}
	public function MoneyIn3DAuthenticate($params) {
		return self::sendRequest('MoneyIn3DAuthenticate', $params, '1.0');
	}
	public function MoneyInIDealInit($params) {
		return self::sendRequest('MoneyInIDealInit', $params, '1.0');
	}
	public function MoneyInIDealConfirm($params) {
		return self::sendRequest('MoneyInIDealConfirm', $params, '1.0');
	}
	public function RegisterSddMandate($params) {
		$res = self::sendRequest('RegisterSddMandate', $params, '1.0');
		if (!isset($res->lwError)){
			$res->sddMandate = new SddMandate($res->lwXml->SDDMANDATE);
		}
		return $res;
	}
	public function UnregisterSddMandate($params) {
		return self::sendRequest('UnregisterSddMandate', $params, '1.0');
	}
	public function MoneyInSddInit($params) {
		return self::sendRequest('MoneyInSddInit', $params, '1.0');
	}
	public function GetMoneyInSdd($params) {
		return self::sendRequest('GetMoneyInSdd', $params, '1.0');
	}
	public function GetMoneyInChequeDetails($params) {
		return self::sendRequest('GetMoneyInChequeDetails', $params, '1.4');
	}
	
	private function printDirectkitOutput($res){
		if (self::$printInputAndOutputXml){
			print '<br/>DEBUG OUTPUT START<br/>';
			foreach ($res[0] as $keyLevel1=>$valueLevel1) {
				print (string)$keyLevel1.' : '.(string)$valueLevel1;
				if ($valueLevel1->count() > 0){
					foreach ($valueLevel1 as $keyLevel2=>$valueLevel2) {
						print '<br/>----'.(string)$keyLevel2.' : '.(string)$valueLevel2;
						if ($valueLevel2->count() > 0){
							foreach ($valueLevel2 as $keyLevel3=>$valueLevel3) {
								print '<br/>--------'.(string)$keyLevel3.' : '.(string)$valueLevel3;
								if ($valueLevel3->count() > 0){
									foreach ($valueLevel3 as $keyLevel4=>$valueLevel4) {
										print '<br/>------------'.(string)$keyLevel4.' : '.(string)$valueLevel4;
									}
								}
							}
						}
					}
				}
			}
			print '<br/>DEBUG OUTPUT END<br/>';
		}
	}
	
	private function printDirectkitInput($string){
		if (self::$printInputAndOutputXml){
			print '<br/>DEBUG INTPUT START<br/>';
			echo htmlentities($string);
			//$xml = new SimpleXMLElement($string); echo $xml->asXML();
			print '<br/>DEBUG INTPUT END<br/>';
		}
	}
	private function sendRequest($methodName, $params, $version){
		$xmlns = 'Service_mb_xml';
		$ua = '';
		if (isset($_SERVER['HTTP_USER_AGENT']))
			$ua = $_SERVER['HTTP_USER_AGENT'];
		$ip = '';
		if (isset($_SERVER['REMOTE_ADDR']))
			$ip = $_SERVER['REMOTE_ADDR'];
			
		$xml_soap = '<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><'.$methodName.' xmlns="'.$xmlns.'">';
		
		foreach ($params as $key => $value) {
			$xml_soap .= '<'.$key.'>'.$value.'</'.$key.'>';
		}
		$xml_soap .= '<version>'.$version.'</version>';
		$xml_soap .= '<wlPass>'.self::$accessConfig['wlPass'].'</wlPass>';
		$xml_soap .= '<wlLogin>'.self::$accessConfig['wlLogin'].'</wlLogin>';
		$xml_soap .= '<language>'.self::$accessConfig['language'].'</language>';
		$xml_soap .= '<walletIp>'.$ip.'</walletIp>';
		$xml_soap .= '<walletUa>'.$ua.'</walletUa>';
		
		$xml_soap .= '</'.$methodName.'></soap12:Body></soap12:Envelope>';
		self::printDirectkitInput($xml_soap);
						
		$headers = array("Content-type: text/xml;charset=utf-8",
						"Accept: application/xml",
						"Cache-Control: no-cache",
						"Pragma: no-cache",
						'SOAPAction: "'.$xmlns.'/'.$methodName.'"',
						"Content-length: ".strlen($xml_soap),
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::$accessConfig['directKitUrl']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_soap);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($ch);

		if(curl_errno($ch))
		{
			print('curl_err : '.curl_error($ch)); //TODO : handle error
		} else {
			$returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			switch($returnCode){
				case 200:
					//General parsing
					//Cleanup XML
					$response = (string)str_replace('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">', '', $response);
					$response = (string)str_replace('</soap:Envelope>', '', $response);
					libxml_use_internal_errors(true);
					$xml = new SimpleXMLElement($response);
					//Retrieve result
					$content = $xml->{$methodName.'Response'}->{$methodName.'Result'};
					self::printDirectkitOutput($content);
					return new ApiResponse($content);
				case 400:
					print "Bad Request : The server cannot or will not process the request due to something that is perceived to be a client error";
					break;
				case 403:
					print "IP is not allowed to access Lemon Way's API, please contact support@lemonway.fr";
					break;
				case 404:
					print "Check that the access URLs are correct. If yes, please contact support@lemonway.fr";
					break;
				case 500:
					print "Lemon Way internal server error, please contact support@lemonway.fr";
					break;
				default:
					break;
			}
			print('http code : '. $returnCode); //TODO : handle http error code
		}
	}
	
	public function printCardForm($moneyInToken, $cssUrl = '', $language = 'fr'){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::$accessConfig['webkitUrl']."?moneyintoken=".$moneyInToken.'&p='.urlencode($cssUrl).'&lang='.$language);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$server_output = curl_exec ($ch);
		if(curl_errno($ch))
		{
			print(curl_error($ch));//TODO : handle error
		} else {
			$returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
			switch($returnCode){
				case 200:
					curl_close ($ch);
					print($server_output);
					break;
				default:
					print($returnCode);//TODO : handle error
					break;
			}
		}
	}
}
?>