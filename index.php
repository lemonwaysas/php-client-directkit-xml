<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr-FR"> 
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<title>Lemon Way Examples</title>
</head>
<body>
<?php
require_once 'includes.php';

//Examples::RegisterWallet();
//Examples::MoneyIn();
//Examples::UploadFile();
//Examples::SendPayment();
//Examples::MoneyOut();
//Examples::GetMoneyInTransDetails();
//Examples::GetWalletDetails();
//Examples::Rebill();
//Examples::UpdateWalletDetails();

/*
//Money-in by card with 3D Secure, using Atos/BNP card form
if (isset($_POST) && sizeof($_POST) > 0){
	//notification from Lemon Way's server. Will not work if you're testing using a local return URL
	foreach ($_POST as $key => $value) {
		//TODO : You cannot print but you can log the POST data
	}
	if (isset($_POST['response_transactionId'])){
		//call GetMoneyInTransDetails to retrieve payment status, and proceed depending on result. 
		Examples::MoneyInWebFinalize('', $_POST['response_transactionId'], false);
	}
} else if (isset ($_GET) && sizeof($_GET) > 0){
	//user browser is returning from payment
	print 'GET : ';
	foreach ($_GET as $key => $value) {
		print ('<br/>'.$key.' : '.$value.'');
	}
	if (isset($_GET['response_wkToken'])){
		//call GetMoneyInTransDetails to retrieve payment status, and proceed depending on result. 
		Examples::MoneyInWebFinalize($_GET['response_wkToken'], '', true);
	}
} else {
	//initialize the 3D Secure payment
	Examples::MoneyInWebInit();
}*/

?>
</body>