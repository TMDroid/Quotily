<?php

namespace TMDroid\Apis;

use TMDroid\Quote;

class QuotesOnDesign extends QuoteGetter {
    public function __construct($key = '')
    {
        parent::__construct();

        $this->SERVICE_NAME = "Quotes on Design";
        $this->URL = "http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=";
        $this->API_KEY = $key;
    }

    public function getOneQuote()
    {
        parent::getOneQuote();

        $response = $this->guzzleClient->request('GET', $this->URL . '1', [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $object = \GuzzleHttp\json_decode($response->getBody())[0];

            $quote = $this->getQuoteFromObject($object);

            return $quote;

        } else {
            throw new \HttpException("Bad request code received from server: " . $response->getStatusCode());
        }
    }

    public function getMultipleQuotes($number)
    {
        parent::getMultipleQuotes($number);

        $response = $this->guzzleClient->request('GET', $this->URL . $number, [
            'headers' => [
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
        $object->content = str_replace('<p>', '', $object->content);
        $object->content = trim(str_replace('</p>', '', $object->content));
        $object->content = str_replace('&#8217;', '', $object->content);
        $object->content = str_replace('&#8211;', '', $object->content);

        $quote = new Quote();
        $quote->setServiceName($this->SERVICE_NAME)
            ->setAuthor($object->title)
            ->setCategory('')
            ->setLength(strlen($object->content))
            ->setQuote($object->content)
            ->setExtra($object->link);

        return $quote;
    }
}