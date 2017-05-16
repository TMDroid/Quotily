Quotily
===

Quotily is a PHP package that helps you get famous quotes from various quote-serving APIs

APIs Supported: 
---

* Random Famous Quotes - [click](https://market.mashape.com/andruxnet/random-famous-quotes)
* Bestquotes - [click](https://market.mashape.com/qvoca/bestquotes)
* * *
Usage
---

```php
<?php
use TMDroid\Quotily;  

$apikey = "<YOUR_API_KEY_HERE>";

$quotily = new Quotily(Quotily::$API_RANDOM_FAMOUS_QUOTES, $apikey);
$quote = $quotily->getOneQuote();

var_dump($quote);
?>
```

Sample output from `var_dump` 
```
class TMDroid\Quote#31 (5) {
  private $serviceName =>
  string(30) "Random Famous Quotes - Mashape"
  private $quote =>
  string(111) "Good people do not need laws to tell them to act responsibly, while bad people will find a way around the laws."
  private $author =>
  string(5) "Plato"
  private $length =>
  int(111)
  private $genre =>
  string(6) "Famous"
}

```
```
class TMDroid\Quote#31 (5) {
  private $serviceName =>
  string(20) "Bestquotes - Mashape"
  private $quote =>
  string(104) "But if you don't watch me, I will try and sneak in some humor. I see humor everywhere in life around me."
  private $author =>
  string(11) "Marion Ross"
  private $length =>
  int(104)
  private $genre =>
  string(5) "humor"
}

```

Support
---

If you want to have any other APIs listed in here too leave me a reply or, why not, submit a pull-request.

Thanks! :)