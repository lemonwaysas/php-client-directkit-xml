<?php
namespace LemonWay;

use LemonWay\Models\Acs;
use LemonWay\Models\Operation;
use LemonWay\Models\Wallet;
use LemonWay\Models\KycDoc;
use LemonWay\Models\Iban;
use LemonWay\Models\SddMandate;
use LemonWay\Models\Card;
use LemonWay\Models\Vcc;
use LemonWay\Models\IDeal;

class ApiResponse
{
    function __construct($xmlResponse)
    {
        $this->lwXml = $xmlResponse;
        if (isset($xmlResponse->E)) {
            $this->lwError = new Models\LwError($xmlResponse->E->Code, $xmlResponse->E->Msg .
             " (" . $xmlResponse->E->Error . ")");
        }
    }
    
    /**
     * lwXml
     * @var SimpleXMLElement
     */
    public $lwXml;
    
    /**
     * lwError
     * @var LwError
     */
    public $lwError;
    
    /**
     * wallet
     * @var Wallet
     */
    public $wallet;

    /**
     * wallets
     * @var array Wallet
     */
    public $wallets;
    
    /**
     * operations
     * @var array Operation
     */
    public $operations;

    /**
     * operation
     * @var Operation
     */
    public $operation;
    
    /**
     * kycDoc
     * @var KycDoc
     */
    public $kycDoc;
    
    /**
     * iban
     * @var Iban
     */
    public $iban;
    
    /**
     * sddMandate
     * @var SddMandate
     */
    public $sddMandate;

    /**
     * acs
     * @var Acs
     */
    public $acs;

    /**
     * vcc
     * @var Vcc
     */
    public $vcc;

    /**
     * card
     * @var Card
     */
    public $card;

    /**
     * ideal
     * @var IDeal
     */
    public $ideal;
}
