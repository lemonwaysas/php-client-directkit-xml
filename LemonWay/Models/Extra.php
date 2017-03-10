<?php
namespace LemonWay\Models;

class Extra
{
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

    /**
     * NUM
     * @var string
     */
    public $NUM;

    /**
     * EXP
     * @var string
     */
    public $EXP;

    /**
     * TYPE
     * @var string
     */
    public $TYPE;


    function __construct($extraXml)
    {
        $this->AUTH = $extraXml->AUTH;
        $this->IS3DS = $extraXml->IS3DS;
        $this->CTRY = $extraXml->CTRY;
        $this->NUM = $extraXml->NUM;
        $this->EXP = $extraXml->EXP;
        $this->TYPE = $extraXml->TYPE;
    }
}
