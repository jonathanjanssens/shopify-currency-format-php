# Shopify Currency Format PHP

[![Build Status](https://travis-ci.org/jonathanjanssens/shopify-currency-format-php.svg?branch=master)](https://travis-ci.org/jonathanjanssens/shopify-currency-format-php)

This is a small helper utility for formatting currencies provided by the Shopify API. All the formats covered in the [documentation on Shopify currency formats](https://help.shopify.com/en/manual/payments/currency-formatting) are supported

## Installation

Install with composer.

```composer require jtn/shopify-currency-format```

## Usage

Simply create a new instance of the class and supply the format you want to use and pass an integer in cents to the `format` method.

If you pass a string the library will expect this came from the Shopify API so will be in dollars and cents so it will be divided by 100.

You can change the format by calling `setFormat`.

```<?php
use Jtn\ShopifyMoneyFormat\ShopifyMoneyFormat;

$formatter = new ShopifyMoneyFormat('{{ amount_no_decimals }}');
echo $formatter->format(3.65); // 4

$formatter->setFormat('{{ amount_no_decimals }}');
echo $formatter->format(300); // 3.00

$formatter->setFormat('<span class=money>£{{ amount }} GBP</span>');
echo $formatter->format('5.99'); // <span class=money>£5.99 GBP</span>

```

If you specifiy an unsupported format an exception will be thrown.

```<?php
use Jtn\ShopifyMoneyFormat\ShopifyMoneyFormat;
use Jtn\ShopifyMoneyFormat\UnsupportedFormatException;

$formatter = new ShopifyMoneyFormat('{{ some_unsupported_format }}');

try {
	echo $formatter->format(1.00);
} catch(UnsupportedFormatException $e) {
	echo 'That format is not supported :(';
}

// That format is not supported :(
```

