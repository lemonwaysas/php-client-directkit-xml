<?php

class Iban{

	/**
     * ID as defined by Lemon Way
     * @var string
     */
    public $ID;
	
	/**
     * STATUS {0,5,6,8,9}
     * @var string
     */
    public $STATUS;
	
	/**
     * IBAN number
     * @var string
     */
    public $IBAN;
	
	/**
     * BIC or swift code
     * @var string
     */
    public $BIC;
	
	/**
     * DOM1 address line 1
     * @var string
     */
    public $DOM1;
	/**
     * DOM2 address line 2
     * @var string
     */
    public $DOM2;
	
	function __construct($node) {
		$this->ID = $node->ID;
		if (isset($node->STATUS))
			$this->STATUS = $node->STATUS;
		if (isset($node->S))
			$this->STATUS = $node->S;
		if (isset($node->DATA))
			$this->IBAN = $node->DATA;
		if (isset($node->SWIFT))
			$this->BIC = $node->SWIFT;
	}
	
}

?>