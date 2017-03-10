<?php
namespace LemonWay\Models;

class Wallet
{

    const MISTER = 'M';
    const MADAM = 'F';
    const JOINT = 'J';
    const UNKNOWN = 'U';

    const AUTO_COMMISSION = '1';
    const NO_AUTO_COMMISSION = '0';

    const ATOS_PRE_AUTH = '1';
    const NO_ATOS_PRE_AUTH = '0';

    const WALLET_BLOCKED = '1';
    const WALLET_NOT_BLOCKED = '0';

    const STATUS_KYC_1 = '5';
    const STATUS_KYC_2 = '6';
    const STATUS_CLOSED = '12';

    /**
     * ID as defined by merchant
     * @var string
     */
    public $ID;

    /**
     * LWID number ID as defined by Lemon Way
     * @var string
     */
    public $LWID;

    /**
     * STATUS {2,3,4,5,6,7,8,12}
     * @var string
     */
    public $STATUS;

    /**
     * BAL balance
     * @var string
     */
    public $BAL;

    /**
     * NAME full name
     * @var string
     */
    public $NAME;

    /**
     * EMAIL
     * @var string
     */
    public $EMAIL;

    /**
     * BLOCKED {0,1}
     * @var string
     */
    public $BLOCKED;

    /**
     * kycDocs
     * @var array KycDoc
     */
    public $kycDocs;

    /**
     * ibans
     * @var array Iban
     */
    public $ibans;

    /**
     * sddMandates
     * @var array SddMandate
     */
    public $sddMandates;

    /**
     * cards
     * @var array Card
     */
    public $cards;


    public function __construct($WALLET)
    {
        $this->ID = $WALLET->ID;
        $this->LWID = $WALLET->LWID;
        $this->STATUS = $WALLET->STATUS;
        $this->BAL = $WALLET->BAL;
        $this->NAME = $WALLET->NAME;
        $this->EMAIL = $WALLET->EMAIL;
        $this->BLOCKED = $WALLET->BLOCKED;
        $this->kycDocs = array();
        if (isset($WALLET->DOCS)) {
            foreach ($WALLET->DOCS->DOC as $DOC) {
                $this->kycDocs[] = new KycDoc($DOC);
            }
        }
        $this->ibans = array();
        if (isset($WALLET->IBANS)) {
            foreach ($WALLET->IBANS->IBAN as $IBAN) {
                $this->ibans[] = new Iban($IBAN);
            }
        }
        $this->sddMandates = array();
        if (isset($WALLET->SDDMANDATES)) {
            foreach ($WALLET->SDDMANDATES->SDDMANDATE as $SDDMANDATE) {
                $this->sddMandates[] = new SddMandate($SDDMANDATE);
            }
        }
        $this->cards = array();
        if (isset($WALLET->CARDS)) {
            foreach ($WALLET->CARDS->CARD as $CARD) {
                $this->cards[] = new Card($CARD);
            }
        }
    }
}
