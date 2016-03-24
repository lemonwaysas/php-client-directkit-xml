<?php

class Wallet{

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
	
	function __construct($WALLET) {
		$this->ID = $WALLET->ID;
		$this->LWID = $WALLET->LWID;
		$this->STATUS = $WALLET->STATUS;
		$this->BAL = $WALLET->BAL;
		$this->NAME = $WALLET->NAME;
		$this->EMAIL = $WALLET->EMAIL;
		$this->kycDocs = array();
		if (isset($WALLET->DOCS))
			foreach ($WALLET->DOCS->DOC as $DOC){
				$this->kycDocs[] = new KycDoc($DOC);
			}
		$this->ibans = array();
		if (isset($WALLET->IBANS))
			foreach ($WALLET->IBANS->IBAN as $IBAN){
				$this->ibans[] = new Iban($IBAN);
			}
		$this->sddMandates = array();
		if (isset($WALLET->SDDMANDATES))
			foreach ($WALLET->SDDMANDATES->SDDMANDATE as $SDDMANDATE){
				$this->sddMandates[] = new SddMandate($SDDMANDATE);
			}
	}
	
}

?>