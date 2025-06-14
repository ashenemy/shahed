<?php

namespace Shahed;

class Currency {
    public $iso;
    public $countryCode;
    public $symbolNational;
    public $symbol;

    function __construct($iso, $countryCode, $symbols) {
        $this->iso = $iso;
        $this->countryCode = $countryCode;
        $this->symbolNational = $symbols[0];
        $this->symbol = $symbols[1];
    }

    public function toPrice($price, $format='western'){
        $price = $this->_toPriceFormat($price);

        if ($format === 'eastern') {
            $price = $this->_toEasternFormat($price);
        }

        return $this->_currency($price, $format === 'western' ?  $this->symbol : $this->symbolNational, $format === 'western' ? 'after' : 'after');
    }

    private function _toPriceFormat($price) {
        return number_format((float)$price, 2, '.', ',');
    }

    private function _toEasternFormat($price) {
        $western = ['0','1','2','3','4','5','6','7','8','9','.','\,',','];
        $eastern = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩','٫','٬','٬'];

        return str_replace($western, $eastern, $price);
    }

    private function _currency($price, $symbol, $position = 'before') {

        return $position === 'before' ? $symbol . $price : $price . ' ' . $symbol;

    }
}