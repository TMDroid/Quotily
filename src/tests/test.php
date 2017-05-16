<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use TMDroid\Apis\Supported;
use TMDroid\Quotily;

$apikey = "<YOUR_API_KEY_HERE>";

$quotily = new Quotily(Supported::$API_QUOTES_ON_DESIGN, $apikey);
$quote = $quotily->getOneQuote();

var_dump($quote);

$quote = $quotily->getMultipleQuotes(10);

var_dump($quote);