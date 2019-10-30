# Fio API PHP implemention [![Build Status](https://travis-ci.org/ardani/fio-payment-wrapper.svg?branch=master)](https://travis-ci.org/ardani/fio-payment-wrapper) [![Build Status Windows](https://ci.appveyor.com/api/projects/status/github/ardani/fio-payment-wrapper?branch=master&svg=true)](https://ci.appveyor.com/project/ardani/fio-payment-wrapper/branch/master)

[![Latest Stable Version](https://poser.pugx.org/ardani/fio-payment-wrapper/version.png)](https://packagist.org/packages/ardani/fio-payment-wrapper) [![Total Downloads](https://poser.pugx.org/ardani/fio-payment-wrapper/downloads.png)](https://packagist.org/packages/ardani/fio-payment-wrapper) [![License](https://poser.pugx.org/mhujer/fio-payment-wrapper/license.svg)](https://packagist.org/packages/ardani/fio-payment-wrapper) [![Coverage Status](https://coveralls.io/repos/ardani/fio-payment-wrapper/badge.svg?branch=master)](https://coveralls.io/r/ardani/fio-payment-wrapper?branch=master)

Fio bank REST API implementation in PHP. It allows you to download and iterate through account balance changes.

Usage
----
1. Install the latest version with `composer require ardani/fio-payment-wrapper`
2. Create a *token* in the ebanking (Nastavení / API)
3. Use it according to the example bellow and check the docblocks

### Downloading 
```php
<?php
require_once 'vendor/autoload.php';

$downloader = new FioApi\Downloader('TOKEN@todo');
$transactionList = $downloader->downloadSince(new \DateTimeImmutable('-1 week'));

foreach ($transactionList->getTransactions() as $transaction) {
    var_dump($transaction); //object with getters
}

```

### Uploading

#### Domestic payment (in Czechia)
```php
<?php
require_once 'vendor/autoload.php';

$token = get_your_fio_token();
$uploader = new FioApi\Uploader($token);
// currency, iban, bic is not needed
$account = new FioApi\Account('XXXXXXXXXX', 'ZZZZ', NULL, NULL, NULL);
$tx = Transaction::create((object) [
    'accountNumber' => 'YYYYYYYYYY',
    'bankCode' => 'WWWW',
    'date' => new \DateTime('2016-07-20'),
    'amount' => 6.66,
    'currency' => 'CZK',
    'userMessage' => 'money wasting',
    'comment' => 'fioapi.test'
]);

$builder = new FioApi\DomesticPaymentBuilder();
$request = $builder->build($account, [$tx]);
$response = $uploader->sendRequest($request);

echo $response->getStatus();
```

Requirements
------------
Fio API PHP works with PHP 7.1 or higher.

Submitting bugs and feature requests
------------------------------------
Bugs and feature request are tracked on [GitHub](https://github.com/ardani/fio-payment-wrapper/issues)