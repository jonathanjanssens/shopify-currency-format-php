<?php

namespace Jtn\ShopifyMoneyFormat;

class ShopifyMoneyFormat
{

    protected $format;
    protected $formatTemplate;
    protected $rawFormat;

    public function __construct(string $format)
    {
        $this->setFormat($format);
    }

    public function setFormat(string $format)
    {
        $this->format = $format;

        $re = '/\{\{\s*(\w+)\s*\}\}/';
        preg_match($re, $format, $matches);

        $this->formatTemplate = $matches[0];
        $this->rawFormat = $matches[1];
    }

    public function format($cents) : string
    {
        if(is_string($cents)) {
            $cents = (int) str_replace('.', '', $cents);
        }

        switch($this->rawFormat) {
            case 'amount':
                $value = $this->formatWithDelimiters($cents, 2);
                break;
            case 'amount_no_decimals':
                $value = $this->formatWithDelimiters($cents, 0);
                break;
            case 'amount_with_comma_separator':
                $value = $this->formatWithDelimiters($cents, 2, '.', ',');
                break;
            case 'amount_no_decimals_with_comma_separator':
                $value = $this->formatWithDelimiters($cents, 0, '.', ',');
                break;
            case 'amount_with_apostrophe_separator':
                $value = $this->formatWithDelimiters($cents, 2, "'", '.');
                break;
            default:
                throw new UnsupportedFormatException($this->rawFormat . ' is not a supported currency format');
        }

        return str_replace($this->formatTemplate, $value, $this->format);
    }

    protected function formatWithDelimiters($cents, $precision = 2, $thousands = ',', $decimal = '.') : string
    {
        return number_format($cents / 100, $precision, $decimal, $thousands);
    }

}
