<?php
namespace Shahed;

require_once __DIR__ . '/Assets.php';
require_once __DIR__ . '/ShortCodes.php';
require_once __DIR__ . '/CustomPostTypes.php';
require_once __DIR__ . '/WhitePage.php';

class Kernel {

    public static function init(){
        $kernel = new Kernel();

        $kernel->_startUp();

        $kernel->_setupAssets();
    }

    private function _startUp(){
        $this->_cleanAdmin();
        $this->_clearTheme();
        $this->_setupThemeSupport();
        $this->_wpRoleClean();
        $this->_setupShortCodes();
        $this->_setupCustomPostTypes();
        $this->_addSettings();
        $this->_setupWhitePageRedirect();
    }

    private function _setupWhitePageRedirect() {
        \Shahed\WhitePage::setupRedirects();
    }

    private function _setupCustomPostTypes() {
        \Shahed\CustomPostTypes::init();
    }

    private function _setupShortCodes() {
        \Shahed\ShortCodes::init();
    }

    private function _cleanAdmin() {
        add_action('admin_init', function () {
            remove_menu_page('edit.php');
            remove_menu_page('edit-comments.php');
            remove_menu_page('edit.php?post_type=participant');
            remove_menu_page('edit.php?post_type=questions');
            remove_menu_page('edit.php?post_type=supporter');
            remove_menu_page('tools.php');

            remove_submenu_page('options-general.php', 'options-writing.php');
            remove_submenu_page('options-general.php', 'options-reading.php');
            remove_submenu_page('options-general.php', 'options-discussion.php');
            remove_submenu_page('options-general.php', 'options-privacy.php');

            remove_action('welcome_panel', 'wp_welcome_panel');
        });

        add_action('admin_menu', function () {
            remove_meta_box('dashboard_right_now', 'dashboard', 'core');
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
            remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
            remove_meta_box('dashboard_plugins', 'dashboard', 'core');
            remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
            remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
            remove_meta_box('dashboard_primary', 'dashboard', 'core');
            remove_meta_box('dashboard_secondary', 'dashboard', 'core');
            remove_meta_box('yoast_db_widget', 'dashboard', 'normal');
            remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
            remove_meta_box('dashboard_activity', 'dashboard', 'normal');
            remove_meta_box('welcome_panel', 'dashboard', 'normal');
        });

    }

    private function _clearTheme() {
        if (!is_admin()) {
            add_filter('show_admin_bar', '__return_false');
        }

        add_filter('post_class', function (array $classes) {
            if (in_array('sticky', $classes)) {
                $classes = array_diff($classes, array("sticky"));
                $classes[] = 'wp-sticky';
            }

            return $classes;
        });

        add_action('after_setup_theme', function () {
            add_action('init', function () {
                remove_action('wp_head', 'rsd_link');
                remove_action('wp_head', 'wlwmanifest_link');
                remove_action('wp_head', 'index_rel_link');
                remove_action('wp_head', 'parent_post_rel_link', 10, 0);
                remove_action('wp_head', 'start_post_rel_link', 10, 0);
                remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
                remove_action('wp_head', 'wp_generator');
            });

            add_filter('wp_head', function () {
                if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {
                    remove_filter('wp_head', 'wp_widget_recent_comments_style');
                }
            }, 1);

            add_action('wp_head', function () {
                global $wp_widget_factory;
                if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
                    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
                }
            }, 1);

        });

        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('emoji_svg_url', '__return_false');

        remove_action('wp_head', 'rel_canonical');

        remove_action('wp_head', 'wp_shortlink_wp_head', 10);
        remove_action('template_redirect', 'wp_shortlink_header', 11);

        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);

        remove_action('wp_head', 'rsd_link');

        remove_action('wp_head', 'wlwmanifest_link');

        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('template_redirect', 'rest_output_link_header', 11);

        remove_action('wp_head', 'wp_oembed_add_discovery_links');

        remove_action('wp_head', 'wp_generator');
        add_filter('emoji_svg_url', '__return_empty_string');

        add_action('init', function () {
            remove_filter('wp_robots', 'wp_robots_max_image_preview_large');
        });


        add_action('wp_enqueue_scripts', function () {
            // Только если НЕ админка и НЕ редактор блоков
            if (is_admin() || is_embed() || is_customize_preview()) {
                return;
            }
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('classic-theme-styles');
            wp_dequeue_style('global-styles');
            remove_action('wp_head', 'wp_enqueue_global_styles', 1);

        }, 20);
    }

    private function _setupAssets() {

        if (\Shahed\WhitePage::IsWhitePage()) {
            Assets::style('main-styles', '/cinema/styles.css');
            Assets::script('main-script', '/cinema/scripts.js');
        } else {
            Assets::style('main-styles', '/styles.css');

            Assets::script('cookie-script', '//cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js');
            Assets::script('main-script', '/scripts.js');
        }


    }

    private function _setupThemeSupport() {
        add_action('after_setup_theme', function () {
            add_theme_support('post-thumbnails');
            add_theme_support('appearance-tools');
            add_theme_support('block-templates');
            add_theme_support('custom-logo');
            add_theme_support('dark-editor-style');
            add_theme_support( 'disable-layout-styles' );
            add_theme_support( 'disable-buttons-styles' );
            add_theme_support('menus');
            add_theme_support('featured-content');
            add_theme_support( 'editor-style' );
            add_theme_support('title-tag');
            add_theme_support('html5',
                    array(
                            'comment-list',
                            'comment-form',
                            'search-form',
                    )
            );


            add_theme_support('post-thumbnails');

            remove_theme_support( 'core-block-patterns' );
        }, 1);
    }

    private function _wpRoleClean() {
        add_action( 'init', function (){
            $rolesForDelete = ['translator', 'contributor', 'author', 'editor',  'subscriber'];

            foreach($rolesForDelete as $roleName) {
                if (!empty(get_role($roleName))) {
                    remove_role($roleName);
                }
            }

            if (empty(get_role('content_manager'))) {
                add_role('content_manager', __('Content manager', 'aj'), array());
            }
        });
    }

    private function _addSettings() {
        add_action('customize_register', function ($wp_customize){
            $wp_customize->add_section('shahid_settings_section', [
                    'title' => 'Theme Settings',
                    'priority' => 30,
            ]);

            $wp_customize->add_setting('shahid_moderation_mode', [
                    'default' => false,
                    'sanitize_callback' => function ($checked) {
                        return ($checked === true || $checked === '1') ? true : false;
                    },
            ]);

            $wp_customize->add_control('shahid_moderation_mode', [
                    'label' => 'Moderation mode',
                    'section' => 'shahid_settings_section',
                    'type' => 'checkbox',
            ]);

            // 2. Дубликат настройки главной страницы
            $wp_customize->add_setting('shahid_front_page_duplicate', [
                    'default' => get_option('page_on_front'),
                    'sanitize_callback' => 'absint',
            ]);

            $wp_customize->add_control('shahid_front_page_duplicate', [
                    'label' => 'Front page',
                    'section' => 'shahid_settings_section',
                    'type' => 'dropdown-pages',
            ]);

            $wp_customize->add_setting('shahid_alternative_front_page', [
                    'default' => '',
                    'sanitize_callback' => 'absint',
            ]);

            $wp_customize->add_control('shahid_alternative_front_page', [
                    'label' => 'Alternative front page',
                    'section' => 'shahid_settings_section',
                    'type' => 'dropdown-pages',
            ]);
        });

    }

}