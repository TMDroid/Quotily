<?php

namespace TMDroid\Apis\Extenders;

use TMDroid\Apis\QuoteGetter;
use TMDroid\Quote;

class ProgrammingQuotesAPI extends QuoteGetter
{

    public function __construct()
    {
        parent::__construct();

        $this->SERVICE_NAME = "Programming Quotes API";
        $this->URL = "http://quotes.stormconsultancy.co.uk/";
    }

    public function getOneQuote()
    {
        parent::getOneQuote();

        $response = $this->guzzleClient->request('GET', $this->URL . 'random.json', [
            'headers' => [
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

        $response = $this->guzzleClient->request('GET', $this->URL . 'quotes.json', [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $objects = \GuzzleHttp\json_decode($response->getBody());
            shuffle($objects);
//            $keys = array_keys($objects);

            $array = [];
            for ($i = 0; $i < $number ; $i++) {
                $object = array_pop($objects);

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
    private function getQuoteFromObject($object)
    {
        $quote = new Quote();
        $quote->setServiceName($this->SERVICE_NAME)
            ->setAuthor($object->author)
            ->setCategory('programming')
            ->setLength($object->id)
            ->setQuote($object->quote)
            ->setExtra($object->permalink);

        return $quote;
    }
}