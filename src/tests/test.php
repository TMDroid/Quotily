<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use TMDroid\Quotily;

$apikey = "<YOUR_API_KEY_HERE>";

$quotily = new Quotily(Quotily::$API_BEST_QUOTES, $apikey);
var_dump($quotily->getOneQuote());