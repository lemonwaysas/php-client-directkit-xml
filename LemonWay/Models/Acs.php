<?php
namespace LemonWay\Models;

class Acs
{
    /**
     * actionUrl Redirect URL for the CLIENT on the 3D Secure web site
     * @var string
     */
    public $actionUrl;

    /**
     * actionMethod HTTP Method
     * @var string
     */
    public $actionMethod;

    /**
     * pareqFieldName Name of the field to use to transmit "pareq" data
     * @var string
     */
    public $pareqFieldName;

    /**
     * pareqFieldValue Pareq data to send
     * @var string
     */
    public $pareqFieldValue;

    /**
     * termurlFieldName Field name to use to transmit your return URL
     * @var string
     */
    public $termurlFieldName;

    /**
     * mdFieldName Name of the field to transmit the "md" variable
     * @var string
     */
    public $mdFieldName;

    /**
     * mdFieldValue "md" variable to transmit
     * @var string
     */
    public $mdFieldValue;


    public function __construct($acs)
    {
        $this->actionMethod = $acs->actionMethod;
        $this->actionUrl = $acs->actionUrl;
        $this->mdFieldName = $acs->mdFieldName;
        $this->mdFieldValue = $acs->mdFieldValue;
        $this->pareqFieldName = $acs->pareqFieldName;
        $this->pareqFieldValue = $acs->pareqFieldValue;
        $this->termurlFieldName = $acs->termurlFieldName;
    }
}
