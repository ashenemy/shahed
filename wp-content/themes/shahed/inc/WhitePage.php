<?php

namespace Shahed;

require_once __DIR__ . '/GeoLocation.php';

class WhitePage {
    private $_includedCountry = [];

    function __construct(){
        foreach (\Shahed\GeoLocation::currencies() as $currency) {
            $this->_includedCountry[] = $currency->countryCode;
        }
    }

    public static function IsWhitePage() {
        $_ = new WhitePage();

        return $_->showAlternativeHomePage();
    }

    public static function setupRedirects() {
        $_ = new WhitePage();
        $_->initRedirects();
    }

    public function showAlternativeHomePage() {
        return  $this->_onModerate() || !$this->_userInIncludedCountry();
    }

    public function initRedirects(){
        add_action('template_redirect', function () {
            if ($this->_isCanBeRedirect() && ( $this->_onModerate() || !$this->_userInIncludedCountry() ) ) {
                wp_redirect(home_url(), 302);
                exit;
            }
        });
    }

    private function _isCanBeRedirect() {
        return !is_front_page()  && !is_admin();
    }

    private function _onModerate(){
        return get_theme_mod('shahid_moderation_mode');
    }

    private function _userInIncludedCountry() {
        $geo = new \Shahed\GeoLocation();

        $userCountryCode = $geo->getUserCountryCode();

        return in_array($userCountryCode, $this->_includedCountry);
    }

}