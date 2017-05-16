<?php

namespace TMDroid\Apis;

use GuzzleHttp\Client;

abstract class QuoteGetter
{
    protected $SERVICE_NAME = "";
    protected $URL = "";
    protected $API_KEY = "";
    protected $guzzleClient = null;

    public function __construct()
    {
        $this->guzzleClient = new Client();
    }

    /**
     * @return //one quote from the selected service
     */
    public function getOneQuote()
    {
        $this->checkAPIKey();
    }

    /**
     * Checks if an API_KEY is set
     * @throws \ErrorException
     */
    private function checkAPIKey()
    {
        if (empty($this->API_KEY)) {
            throw new \ErrorException("You need to set the key before calling the API");
        }
    }

    /**
     * @param $number - number of quotes to return
     * @return //{$number} of quotes from the selected service
     */
    public function getMultipleQuotes($number)
    {
        $this->checkAPIKey();
    }

    /**
     * @param $key - API Key to set for the service
     */
    public function setAPIKey($key)
    {
        $this->API_KEY = $key;
    }
}