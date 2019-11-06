<?php

namespace Jtn\ShopifyCurrencyFormat\Tests;

use PHPUnit\Framework\TestCase;
use Jtn\ShopifyCurrencyFormat\ShopifyCurrencyFormat;
use Jtn\ShopifyCurrencyFormat\UnsupportedFormatException;

class ShopifyCurrencyFormatTest extends TestCase
{

    protected $amount = "1134.65";

    public function test_amount_format()
    {
        $formatter = new ShopifyCurrencyFormat('{{ amount }}');
        $this->assertEquals($formatter->format($this->amount), '1,134.65');
    }

    public function test_amount_format_no_whitespace()
    {
        $formatter = new ShopifyCurrencyFormat('{{amount}}');
        $this->assertEquals($formatter->format($this->amount), '1,134.65');
    }

    public function test_amount_format_with_symbol()
    {
        $formatter = new ShopifyCurrencyFormat('£{{amount}}');
        $this->assertEquals($formatter->format($this->amount), '£1,134.65');
    }

    public function test_amount_format_with_span()
    {
        $formatter = new ShopifyCurrencyFormat('<span class=money>{{amount}}</span>');
        $this->assertEquals($formatter->format($this->amount), '<span class=money>1,134.65</span>');

        $formatter = new ShopifyCurrencyFormat('<span class=money>{{ amount }}</span>');
        $this->assertEquals($formatter->format($this->amount), '<span class=money>1,134.65</span>');
    }

    public function test_amount_no_decimals()
    {
        $formatter = new ShopifyCurrencyFormat('{{ amount_no_decimals }}');
        $this->assertEquals($formatter->format($this->amount), '1,135');
    }

    public function test_amount_with_comma_separator()
    {
        $formatter = new ShopifyCurrencyFormat('{{ amount_with_comma_separator }}');
        $this->assertEquals($formatter->format($this->amount), '1.134,65');
    }

    public function test_amount_no_decimals_with_comma_separator()
    {
        $formatter = new ShopifyCurrencyFormat('{{ amount_no_decimals_with_comma_separator }}');
        $this->assertEquals($formatter->format($this->amount), '1.135');
    }

    public function test_amount_with_apostrophe_separator()
    {
        $formatter = new ShopifyCurrencyFormat('{{ amount_with_apostrophe_separator }}');
        $this->assertEquals($formatter->format($this->amount), "1'134.65");
    }

    public function test_unsupported_format_exception_thrown()
    {
        $this->expectException(UnsupportedFormatException::class);

        $formatter = new ShopifyCurrencyFormat('{{ unsupported_format }}');
        $formatter->format($this->amount);
    }

}
