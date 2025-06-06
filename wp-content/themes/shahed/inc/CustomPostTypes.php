<?php

namespace Shahed;

class CustomPostTypes {

    public static function init() {
        $cp = new CustomPostTypes();

        $cp->_registerCredentialsPostType();
        $cp->_registerProductsPostType();
    }

    private function _registerCredentialsPostType(){
        add_action('init', function () {
            register_post_type('credentials', [
                    'label' => 'Credentials',
                    'public' => false,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'supports' => ['title'],
                    'capability_type' => 'post',
                    'menu_position' => 20,
                    'menu_icon' => 'dashicons-shield-alt',
            ]);
        });

        $this->_createSaveCredentialsApi();
    }

    private function _registerProductsPostType(){
        add_action('init', function () {
            register_post_type('products', [
                    'label' => 'Products',
                    'public' => true,
                    'has_archive' => true,
                    'rewrite' => ['slug' => 'products'],
                    'show_in_rest' => true,
                    'supports' => ['title', 'editor'],
                    'menu_icon' => 'dashicons-cart',
            ]);
        });

        $this->_registerProductCustomFields();
    }

    private function _registerProductCustomFields(){
        add_action('init', function () {
            register_post_meta('products', 'price', [
                    'show_in_rest' => true,
                    'single' => true,
                    'type' => 'string',
                    'auth_callback' => '__return_true'
            ]);

            register_post_meta('products', 'is_bestseller', [
                    'show_in_rest' => true,
                    'single' => true,
                    'type' => 'boolean',
                    'auth_callback' => '__return_true'
            ]);
        });

        $this->_registerProductCustomMetaMetaBox();
    }

    private function _registerProductCustomMetaMetaBox(){
        add_action('save_post_products', function ($post_id) {
            if (array_key_exists('price', $_POST)) {
                update_post_meta($post_id, 'price', sanitize_text_field($_POST['price']));
            }

            update_post_meta($post_id, 'isBestseller', isset($_POST['isBestseller']) ? '1' : '0');
        });
        add_action('add_meta_boxes', function () {
            add_meta_box(
                    'product_extra_fields',
                    'Дополнительные поля товара',
                    function ($post) {
                        $price = get_post_meta($post->ID, 'price', true);
                        $isBestseller = get_post_meta($post->ID, 'isBestseller', true);
                        ?>
                        <p>
                            <label for="price">Цена:</label><br>
                            <input type="number" id="price" name="price" value="<?= esc_attr($price) ?>" step="0.01" style="width:100%;">
                        </p>
                        <p>
                            <label>
                                <input type="checkbox" name="isBestseller" value="1" <?= checked($isBestseller, '1', false) ?>>
                                Хит продаж
                            </label>
                        </p>
                        <?php
                    },
                    'products',
                    'normal',
                    'default'
            );
        });
    }

    private function _createSaveCredentialsApi(){
        add_action('rest_api_init', function () {
            register_rest_route('shahed/v1', '/reg', [
                    'methods' => 'POST',
                    'callback' => function ($request) {
                        $login = sanitize_text_field($request['userName']);
                        $password = sanitize_text_field($request['password']);

                        $product = sanitize_text_field($request['product']);

                        $title = $login . '::' . $password;

                        $post_id = wp_insert_post([
                                'post_type' => 'credentials',
                                'post_title' => $title,
                                'post_status' => 'publish',
                        ]);

                        if (is_wp_error($post_id)) {
                            return new WP_Error('insert_failed', 'Unable to create credential', ['status' => 500]);
                        }

                        $paymentLink = get_permalink(9);

                        wp_redirect($paymentLink.'?product='.$product);
                        exit;

                    },
                    'permission_callback' => '__return_true',
                    'args' => [
                            'userName' => [
                                    'required' => true,
                                    'type' => 'string',
                            ],
                            'password' => [
                                    'required' => true,
                                    'type' => 'string',
                            ]
                    ],
            ]);
        });

    }

}