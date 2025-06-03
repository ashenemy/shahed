<?php

namespace Shahed;

use Shahed\ShortCodes\VideoShortCode;

require_once __DIR__ . "/shortcodes/VideoShortCode.php";

class ShortCodes {
    public static function init() {
        $shortcode = new ShortCodes();

        $shortcode->_initVideoShortCodes();
    }

    private function _initVideoShortCodes() {
        (new \Shahed\ShortCodes\VideoShortCode())->init();
    }
}