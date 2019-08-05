<?php
namespace LemonWay\Models;

class Operation
{

    const STATUS_WAITING_FINALISATION = '0';
    const STATUS_SUCCES = '3';
    const STATUS_ERROR = '4';
    const STATUS_AWAITING_VALIDATION = '16';
    const TYPE_MONEY_IN = '0';
    const TYPE_MONEY_OUT = '1';
    const TYPE_P2P = '2';
    const METHOD_BANK_CARD = '0';
    const METHOD_INCOMING_WIRE = '1';
    const METHOD_OUTGOING_WIRE = '3';
    const METHOD_IDEAL = '13';
    const METHOD_SDD = '14';
    const METHOD_CHEQUE = '15';
    const METHOD_NEOSURF = '16';
    const OWNER_AUTHENTICATED = '00';
    const OWNER_NOT_AUTHENTICATED = '55';
    const OWNER_BY_PASS_ON_ACS = '62';
    /**
     * type {p2p, moneyin, moneyout}
     * @var string
     */
    public $type;
    /**
     * ID number
     * @var string
     */
    public $ID;
    /**
     * MLABEL iban number or card number
     * @var string
     */
    public $MLABEL;
    /**
     * SEN sender wallet (debited wallet)
     * @var string
     */
    public $SEN;
    /**
     * REC receiver wallet (credited wallet)
     * @var string
     */
    public $REC;
    /**
     * DATE Date
     *
     * @var string
     */
    public $DATE;
    /**
     * DEB debited amount, xx.xx
     * @var string
     */
    public $DEB;
    /**
     * CRED credited amount, xx.xx
     * @var string
     */
    public $CRED;
    /**
     * COM fees automatically sent to merchant wallet
     * @var string
     */
    public $COM;
    /**
     * MSG comment
     * @var string
     */
    public $MSG;
    /**
     * STATUS {0,3,4,16}
     * @var string
     */
    public $STATUS;
    /**
     * PRIVATE_DATA Private data
     *
     * @var string
     */
    public $PRIVATE_DATA;
    /**
     * SCHEDULED_DATE Scheduled date
     *
     * @var string
     */
    public $SCHEDULED_DATE;
    /**
     * TYPE {0,1,2}
     *
     * @var string
     */
    public $TYPE;
    /**
     * MTOKEN
     *
     * @var string
     */
    public $MTOKEN;
    /**
     * METHOD {0,1,3,13,14,15,16}
     *
     * @var string
     */
    public $METHOD;
    /**
     * INT_MSG internal error message with codes
     * @var string
     */
    public $INT_MSG;
    /**
     * BANK_REF Bank reference
     *
     * @var string
     */
    public $BANK_REF;
    /**
     * EXTRA
     *
     * @var Extra
     */
    public $EXTRA;
    /**
     * VCC
     * @var Vcc
     */
    public $VCC;

    /**
     * ORIGIN_ID
     * @var int
     */
    public $ORIGIN_ID;

    public function __construct($hpayXml)
    {
        $this->ID = $hpayXml->ID;
        $this->SEN = $hpayXml->SEN;
        $this->REC = $hpayXml->REC;
        $this->DATE = $hpayXml->DATE;
        $this->DEB = $hpayXml->DEB;
        $this->CRED = $hpayXml->CRED;
        $this->COM = $hpayXml->COM;
        $this->STATUS = $hpayXml->STATUS;
        $this->MLABEL = $hpayXml->MLABEL;
        $this->INT_MSG = $hpayXml->INT_MSG;
        $this->MSG = $hpayXml->MSG;
        $this->BANK_REF = $hpayXml->BANK_REF;
        $this->TYPE = $hpayXml->TYPE;
        $this->MTOKEN = $hpayXml->MTOKEN;
        $this->METHOD = $hpayXml->METHOD;

        $this->PRIVATE_DATA = $hpayXml->PRIVATE_DATA;
        $this->SCHEDULED_DATE = $hpayXml->SCHEDULED_DATE;
        $this->EXTRA = new Extra($hpayXml->EXTRA);
        $this->VCC = new Vcc($hpayXml->VCC);
        $this->ORIGIN_ID = $hpayXml->ORIGIN_ID;
    }
}
