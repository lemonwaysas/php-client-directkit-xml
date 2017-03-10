<?php
namespace LemonWay\Models;

class Vcc
{
    /**
     * ID
     * @var string
     */
    public $ID;

    /**
     * NUM Virtual Credit Card Number
     * @var string
     */
    public $NUM;

    /**
     * EDATE Expiration Date
     * @var string
     */
    public $EDATE;

    /**
     * CVX Virtual Card Security Code
     * @var string
     */
    public $CVX;


    public function __construct($vcc)
    {
        $this->ID = $vcc->ID;
        $this->NUM = $vcc->NUM;
        $this->EDATE = $vcc->EDATE;
        $this->CVX = $vcc->CVX;
    }
}
