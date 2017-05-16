<?php

namespace TMDroid;

use TMDroid\Apis\BestQuotes;
use TMDroid\Apis\RandomFamousQuotes;

class Quotily
{
    public static $API_BEST_QUOTES = 1;
    public static $API_RANDOM_FAMOUS_QUOTES = 2;
//    public static $API_BEST_QUOTES = 1;

    private $api;

    /**
     * Quotily constructor.
     * @param $api_id - One of the static fields above
     * @param string $apikey - optional api key, you can set it later with @setApiKey
     */
    function __construct($api_id = 1, $apikey = '')
    {
        switch ($api_id) {
            case self::$API_BEST_QUOTES:
                $this->api = new BestQuotes($apikey);
                break;
            case self::$API_RANDOM_FAMOUS_QUOTES:
                $this->api = new RandomFamousQuotes($apikey);
                break;

            default:
                throw new \InvalidArgumentException("Provided api_id is invalid");
                break;
        }
    }

    public function getOneQuote()
    {
        return $this->api->getOneQuote();
    }

    public function getMultipleQuotes($number)
    {
        return $this->api->getMultipleQuotes($number);
    }
}