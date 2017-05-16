<?php

namespace TMDroid;

use TMDroid\Apis\BestQuotes;
use TMDroid\Apis\RandomFamousQuotes;
use TMDroid\Apis\Supported;

class Quotily {

    private $api;

    /**
     * Quotily constructor.
     * @param $api_id - One of the static fields above
     * @param string $apikey - optional api key, you can set it later with @setApiKey
     */
    function __construct($api_id = 1, $apikey = '') {
        switch ($api_id) {
            case Supported::$BEST_QUOTES:
                $this->api = new BestQuotes($apikey);
                break;
            case Supported::$RANDOM_FAMOUS_QUOTES:
                $this->api = new RandomFamousQuotes($apikey);
                break;

            default:
                throw new \InvalidArgumentException("Provided api_id is invalid");
                break;
        }
    }

    public function getOneQuote() {
        return $this->api->getOneQuote();
    }

    public function getMultipleQuotes($number) {
        return $this->api->getMultipleQuotes($number);
    }
}