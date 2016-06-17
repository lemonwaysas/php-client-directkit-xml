<?php
namespace LemonWay;

use LemonWay\Lib\LwException;

class LemonWayAPI
{
    /**
     * Configuration instance
     * @var \LemonWay\Lib\Config
     */
    public $config;

    /**
     * Used for Debug mode
     * @var boolean
     */
    private $printInputAndOutputXml = false;

    /**
     * LemonWayKit constructor.
     */
    public function __construct($directKitUrl = '', $webKitUrl = '', $login = '', $password = '', $lang = 'fr', $debug = false)
    {
        $this->config = new Lib\Config();
        $this->config->dkUrl = $directKitUrl;
        $this->config->wkUrl = $webKitUrl;
        $this->config->wlLogin = $login;
        $this->config->wlPass = $password;
        $this->config->lang = $lang;
        $this->config->isDebugEnabled = $debug;
    }

    /**
     * Register Wallet
     *
     * @param array $params
     *
     * @return ApiResponse
     */
    public function RegisterWallet($params)
    {
        $res = $this->sendRequest('RegisterWallet', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->wallet = new Models\Wallet($res->lwXml->WALLET);
        }

        return $res;
    }

    /**
     * Money In
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyIn($params)
    {
        $res = $this->sendRequest('MoneyIn', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Update Wallet Details
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function UpdateWalletDetails($params)
    {
        $res = $this->sendRequest('UpdateWalletDetails', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->wallet = new Models\Wallet($res->lwXml->WALLET);
        }

        return $res;
    }

    /**
     * Get Wallet Details
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetWalletDetails($params)
    {
        $res = $this->sendRequest('GetWalletDetails', $params, '1.8');
        if (!isset($res->lwError)) {
            $res->wallet = new Models\Wallet($res->lwXml->WALLET);
        }

        return $res;
    }

    /**
     * Money In 3D Init
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyIn3DInit($params)
    {
        $res = $this->sendRequest('MoneyIn3DInit', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->MONEYIN3DINIT->TRANS->HPAY);
            $res->acs = new Models\Acs($res->lwXml->MONEYIN3DINIT->ACS);
        }

        return $res;
    }

    /**
     * Money In 3D Confirm
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyIn3DConfirm($params)
    {
        return $this->sendRequest('MoneyIn3DConfirm', $params, '1.1');
    }

    /**
     * Money In Web Init
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyInWebInit($params)
    {
        return $this->sendRequest('MoneyInWebInit', $params, '1.3');
    }

    /**
     * Register Card
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function RegisterCard($params)
    {
        $res = $this->sendRequest('RegisterCard', $params, '1.2');
        if (!isset($res->lwError)) {
            $res->card = new Models\Card($res->lwXml->CARD);
        }
        return $res;
    }

    /**
     * Unregister Card
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function UnregisterCard($params)
    {
        $res = $this->sendRequest('UnregisterCard', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->card = new Models\Card($res->lwXml->CARD);
        }
        return $res;
    }

    /**
     * Money In With Card Id
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyInWithCardId($params)
    {
        $res = $this->sendRequest('MoneyInWithCardId', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Money In Validate
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyInValidate($params)
    {
        $res = $this->sendRequest('MoneyInValidate', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->MONEYIN->HPAY);
        }

        return $res;
    }

    /**
     * Send Payment
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function SendPayment($params)
    {
        $res = $this->sendRequest('SendPayment', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Register IBAN
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function RegisterIBAN($params)
    {
        $res = $this->sendRequest('RegisterIBAN', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->iban = new Models\Iban($res->lwXml->IBAN);
        }

        return $res;
    }

    /**
     * Money Out
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyOut($params)
    {
        $res = $this->sendRequest('MoneyOut', $params, '1.3');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Get Payement Details
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetPaymentDetails($params)
    {
        $res = $this->sendRequest('GetPaymentDetails', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = new Models\Operation($HPAY);
            }
        }

        return $res;
    }

    /**
     * Get Money In Trans Details
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetMoneyInTransDetails($params)
    {
        $res = $this->sendRequest('GetMoneyInTransDetails', $params, '1.6');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = new Models\Operation($HPAY);
            }
        }

        return $res;
    }

    /**
     * Get Money Out Trans Details
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetMoneyOutTransDetails($params)
    {
        $res = $this->sendRequest('GetMoneyOutTransDetails', $params, '1.4');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = new Models\Operation($HPAY);
            }
        }

        return $res;
    }

    /**
     * Upload File
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function UploadFile($params)
    {
        $res = $this->sendRequest('UploadFile', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->kycDoc = new Models\KycDoc($res->lwXml->UPLOAD);
        }

        return $res;
    }

    /**
     * Get Kyc Status
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetKycStatus($params)
    {
        $res = $this->sendRequest('GetKycStatus', $params, '1.5');
        if (!isset($res->lwError)) {
            $res->wallets = array();
            foreach ($res->lwXml->WALLETS->WALLET as $WALLET) {
                $res->wallets[] = new Models\Wallet($WALLET);
            }
        }

        return $res;
    }

    /**
     * Get Money In IBAN Details
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetMoneyInIBANDetails($params)
    {
        $res = $this->sendRequest('GetMoneyInIBANDetails', $params, '1.4');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = new Models\Operation($HPAY);
            }
        }

        return $res;
    }

    /**
     * Refund Money In
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function RefundMoneyIn($params)
    {
        $res = $this->sendRequest('RefundMoneyIn', $params, '1.2');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Get Balances
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetBalances($params)
    {
        $res = $this->sendRequest('GetBalances', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->wallets = array();
            foreach ($res->lwXml->WALLETS->WALLET as $WALLET) {
                $res->wallets[] = new Models\Wallet($WALLET);
            }
        }

        return $res;
    }

    /**
     * Money In 3D Authenticate
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyIn3DAuthenticate($params)
    {
        return $this->sendRequest('MoneyIn3DAuthenticate', $params, '1.0');
    }

    /**
     * Money In Deal Init
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyInIDealInit($params)
    {
        return $this->sendRequest('MoneyInIDealInit', $params, '1.0');
    }

    /**
     * Money In Deal Confirm
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyInIDealConfirm($params)
    {
        $res = $this->sendRequest('MoneyInIDealConfirm', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;

    }

    /**
     * Register Sdd Mandate
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function RegisterSddMandate($params)
    {
        $res = $this->sendRequest('RegisterSddMandate', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->sddMandate = new Models\SddMandate($res->lwXml->SDDMANDATE);
        }

        return $res;
    }

    /**
     * Unregister SDD Mandate
     *
     * @param array    $params
     *
     * @return ApiResponse
     */
    public function UnregisterSddMandate($params)
    {
        $res = $this->sendRequest('UnregisterSddMandate', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->sddMandate = new Models\SddMandate($res->lwXml->SDDMANDATE);
        }

        return $res;
    }

    /**
     * Money In SDD Init
     *
     * @param array     $params
     * @return ApiResponse
     */
    public function MoneyInSddInit($params)
    {
        $res = $this->sendRequest('MoneyInSddInit', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }
        return $res;

    }

    /**
     * Get Money In SDD
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetMoneyInSdd($params)
    {
        $res = $this->sendRequest('GetMoneyInSdd', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = new Models\Operation($HPAY);
            }
        }
        return $res;
    }

    /**
     * Get Money In Cheque Details
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetMoneyInChequeDetails($params)
    {
        $res = $this->sendRequest('GetMoneyInChequeDetails', $params, '1.9');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = new Models\Operation($HPAY);
            }
        }
        return $res;
    }


    /**
     * Get Wallet Trans History
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetWalletTransHistory($params)
    {
        $res = $this->sendRequest('GetWalletTransHistory', $params, '2.0');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = new Models\Operation($HPAY);
            }
        }

        return $res;
    }

    /**
     * Update Wallet Status
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function UpdateWalletStatus($params)
    {
        $res = $this->sendRequest('UpdateWalletStatus', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->wallet = new Models\Wallet($res->lwXml->WALLET);
        }

        return $res;
    }

    /**
     * Sign document Init for SDD
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function SignDocumentInit($params)
    {
        return $this->sendRequest('SignDocumentInit', $params, '1.0');
    }

    /**
     * Init Cheque
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyInChequeInit($params)
    {
        $res = $this->sendRequest('MoneyInChequeInit', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Money In Sofor Init
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyInSofortInit($params)
    {
        return $this->sendRequest('MoneyInSofortInit', $params, '1.0');
    }

    /**
     * Money In Neosurf
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function MoneyInNeosurf($params)
    {
        $res = $this->sendRequest('MoneyInNeosurf', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Get Charge backs
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetChargebacks($params)
    {
        $res = $this->sendRequest('GetChargebacks', $params, '1.8');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = new Models\Operation($HPAY);
            }
        }

        return $res;
    }


    /**
     * Ceeate Virtual Credit Card
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function CreateVCC($params)
    {
        $res = $this->sendRequest('CreateVCC', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Get Offers and Ads from Partners
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function GetWizypayAds($params)
    {
        return $this->sendRequest('GetWizypayAds', $params, '1.0');
    }

    /**
     * Print Direct API Output
     *
     * @param string    $res
     */
    private function printDirectkitOutput($res)
    {
        if ($this->config->isDebugEnabled) {
            print '<br/>DEBUG OUTPUT START<br/>';
            foreach ($res[0] as $keyLevel1 => $valueLevel1) {
                print (string)$keyLevel1 . ' : ' . (string)$valueLevel1;
                if ($valueLevel1->count() > 0) {
                    foreach ($valueLevel1 as $keyLevel2 => $valueLevel2) {
                        print '<br/>----' . (string)$keyLevel2 . ' : ' . (string)$valueLevel2;
                        if ($valueLevel2->count() > 0) {
                            foreach ($valueLevel2 as $keyLevel3 => $valueLevel3) {
                                print '<br/>--------' . (string)$keyLevel3 . ' : ' . (string)$valueLevel3;
                                if ($valueLevel3->count() > 0) {
                                    foreach ($valueLevel3 as $keyLevel4 => $valueLevel4) {
                                        print '<br/>------------' . (string)$keyLevel4 . ' : ' . (string)$valueLevel4;
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

    /**
     * Print Direct API Input
     *
     * @param string    $string
     */
    private function printDirectkitInput($string)
    {
        if ($this->config->isDebugEnabled) {
            print '<br/>DEBUG INTPUT START<br/>';
            echo htmlentities($string);
            //$xml = new SimpleXMLElement($string); echo $xml->asXML();
            print '<br/>DEBUG INTPUT END<br/>';
        }
    }

    /**
     * Send Request to DirectKitUrl
     *
     * @param string    $methodName
     * @param array     $params
     * @param string    $version
     *
     * @return ApiResponse
     */
    private function sendRequest($methodName, $params, $version)
    {
        $xmlns = 'Service_mb_xml';
        
        $ua = '';
        if($this->config->user_agent){
            $ua = $this->config->user_agent;
        } elseif(isset($_SERVER['HTTP_USER_AGENT'])){
            $ua = $_SERVER['HTTP_USER_AGENT'];
        }
        
        $ip = '';
        if($this->config->remote_addr){
            $ip = $this->config->remote_addr;
        } elseif(isset($_SERVER['REMOTE_ADDR'])){
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $xml_soap = '<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><' . $methodName . ' xmlns="' . $xmlns . '">';

        foreach ($params as $key => $value) {
            $value = str_replace("&", urlencode("&"), $value);
            $xml_soap .= '<' . $key . '>' . $value . '</' . $key . '>';
        }
        $xml_soap .= '<version>' . $version . '</version>';
        $xml_soap .= '<wlPass>' . $this->config->wlPass . '</wlPass>';
        $xml_soap .= '<wlLogin>' . $this->config->wlLogin . '</wlLogin>';
        $xml_soap .= '<language>' . $this->config->lang . '</language>';
        $xml_soap .= '<walletIp>' . $ip . '</walletIp>';
        $xml_soap .= '<walletUa>' . $ua . '</walletUa>';

        $xml_soap .= '</' . $methodName . '></soap12:Body></soap12:Envelope>';
        $this->printDirectkitInput($xml_soap);

        $headers = array("Content-type: text/xml;charset=utf-8",
            "Accept: application/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            'SOAPAction: "' . $xmlns . '/' . $methodName . '"',
            "Content-length: " . strlen($xml_soap),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->dkUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_soap);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            error_log('curl_err : ' . curl_error($ch));
            throw new LwException(curl_error($ch), LwException::UNKNOWN_ERROR);
        } else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            switch ($returnCode) {
                case 200:
                    //General parsing
                    //Cleanup XML
                    $response = (string)str_replace('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">', '', $response);
                    $response = (string)str_replace('</soap:Envelope>', '', $response);
                    libxml_use_internal_errors(true);
                    $xml = new \SimpleXMLElement($response);
                    //Retrieve result
                    $content = '';
                    switch($methodName){
                        case 'UpdateWalletDetails':
                            $content = $xml->{$methodName . 'Response'}->{'UpdateWalletStatusResult'};
                            break;

                        case 'UnregisterSddMandate':
                            $content = $xml->{$methodName . 'Response'}->{'UnRegisterSddMandateResult'};
                            break;

                        case 'MoneyInWithCardId':
                            $content = $xml->{$methodName.'Response'}->{'MoneyInResult'};
                            break;

                        default:
                            $content = $xml->{$methodName . 'Response'}->{$methodName . 'Result'};
                            break;
                    }

                    $this->printDirectkitOutput($content);
                    return new ApiResponse($content);
                case 400:
                    throw new LwException("Bad Request : The server cannot or will not process the request due to something that is perceived to be a client error", LwException::BAD_REQUEST);
                    break;
                case 403:
                    throw new LwException("IP is not allowed to access Lemon Way's API, please contact support@lemonway.fr", LwException::BAD_IP);
                    break;
                case 404:
                    throw new LwException("Check that the access URLs are correct. If yes, please contact support@lemonway.fr", LwException::NOT_FOUND);
                    break;
                case 500:
                    throw new LwException("Lemon Way internal server error, please contact support@lemonway.fr", LwException::INTERNAL_ERROR);
                    break;
                default:
                    break;
            }
            throw new LwException("An error has occured for HTTP code $returnCode", $returnCode);
        }
    }

    /**
     * Print Card Form
     *
     * @param string    $moneyInToken
     * @param string    $cssUrl
     * @param string    $language
     */
    public function printCardForm($moneyInToken, $cssUrl = '', $language = 'fr')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->wkUrl . "?moneyintoken=" . $moneyInToken . '&p=' . urlencode($cssUrl) . '&lang=' . $language);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $server_output = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('curl_err : ' . curl_error($ch));
            throw new LwException(curl_error($ch), LwException::UNKNOWN_ERROR);
        } else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch ($returnCode) {
                case 200:
                    curl_close($ch);
                    print($server_output);
                    break;
                default:
                    throw new LwException("An error has occured for HTTP code $returnCode", $returnCode);
                    break;
            }
        }
    }
}

?>
