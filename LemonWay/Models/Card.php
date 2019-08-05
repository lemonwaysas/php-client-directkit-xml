<?php
namespace LemonWay\Models;

class Card
{
    const TYPE_CB = '0';
    const TYPE_VISA = '1';
    const TYPE_MASTERCARD = '2';
    /**
     * ID as defined by Lemon Way
     * @var string
     */
    public $ID;
    /**
     * EXTRA
     * @var Extra
     */
    public $EXTRA;

    public function __construct($node)
    {
        $this->ID = $node->ID;
        if (isset($node->EXTRA)) {
            $this->EXTRA = new Extra($node->EXTRA);
        }
    }
}
