<?php

class SddMandate{

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