<?php

namespace Shahed;

use DOMDocument;

class Assets {
    public static function script($handle, $src, $in_footer = true, $attrs = []) {
        if  (!Assets::isAbsoluteAsset($src)) {
            $src = get_template_directory_uri() . '/public' . $src;
        }
        wp_register_script($handle, $src, [], false, $in_footer);
        wp_enqueue_script($handle);

        add_filter('script_loader_tag', function ($tag, $h) use ($handle, $attrs) {
            if ($h !== $handle) return $tag;

            $dom = new DOMDocument();
            @$dom->loadHTML($tag, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $script = $dom->getElementsByTagName('script')->item(0);

            if (!$script) return $tag;

            foreach ($attrs as $key => $value) {
                if (is_int($key)) {
                    $script->setAttribute($value, $value);
                } else {
                    $script->setAttribute($key, $value);
                }
            }

            return $dom->saveHTML($script);
        }, 10, 2);
    }

    public static function style($handle, $src) {
        if  (!Assets::isAbsoluteAsset($src)) {
            $src = get_template_directory_uri() . '/public' . $src;
        }

        wp_register_style($handle, $src);
        wp_enqueue_style($handle);
    }


    public static function isAbsoluteAsset($src){
        return (str_starts_with($src, 'http://') || str_starts_with($src, 'https://') || str_starts_with($src, '//')) && !str_contains($src, home_url());
    }
}