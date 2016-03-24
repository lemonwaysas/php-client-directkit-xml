<?php
class ApiResponse{
	function __construct($xmlResponse) {
        $this->lwXml = $xmlResponse;
		if (isset($xmlResponse->E)){
			$this->lwError = new LwError($xmlResponse->E->Code, $xmlResponse->E->Msg);
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
     * operations
     * @var array Operation
     */
    public $operations;
	
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
}

?>