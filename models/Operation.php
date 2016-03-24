<?php

class Operation {

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
     * STATUS {0,3,4}
     * @var string
     */
	public $STATUS;
	
	/**
     * INT_MSG internal error message with codes
     * @var string
     */
	public $INT_MSG;
	
	function __construct($hpayXml) {
		$this->ID = $hpayXml->ID;
		$this->SEN = $hpayXml->SEN;
		$this->REC = $hpayXml->REC;
		$this->DEB = $hpayXml->DEB;
		$this->CRED = $hpayXml->CRED;
		$this->COM = $hpayXml->COM;
		$this->STATUS = $hpayXml->STATUS;
		$this->MLABEL = $hpayXml->MLABEL;
		$this->INT_MSG = $hpayXml->INT_MSG;
		$this->EXTRA = new EXTRA($hpayXml->EXTRA);
	}
}

/**
 * Detailed information regarding Card payment
 */
class EXTRA{
	/**
     * IS3DS indicates if payment was 3D Secure
     * @var bool
     */
	public $IS3DS;
	
	/**
     * CTRY country of card
     * @var string
     */
	public $CTRY;
	
	/**
     * AUTH authorization number
     * @var string
     */
	public $AUTH;
	
	function __construct($extraXml) {
		$this->AUTH = $extraXml->AUTH;
		$this->IS3DS = $extraXml->IS3DS;
		$this->CTRY = $extraXml->CTRY;
	}
}

?>