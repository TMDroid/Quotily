<?php

namespace TMDroid\Apis\Extenders;

use TMDroid\Apis\QuoteGetter;
use TMDroid\Quote;

class RandomFamousQuotes extends QuoteGetter
{

    public function __construct($key = '')
    {
        parent::__construct();

        $this->SERVICE_NAME = "Random Famous Quotes - Mashape";
        $this->URL = "https://andruxnet-random-famous-quotes.p.mashape.com/";
        $this->API_KEY = $key;
        $this->needsApiKey = true;
    }

    public function getOneQuote()
    {
        parent::getOneQuote();

        $response = $this->guzzleClient->request('POST', $this->URL, [
            'headers' => [
                'X-Mashape-Key' => $this->API_KEY,
                'Accept' => 'application/json'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $object = \GuzzleHttp\json_decode($response->getBody());

            $quote = $this->getQuoteFromObject($object);

            return $quote;

        } else {
            throw new \HttpException("Bad request code received from server: " . $response->getStatusCode());
        }
    }

    public function getMultipleQuotes($number)
    {
        parent::getMultipleQuotes($number);

        $response = $this->guzzleClient->request('POST', $this->URL . "?count=$number", [
            'headers' => [
                'X-Mashape-Key' => $this->API_KEY,
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $objects = \GuzzleHttp\json_decode($response->getBody());
            $array = [];

            foreach ($objects as $object) {
                $quote = $this->getQuoteFromObject($object);

                array_push($array, $quote);
            }

            return $array;

        } else {
            throw new \HttpException("Bad request code received from server: " . $response->getStatusCode());
        }
    }

    /**
     * @param $object - raw json object
     * @return Quote
     */
    private function getQuoteFromObject($object) {
        $quote = new Quote();
        $quote->setServiceName($this->SERVICE_NAME)
            ->setAuthor($object->author)
            ->setCategory($object->category)
            ->setLength(strlen($object->quote))
            ->setQuote($object->quote);

        return $quote;
    }

}