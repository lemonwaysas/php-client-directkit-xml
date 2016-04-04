<?php
namespace LemonWay\Lib;


class LwException extends \Exception
{
    const UNKNOWN_ERROR = 0;
    const BAD_REQUEST = 400;
    const BAD_IP = 403;
    const NOT_FOUND = 404;
    const INTERNAL_ERROR = 500;

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}