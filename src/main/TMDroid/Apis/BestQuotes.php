<?php

namespace TMDroid\Apis;

use TMDroid\Quote;

class BestQuotes extends QuoteGetter
{

    public function __construct($key = '')
    {
        parent::__construct();

        $this->SERVICE_NAME = "Bestquotes - Mashape";
        $this->URL = "https://qvoca-bestquotes-v1.p.mashape.com/quote";
        $this->API_KEY = $key;
        $this->needsApiKey = true;
    }

    public function getOneQuote()
    {
        parent::getOneQuote();

        $response = $this->guzzleClient->request('GET', $this->URL, [
            'headers' => [
                'X-Mashape-Key' => $this->API_KEY,
                'Accept' => 'application/json'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $object = \GuzzleHttp\json_decode($response->getBody());

            $quote = new Quote();
            $quote->setServiceName($this->SERVICE_NAME)
                ->setAuthor($object->author)
                ->setCategory($object->genre)
                ->setLength($object->message_len)
                ->setQuote($object->message);

            return $quote;

        } else {
            throw new \HttpException("Bad request code received from server: " . $response->getStatusCode());
        }
    }

    public function getMultipleQuotes($number)
    {
        parent::getMultipleQuotes($number);

        $array = [];
        for ($i = 0; $i < $number; $i++) {
            array_push($array, $this->getOneQuote());
        }

        return $array;
    }



}