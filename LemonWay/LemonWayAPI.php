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
     * LemonWayKit constructor.
     *
     * @param string $directKitUrl
     * @param string $webKitUrl
     * @param string $login
     * @param string $password
     * @param string $lang
     * @param bool $debug
     * @param bool $sslVerification
     * @param string $xmlns
     */
    public function __construct(
        $directKitUrl = '',
        $webKitUrl = '',
        $login = '',
        $password = '',
        $lang = 'en',
        $debug = false,
        $sslVerification = true,
        $xmlns = 'Service_mb_xml'
    ) {
        $this->config = new Lib\Config();
        $this->config->dkUrl = $directKitUrl;
        $this->config->wkUrl = $webKitUrl;
        $this->config->sslVerification = $sslVerification;
        $this->config->wlLogin = $login;
        $this->config->wlPass = $password;
        $this->config->lang = $lang;
        $this->config->isDebugEnabled = $debug;
        $this->config->xmlns = $xmlns;
    }

    /**
     * Register Wallet
     *
     * @param array $params
     *
     * @return ApiResponse
     */
    public function registerWallet($params)
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
    public function moneyIn($params)
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
    public function updateWalletDetails($params)
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
    public function getWalletDetails($params)
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
    public function moneyIn3DInit($params)
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
    public function moneyIn3DConfirm($params)
    {
        $res = $this->sendRequest('MoneyIn3DConfirm', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->MONEYIN3DCONFIRM->HPAY);
        }
        return $res;
    }

    /**
     * Money In Web Init
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function moneyInWebInit($params)
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
    public function registerCard($params)
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
    public function unregisterCard($params)
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
    public function moneyInWithCardId($params)
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
    public function moneyInValidate($params)
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
    public function sendPayment($params)
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
    public function registerIBAN($params)
    {
        $res = $this->sendRequest('RegisterIBAN', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->iban = new Models\Iban($res->lwXml->IBAN);
        }

        return $res;
    }

    /**
     * Register IBAN Extended
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function registerIBANExtended($params)
    {
        $res = $this->sendRequest('RegisterIBANExtended', $params, '1.1');
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
    public function moneyOut($params)
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
    public function getPaymentDetails($params)
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
    public function getMoneyInTransDetails($params)
    {
        $res = $this->sendRequest('GetMoneyInTransDetails', $params, '10.0');
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
    public function getMoneyOutTransDetails($params)
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
    public function uploadFile($params)
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
    public function getKycStatus($params)
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
    public function getMoneyInIBANDetails($params)
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
    public function refundMoneyIn($params)
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
    public function getBalances($params)
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
    public function moneyIn3DAuthenticate($params)
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
    public function moneyInIDealInit($params)
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
    public function moneyInIDealConfirm($params)
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
    public function registerSddMandate($params)
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
    public function unregisterSddMandate($params)
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
    public function moneyInSddInit($params)
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
    public function getMoneyInSdd($params)
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
    public function getMoneyInChequeDetails($params)
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
    public function getWalletTransHistory($params)
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
    public function updateWalletStatus($params)
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
    public function signDocumentInit($params)
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
    public function moneyInChequeInit($params)
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
    public function moneyInSofortInit($params)
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
    public function moneyInNeosurf($params)
    {
        $res = $this->sendRequest('MoneyInNeosurf', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operation = new Models\Operation($res->lwXml->TRANS->HPAY);
        }

        return $res;
    }

    /**
     * Create Payment Form
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function createPaymentForm($params)
    {
        return $this->sendRequest('CreatePaymentForm', $params, '1.0');
    }

    /**
     * Disable Payment Form
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function disablePaymentForm($params)
    {
        return $this->sendRequest('DisablePaymentForm', $params, '1.0');
    }

    /**
     * Get Completed Payment Form
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function getCompletedPaymentForm($params)
    {
        return $this->sendRequest('GetCompletedPaymentForm', $params, '1.0');
    }

    /**
     * Get Charge backs
     *
     * @param array     $params
     *
     * @return ApiResponse
     */
    public function getChargebacks($params)
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
    public function createVCC($params)
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
    public function getWizypayAds($params)
    {
        return $this->sendRequest('GetWizypayAds', $params, '1.0');
    }

    public function createLoginBo($params)
    {
        return $this->sendRequest('CreateLoginBo', $params, '1.0');
    }

    public function updateLoginBo($params)
    {
        return $this->sendRequest('UpdateLoginBo', $params, '1.0');
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
     * @param string $methodName
     * @param array $params
     * @param string $version
     *
     * @return ApiResponse
     *
     * @throws LwException
     */
    private function sendRequest($methodName, $params, $version)
    {
        $xmlns = $this->config->xmlns;

        $ua = '';
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $ua = $_SERVER['HTTP_USER_AGENT'];
        } elseif ($this->config->user_agent) {
            $ua = $this->config->user_agent;
        }

        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $tmpip = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($tmpip[0]);
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } elseif ($this->config->remote_addr) {
            $ip = $this->config->remote_addr;
        }

        $xml_soap = '<?xml version="1.0" encoding="utf-8"?>'
            . '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'
            . ' xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">'
            . '<soap12:Body>'
            . '<' . $methodName . ' xmlns="' . $xmlns . '">';

        foreach ($params as $key => $value) {
            $xml_soap .= '<' . $key . '>' . $this->cleanRequest($value) . '</' . $key . '>';
        }
        $xml_soap .= '<version>' . $version . '</version>';
        $xml_soap .= '<wlPass>' . $this->cleanRequest($this->config->wlPass) . '</wlPass>';
        $xml_soap .= '<wlLogin>' . $this->cleanRequest($this->config->wlLogin) . '</wlLogin>';
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_soap);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->config->sslVerification);

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
                    switch ($methodName) {
                        case 'UnregisterSddMandate':
                            $content = $xml->{$methodName . 'Response'}->{'UnRegisterSddMandateResult'};
                            break;

                        case 'MoneyInWithCardId':
                            $content = $xml->{$methodName.'Response'}->{'MoneyInResult'};
                            break;

                        case 'GetChargebacks':
                            $content = $xml->{$methodName.'Response'}->{'GetChargeBacksResult'};
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
                    throw new LwException("IP is not allowed to access Lemon Way's API, please contact support@lemonway.com", LwException::BAD_IP);
                    break;
                case 404:
                    throw new LwException("Check that the access URLs are correct. If yes, please contact support@lemonway.com", LwException::NOT_FOUND);
                    break;
                case 500:
                    throw new LwException("Lemon Way internal server error, please contact support@lemonway.com", LwException::INTERNAL_ERROR);
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
     * @param string $moneyInToken
     * @param string $cssUrl
     * @param string $language
     *
     * @throws LwException
     */
    public function printCardForm($moneyInToken, $cssUrl = '', $language = 'en')
    {
        // If Payxpert
        // echo("<script>location.href = '".$this->config->wkUrl . "?moneyintoken=" . $moneyInToken . '&p=' . urlencode($cssUrl) . '&lang=' . $language."';</script>");

        // If Atos
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->wkUrl . "?moneyintoken=" . $moneyInToken . '&p=' . urlencode($cssUrl) . '&lang=' . $language);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->config->sslVerification);

        $server_output = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('curl_err : ' . curl_error($ch));
            throw new LwException(curl_error($ch), LwException::UNKNOWN_ERROR);
        } else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch ($returnCode) {
                case 200:
                    curl_close($ch);
                    $parsedUrl = parse_url($this->config->wkUrl);
                    $root = strstr($this->config->wkUrl, $parsedUrl['path'], true);
                    $server_output = preg_replace("/src=\"([a-zA-Z\/\.]*)\"/i", "src=\"" . $root . "$1\"", $server_output);
                    echo($server_output);
                    break;
                default:
                    throw new LwException("An error has occured for HTTP code $returnCode", $returnCode);
                    break;
            }
        }
    }

    private function cleanRequest($str)
    {
        $str = str_replace('&', htmlentities('&'), $str);
        $str = str_replace('<', htmlentities('<'), $str);
        $str = str_replace('>', htmlentities('>'), $str);

        return $str;
    }

    /**
     * Allows us to call methods with first character in uppercase.
     *
     * @param  string $methodName
     * @param  array $arguments
     * @return mixed
     */
    public function __call($methodName, $arguments)
    {
        if (method_exists($this, lcfirst($methodName))) {
            return call_user_func_array([$this, lcfirst($methodName)], $arguments);
        }

        $className = static::class;

        throw new \BadMethodCallException("Call to undefined method {$className}::{$methodName}()");
    }
}
