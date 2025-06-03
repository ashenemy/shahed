<?php

namespace Shahed\ShortCodes;

class VideoShortCode {
    public function init() {
        add_shortcode('video', function ($atts) {
            $videoSrc = \Shahed\Assets::toWpAssetSrc('/videos/' . $atts['src']);

            return <<<HTML
                <video class="h-auto max-h-full w-auto max-w-full mix-blend-screen" width="100%" autoplay  loop  playsinline muted>
                    <source src="{$videoSrc}" type="video/mp4">
                </video>
            HTML;

        });
    }
}