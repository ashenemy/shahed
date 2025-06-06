<?php

namespace Shahed;

use Shahed\ShortCodes\VideoShortCode;

require_once __DIR__ . "/shortcodes/VideoShortCode.php";
require_once __DIR__ . "/shortcodes/PaymentFormShortCode.php";

class ShortCodes {
    public static function init() {
        $shortcode = new ShortCodes();

        $shortcode->_initVideoShortCodes();
        $shortcode->_initPaymentFormShortCodes();
    }

    private function _initVideoShortCodes() {
        (new \Shahed\ShortCodes\VideoShortCode())->init();
    }

    private function _initPaymentFormShortCodes() {
        (new \Shahed\ShortCodes\PaymentFormShortCode())->init();
    }
}