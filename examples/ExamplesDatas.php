<?php
namespace LemonWay\Examples;

class ExamplesDatas{

    /**
     * FILE_UPLOAD Dummy file to upload
     * @var string
     */
    const FILE_UPLOAD          = '../images/lemonway_logo.jpeg';

    /**
     * CARD_SUCCESS_WITHOUT_3D Card number for a valid test without 3D Secure
     * @var string
     */
    const CARD_SUCCESS_WITHOUT_3D = '5017670000006700';

    /**
     * CARD_SUCCESS_WITH_3D Card number for a valid test with 3D Secure
     * @var string
     */
    const CARD_SUCCESS_WITH_3D = '5017670000001800';

    /**
     * CARD_ERROR Card number for a failed test
     * @var string
     */
    const CARD_ERROR = '5017670000000851';

    /**
     * CARD_DATE Card expiration date
     * @var string
     */
    const CARD_DATE = '12/2017';

    /**
     * CARD_CRYPTO Card cryptogram
     * @var string
     */
    const CARD_CRYPTO = '123';

    /**
     * IBAN_HOLDER IBAN holder
     * @var string
     */
    const IBAN_HOLDER = 'My Name';

    /**
     * IBAN_NUMBER IBAN number
     * @var string
     */
    const IBAN_NUMBER = 'FR1420041010050500013M02606';

    /**
     * IBAN_BIC IBAN bic
     * @var string
     */
    const IBAN_BIC = 'ABCDEFGHIJK';

    /**
     * IBAN_AD1 IBAN address 1
     * @var string
     */
    const IBAN_AD1 = 'Center branch';

    /**
     * IBAN_AD2 IBAN address 2
     * @var string
     */
    const IBAN_AD2 = 'Paris';

    /**
     * Generates a random id
     * @return string
     */
    public static function getRandomId(){
        return str_replace('.', '', microtime(true).rand());
    }
}