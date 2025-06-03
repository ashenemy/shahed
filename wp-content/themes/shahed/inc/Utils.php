<?php


function WpAsset($src) {
    echo \Shahed\Assets::toWpAssetSrc($src);
}

function _e_($code) {
    echo $code;
}