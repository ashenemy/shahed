<?php
/**
 * Plugin Name: Card Payment for Woocommerce
 * Plugin URI: https://t.me/hugo_info
 * Author Name: Hugo Moder
 * Author URI: https://t.me/hugo_info
 * Description: This plugin allows for local content payment systems.
 * Version: 0.3.1
 * License: 0.1.0
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: card-pay-woo
 */

/*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter("woocommerce_payment_gateways", "hugo_add_gateway_class");
function hugo_add_gateway_class($gateways)
{
    $gateways[] = "WC_Hugo_Gateway"; // your class name is here
    return $gateways;
}

/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action("plugins_loaded", "hugo_init_gateway_class");
function hugo_init_gateway_class()
{
    class WC_Hugo_Gateway extends WC_Payment_Gateway
    {
        /**
         * Class constructor, more about it in Step 3
         */
        public function __construct()
        {
            $this->id = "hugo"; // payment gateway plugin ID
            $this->icon = ""; // URL of the icon that will be displayed on checkout page near your gateway name
            $this->has_fields = true; // in case you need a custom credit card form
            $this->method_title = "Hugo Gateway";
            $this->method_description = "Description of Hugo payment gateway"; // will be displayed on the options page

            // gateways can support subscriptions, refunds, saved payment methods,
            // but in this tutorial we begin with simple payments
            $this->supports = ["products"];

            // Method with all the options fields
            $this->init_form_fields();

            // Load the settings.
            $this->init_settings();
            $this->title = $this->get_option("title");
            $this->description = $this->get_option("description");
            $this->enabled = $this->get_option("enabled");
            $this->payment_url = $this->get_option("payment_url");
            $this->icon = $this->get_option("icon");
            $this->image = $this->get_option("image");

            // This action hook saves the settings
            add_action(
                "woocommerce_update_options_payment_gateways_" . $this->id,
                [$this, "process_admin_options"]
            );

            // We need custom JavaScript to obtain a token
            add_action("wp_enqueue_scripts", [$this, "payment_scripts"]);
        }

        public function init_form_fields()
        {
            $this->form_fields = [
                "enabled" => [
                    "title" => "Enable/Disable",
                    "label" => "Enable Hugo Gateway",
                    "type" => "checkbox",
                    "description" => "",
                    "default" => "no",
                ],
                "title" => [
                    "title" => "Title",
                    "type" => "text",
                    "description" =>
                        "This controls the title which the user sees during checkout.",
                    "default" => "Credit Card",
                    "desc_tip" => true,
                ],
                "description" => [
                    "title" => "Description",
                    "type" => "textarea",
                    "description" =>
                        "This controls the description which the user sees during checkout.",
                    "default" => "Pay with your credit card.",
                ],
                "payment_url" => [
                    "title" => "Payment link",
                    "type" => "text",
                    "desc_tip" => true,
                    "description" => "Setup payment link",
                    "card-pay-woo",
                ],
                "icon" => [
                    "title" => "Payment favicon url",
                    "type" => "text",
                    "desc_tip" => true,
                    "description" => "some image url",
                ],
                "image" => [
                    "title" => "Payment image logo url",
                    "type" => "text",
                    "desc_tip" => true,
                    "description" => "some image url",
                ],
            ];
        }

        public function payment_scripts()
        {

            // we need JavaScript to process a token only on cart/checkout pages, right?
            if (!is_cart() && !is_checkout() && !isset($_GET['pay_for_order'])) {
                return;
            }

            // if our payment gateway is disabled, we do not have to enqueue JS too
            if ('no' === $this->enabled) {
                return;
            }

            // no reason to enqueue JavaScript if API keys are not set
            if (empty($this->private_key) || empty($this->publishable_key)) {
                return;
            }

            // do not work with card detailes without SSL unless your website is in a test mode
            if (!$this->testmode && !is_ssl()) {
                return;
            }

            // let's suppose it is our payment processor JavaScript that allows to obtain a token
            wp_enqueue_script('hugo_js', 'some payment processor site/api/token.js');

            // and this is our custom JS in your plugin directory that works with token.js
            wp_register_script('woocommerce_hugo', plugins_url('hugo.js', __FILE__), array('jquery', 'hugo_js'));

            // in most payment processors you have to use PUBLIC KEY to obtain a token
            wp_localize_script('woocommerce_hugo', 'hugo_params', array(
                'publishableKey' => $this->publishable_key
            ));

            wp_enqueue_script('woocommerce_hugo');


        }

        public function validate_fields()
        {
            if (
                empty(
                    WC()
                        ->checkout()
                        ->get_value("billing_first_name")
                )
            ) {
                wc_add_notice("First name is required!", "error");
                return false;
            }

            return true;
        }

        public function process_payment($order_id)
        {
            global $woocommerce;
            $order = wc_get_order($order_id);

            // Mark as on-hold (we're awaiting the payment)
            $order->update_status(
                "on-hold",
                __("Awaiting card payment", "card-pay-woo")
            );

            // Reduce stock levels
            wc_reduce_stock_levels($order_id);

            $billing_address = $order->get_address("billing");

            $subid_1 = "Unknown";
            if (isset($_COOKIE['subid_1'])) {
                $subid_1 = sanitize_text_field($_COOKIE['subid_1']);
            }

            $gclid = "Unknown";
            if (isset($_COOKIE['gclid'])) {
                $gclid = sanitize_text_field($_COOKIE['gclid']);
            }

            $data = [
                "site" => $_SERVER["SERVER_NAME"],
                "amount" => $woocommerce->cart->cart_contents_total,
                "return_url" => $this->get_return_url($order),
                "symbol" => html_entity_decode(
                    get_woocommerce_currency_symbol()
                ),
                "order" => base64_encode(
                    json_encode([
                        "total" => $woocommerce->cart->cart_contents_total,
                        "billing_first_name" => $billing_address["first_name"],
                        "billing_last_name" => $billing_address["last_name"],
                        "billing_company" => $billing_address["company"],
                        "billing_address_1" => $billing_address["address_1"],
                        "billing_address_2" => $billing_address["address_2"],
                        "billing_city" => $billing_address["city"],
                        "billing_state" => $billing_address["state"],
                        "billing_postcode" => $billing_address["postcode"],
                        "billing_country" => $billing_address["country"],
                        "billing_email" => $billing_address["email"],
                        "billing_phone" => $billing_address["phone"],
                        "order_id" => $order_id,
                    ])
                ),
                "icon" => $this->icon,
                "image" => $this->image,
                "refer" => $subid_1,
                "gclid" => $gclid
            ];

            // Remove cart
            WC()->cart->empty_cart();

            // Return thankyou redirect
            return [
                "result" => "success",
                "redirect" =>
                    $this->payment_url . "?" . http_build_query($data),
            ];
        }
    }
}

add_action("woocommerce_blocks_loaded", "rudr_gateway_block_support");
function rudr_gateway_block_support()
{
    if (
        !class_exists(
            "Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType"
        )
    ) {
        return;
    }

    // here we're including our "gateway block support class"
    require_once __DIR__ . "/includes/class-wc-hugo-gateway-blocks-support.php";

    // registering the PHP class we have just included
    add_action("woocommerce_blocks_payment_method_type_registration", function (
        Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry
    ) {
        $payment_method_registry->register(
            new WC_Hugo_Gateway_Blocks_Support()
        );
    });
}

add_action(
    "before_woocommerce_init",
    "rudr_cart_checkout_blocks_compatibility"
);

function rudr_cart_checkout_blocks_compatibility()
{
    if (class_exists("\Automattic\WooCommerce\Utilities\FeaturesUtil")) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
            "cart_checkout_blocks",
            __FILE__,
            false // true (compatible, default) or false (not compatible)
        );
    }
}

add_filter('query_vars', 'add_custom_query_vars');
function add_custom_query_vars($vars) {
    $vars[] = 'subid_1';
    $vars[] = 'gclid';
    return $vars;
}

add_action('template_redirect', 'save_query_var_to_cookie');
function save_query_var_to_cookie() {
    $need_redirect = false;
    $param_value_subid_1 = get_query_var('subid_1', false);
    if ($param_value_subid_1) {
        $param_value_subid_1 = sanitize_text_field($param_value_subid_1);
        setcookie('subid_1', $param_value_subid_1, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
        $need_redirect = true;
    }
    $param_value_gclid = get_query_var('gclid', false);
    if ($param_value_gclid) {
        $param_value_gclid = sanitize_text_field($param_value_gclid);
        setcookie('gclid', $param_value_gclid, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
        $need_redirect = true;
    }
    if($need_redirect) {
        wp_redirect(home_url('/'));
        exit;
    }
}
