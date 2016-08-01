<?php
namespace LemonWay\Examples;
use LemonWay\LemonWayAPI;
require_once 'ExamplesDatas.php';
class ExamplesBootstrap{


    /**
     * HOST Used to set some examples urls
     * @var string
     */
    const HOST             = 'http://lemon.loc';

    /**
     * DIRECTKIT_URL Used to set API DirectKit url
     * @var string
     */
    const DIRECTKIT_URL    = 'https://ws.lemonway.fr/mb/demo/dev/directkitxml/service.asmx';

    /**
     * WEBKIT_URL Used to set API WebKit url
     * @var string
     */
    const WEBKIT_URL       = 'https://m.lemonway.fr/mb/demo/dev/';

    /**
     * CSS_URL Used to set API CSS url for LemonWayAPI::printCardForm
     * @var string
     */
    const CSS_URL          = 'https://www.lemonway.fr/mercanet_lw.css';

    /**
     * LOGIN Used to set API user login
     * @var string
     */
    const LOGIN            = 'society';

    /**
     * PASS Used to set API user password
     * @var string
     */
    const PASS             = '123456';

    /**
     * LANG Used to set API language
     * @var string
     */
    const LANG             = 'fr';

    /**
     * DEBUG Used to switch API in debug mode
     * @var boolean
     */
    const DEBUG            = false;

    /**
     * api Lemon Way API
     * @var LemonWayAPI
     */
    public static $api;

    /**
     * Build the API if needed
     * @return LemonWayAPI
     */
    public static function getApiInstance(){
        if(self::$api == null){
            self::$api = new LemonWayAPI();

            self::$api->config->dkUrl = self::DIRECTKIT_URL;
            self::$api->config->wkUrl = self::WEBKIT_URL;
            self::$api->config->wlLogin = self::LOGIN;
            self::$api->config->wlPass = self::PASS;
            self::$api->config->lang = self::LANG;
            self::$api->config->isDebugEnabled = self::DEBUG;
        }
        return self::$api;
    }

}
