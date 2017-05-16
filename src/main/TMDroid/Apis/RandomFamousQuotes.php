<?php

namespace TMDroid\Apis;

use TMDroid\Quote;

class RandomFamousQuotes extends QuoteGetter
{

    public function __construct($key = '')
    {
        parent::__construct();

        $this->SERVICE_NAME = "Random Famous Quotes - Mashape";
        $this->URL = "https://andruxnet-random-famous-quotes.p.mashape.com/";
        $this->API_KEY = $key;
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

            $quote = new Quote();
            $quote->setServiceName($this->SERVICE_NAME)
                ->setAuthor($object->author)
                ->setGenre($object->category)
                ->setLength(strlen($object->quote))
                ->setQuote($object->quote);

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
            $object = \GuzzleHttp\json_decode($response->getBody());

            $quote = new Quote();
            $quote->setAuthor($object->author)
                ->setGenre($object->genre)
                ->setLength($object->message_len)
                ->setQuote($object->message);

            return $quote;

        } else {
            throw new \HttpException("Bad request code received from server: " . $response->getStatusCode());
        }
    }

}