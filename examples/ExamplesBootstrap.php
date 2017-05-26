<?php
namespace LemonWay\Examples;

use LemonWay\LemonWayAPI;

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'ExamplesDatas.php';
class ExamplesBootstrap
{


    /**
     * HOST Used to set some examples urls
     * @var string
     */
    const HOST  = 'http://localhost/php-client-directkit-xml';

    /**
     * DIRECTKIT_URL Used to set API DirectKit url
     * @var string
     */
    const DIRECTKIT_URL = 'https://sandbox-api.lemonway.fr/mb/demo/dev/directkitxml/Service.asmx';

    /**
     * WEBKIT_URL Used to set API WebKit url
     * @var string
     */
    const WEBKIT_URL = 'https://sandbox-webkit.lemonway.fr/demo/dev/';

    /**
     * SSLVERIFICATION Used to tell whether it needs to verifiy SSL
     * Only activate it if your PHP server know how to verify the certifcates.
     * (You will have to configure the  the CURLOPT_CAINFO option or the CURLOPT_CAPATH option)
     * https://curl.haxx.se/libcurl/c/CURLOPT_SSL_VERIFYPEER.html
     * https://stackoverflow.com/a/18972719/347051
     * @var string
     */
    const SSLVERIFICATION = false;

    /**
     * CSS_URL Used to set API CSS url for LemonWayAPI::printCardForm
     * @var string
     */
    const CSS_URL = 'https://www.lemonway.fr/mercanet_lw.css';

    /**
     * LOGIN Used to set API user login
     * @var string
     */
    const LOGIN = 'society';

    /**
     * PASS Used to set API user password
     * @var string
     */
    const PASS = '123456';

    /**
     * LANG Used to set API language
     * @var string
     */
    const LANG = 'en';

    /**
     * DEBUG Used to switch API in debug mode
     * @var boolean
     */
    const DEBUG = false;

    /**
     * api Lemon Way API
     * @var LemonWayAPI
     */
    public static $api;

    /**
     * Build the API if needed
     * @return LemonWayAPI
     */
    public static function getApiInstance()
    {
        if (self::$api == null) {
            self::$api = new LemonWayAPI();

            self::$api->config->dkUrl = self::DIRECTKIT_URL;
            self::$api->config->wkUrl = self::WEBKIT_URL;
            self::$api->config->sslVerification = self::SSLVERIFICATION;
            self::$api->config->wlLogin = self::LOGIN;
            self::$api->config->wlPass = self::PASS;
            self::$api->config->lang = self::LANG;
            self::$api->config->isDebugEnabled = self::DEBUG;
        }
        return self::$api;
    }
}
