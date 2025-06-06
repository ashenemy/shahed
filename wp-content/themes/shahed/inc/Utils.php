<?php


function WpAsset($src) {
    echo \Shahed\Assets::toWpAssetSrc($src);
}

function _e_($code) {
    echo $code;
}

function getProduct($productId){
    $post = get_post($productId);

    return [
            'id'           => $post->ID,
            'title'        => get_the_title($post),
            'price'        => get_post_meta($post->ID, 'price', true),
            'description'  => $post->post_content,
            'isBestseller' => (bool) get_post_meta($post->ID, 'isBestseller', true),
    ];
}