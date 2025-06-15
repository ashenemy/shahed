<?php

namespace Shahed;

require_once __DIR__ . '/Currency.php';


class GeoLocation {
    const DEFAULT_COUNTRY_CODE = 'US';
    const DEFAULT_CURRENCY_CODE = 'SAR';

    private static $_ipData;

    public static function CURRENCY(){
        $geo = new GeoLocation();

        return $geo->getCurrency();
    }

    public static function currencies() {
        return [
                new \Shahed\Currency('SAR', 'SA', ['ر.س', 'SR']),
                new \Shahed\Currency('QAR', 'QA', ['ر.ق', 'QR']),
                new \Shahed\Currency('KWD',  'KW', ['د.ك', 'KD']),
                new \Shahed\Currency('AED', 'AE', ['د.إ', 'AED']),
                new \Shahed\Currency('BHD', 'BH', ['د.ب', 'BD']),
                new \Shahed\Currency('OMR', 'OM', ['ر.ع', 'RO'])
        ];
    }

    private function _getCountry($ip) {
        if(empty(GeoLocation::$_ipData)){
            $response = file_get_contents("http://ip-api.com/json/$ip?fields=countryCode,currency");
            $data = json_decode($response, true);
            if ($data && $data['countryCode']) {
                GeoLocation::$_ipData = $data;
            }
        }

        return GeoLocation::$_ipData;
    }

    public function getCurrency() {
        if (!empty($_GET['countryCode'])) {
            return $this->_getCurrencyByCountryCode($_GET['countryCode']);
        } else {
            $ip = $this->_getUserIp();
            if (!empty($ip)) {
                $countryData = $this->_getCountry($ip);
                if (!empty($countryData)) {
                    return $this->_getCurrencyByCurrencyCode($countryData['currency']);
                }
            }
        }

        return GeoLocation::currencies()[0];
    }

    public function getUserCountryCode() {
        if (!empty($_GET['countryCode'])) {
            return $_GET['countryCode'];
        } else {
            $ip = $this->_getUserIp();
            if (!empty($ip)) {
                $countryData = $this->_getCountry($ip);
                if (!empty($countryData)) {
                    return $countryData['countryCode'];
                }
            }
        }

        return GeoLocation::DEFAULT_COUNTRY_CODE;
    }

    private function _getUserIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    private function _getCurrencyByCountryCode($countryCode){

        foreach (GeoLocation::currencies() as $currency) {
            if ($currency->countryCode === $countryCode) {
                return $currency;
            }
        }

        return $this->_getCurrencyByCurrencyCode(GeoLocation::DEFAULT_CURRENCY_CODE);
    }
    private function _getCurrencyByCurrencyCode($currencyCode){
        foreach (GeoLocation::currencies() as $currency) {
            if ($currency->iso === $currencyCode) {
                return $currency;
            }
        }

        return GeoLocation::currencies()[0];
    }
}