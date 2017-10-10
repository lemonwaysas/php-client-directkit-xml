<?php
namespace LemonWay\Models;

class LwError
{

    /**
     * CODE number
     * @var string
     */
    public $CODE;

    /**
     * MSG error message
     * @var string
     */
    public $MSG;

    public function __construct($code, $msg)
    {
        $this->CODE = $code;
        $this->MSG = $msg;
    }
}
