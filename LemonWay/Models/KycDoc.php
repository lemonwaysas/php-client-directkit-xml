<?php
namespace LemonWay\Models;
class KycDoc {
	const STATUS_ON_HOLD = '0';
	const STATUS_RECEIVED = '1';
	const STATUS_CHECKED_VALIDATED = '2';
	const STATUS_CHECKED_NOT_VALIDATED = '3';
	const STATUS_REPLACED = '4';
	const STATUS_EXPIRED = '5';
	const STATUS_WRONG_TYPE = '6';
	const STATUS_WRONG_NAME = '7';

	const TYPE_ID_CARD = '0';
	const TYPE_PROOF_OF_ADDRESS = '1';
	const TYPE_BANK_ID = '2';
	const TYPE_SOCIETY_ID = '7';
	const TYPE_KBIS = '7';
	const TYPE_MISC = '11';
	const TYPE_MISC_2 = '12';
	const TYPE_MISC_3 = '13';
	const TYPE_MISC_4 = '14';
	const TYPE_MISC_5 = '15';
	const TYPE_MISC_6 = '16';
	const TYPE_MISC_7 = '17';
	const TYPE_MISC_8 = '18';
	const TYPE_MISC_9 = '19';
	const TYPE_MISC_10 = '20';
	const TYPE_SDD_MANDATE = '21';

	const SIGNING_SUCCESS = 'return';
	const SIGNING_ERROR = 'error';

	/**
     * ID as defined by Lemon Way
     * @var string
     */
    public $ID;
	
	/**
     * STATUS {1,2,3,4,5}
     * @var string
     */
    public $STATUS;
	
	/**
     * TYPE {0,1,2,3,4,5,6,7,11,12,13,14,15,16,17,18,19,20,21}
     * @var string
     */
    public $TYPE;
	
	/**
     * VD validity date
     * @var string
     */
    public $VD;

	/**
	 * CHANGED_DATE changed date
	 * @var string
	 */
	public $CHANGED_DATE;

	/**
	 * COMMENT
	 * @var string
	 */
	public $COMMENT;
	
	function __construct($node) {
		$this->ID = $node->ID;
		$this->STATUS = $node->S;
		$this->TYPE = $node->TYPE;
		$this->VD = $node->VD;
		$this->COMMENT = $node->C;
		$this->CHANGED_DATE = $node->D;
	}
}

?>
