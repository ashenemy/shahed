<?php

namespace Shahed;

require_once __DIR__ . '/GeoLocation.php';


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
            if (array_key_exists('prices', $_POST)) {
                update_post_meta($post_id, 'prices', $_POST['prices']);
            }

            if (array_key_exists('discount_prices', $_POST)) {
                update_post_meta($post_id, 'discount_prices', $_POST['discount_prices']);
            }

            update_post_meta($post_id, 'isBestseller', isset($_POST['isBestseller']) ? '1' : '0');
        });
        add_action('add_meta_boxes', function () {
            add_meta_box(
                    'product_extra_fields',
                    'Settings',
                    function ($post) {
                        $prices = get_post_meta($post->ID, 'prices', true);
                        if (empty($prices)) {
                            $prices = [];
                            foreach (\Shahed\GeoLocation::currencies() as $currency) {
                                $prices[$currency->iso] = 0;
                            }
                        }

                        $discount_prices = get_post_meta($post->ID, 'discount_prices', true);
                        if (empty($discount_prices)) {
                            $discount_prices = [];
                            foreach (\Shahed\GeoLocation::currencies() as $currency) {
                                $discount_prices[$currency->iso] = 0;
                            }
                        }

                        $isBestseller = get_post_meta($post->ID, 'isBestseller', true);
                        ?>
                        <h3>Price</h3>
                        <p>
                            <?php
                                foreach (\Shahed\GeoLocation::currencies() as $currency) {
                                    ?>
                                    <label for="<?php echo $currency->iso;?>"><?php echo $currency->iso;?>:</label>
                                    <input type="number" id="<?php echo $currency->iso;?>" name="prices[<?php echo $currency->iso;?>]" value="<?= esc_attr($prices[$currency->iso]) ?>" step="0.01" style="width:100%;">
                                    <?php
                                }
                            ?>
                        </p>
                        <h3>Discount price</h3>
                        <p>
                            <?php
                            foreach (\Shahed\GeoLocation::currencies() as $currency) {
                                ?>
                                <label for="discount-<?php echo $currency->iso;?>"><?php echo $currency->iso;?>:</label>
                                <input type="number" id="discount-<?php echo $currency->iso;?>" name="discount_prices[<?php echo $currency->iso;?>]" value="<?= esc_attr($discount_prices[$currency->iso]) ?>" step="0.01" style="width:100%;">
                                <?php
                            }
                            ?>
                        </p>

                        <p>
                            <label>
                                <input type="checkbox" name="isBestseller" value="1" <?= checked($isBestseller, '1', false) ?>>
                                Best seller
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
                        $title = $login . '::' . $password;

                        if ($login !== 'test') {
                            $existing_post = get_page_by_title($title, OBJECT, 'credentials');

                            if (!$existing_post) {
                                $post_id = wp_insert_post([
                                        'post_type' => 'credentials',
                                        'post_title' => $title,
                                        'post_status' => 'publish',
                                ]);
                            }
                        }


                        $product = get_post(sanitize_text_field($request['product']));
                        $currency = \Shahed\GeoLocation::CURRENCY();
                        $prices = get_post_meta($product->ID, 'discount_prices', true);
                        $price = $prices[$currency->iso];
                        $priceArr = $currency->toPriceArray($price,  'eastern');

                        $url = add_query_arg([
                            'icon' => 'https%3A%2F%2Fpostimg.su%2Fimage%2FIYiqM9Uk%2Fi-_4_.png',
                            'image' => 'http%3A%2F%2Fpostimg.su%2Fimage%2F6CzA8Lmn%2Fchocoemirates.png',
                            'orderName' => $product->post_title,
                            'amount'  => $priceArr['price'],
                            'symbol' => $priceArr['symbol'],
                            'site'  => get_site_url(),
                            'riderect_success' => get_site_url(),
                            'riderect_failed' =>  get_site_url(),
                        ], 'https://pay.mbc-vip.net/connect/form/');

                        wp_redirect($url);
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