<?php

namespace Younitedpay\WcYounitedpayGateway;

/**
 * class WcYounitedpayAdminForm {
 */
class WcYounitedpayAdminForm {



    public function __construct(){

    }

    public function settings_fields(){
        $fields=[];
        $fields['enabled'] = [
            'title'       => esc_html__( 'Plugin Younitedpay', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'label'       => esc_html__( 'Enable / Disable', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'checkbox',
            'description' => esc_html__( 'This enable the YounitedPay gateway which allow to accept payment through YounitedPay.', WC_YOUNITEDPAY_GATEWAY_LANG  ),
            'default'     => 'no',
            
        ];

        /* 
        //Stand by
        $fields['language_admin'] = [
            'title'       => esc_html__( 'Administrative language', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'select',
            'description' => "",
            'options' => array(
                "" => "Default",
                "fr_FR" => 'Français',
                "es_ES" => 'Español',
                "en_EN" => 'English'
            ),
            'default' => get_locale()
        ];
        */

        $fields['title'] = [
            'title'       => esc_html__( 'Title', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'text',
            'description' => esc_html__( 'This controls the title which the user sees during checkout.', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'default'     => 'Credit Card',
        ];
        $fields['description'] = [
            'title'       => esc_html__( 'Description', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'textarea',
            'description' => esc_html__( 'This controls the description which the user sees during checkout.', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'default'     => '',
        ];
        
        $fields['testmode'] = [
            'title'       => esc_html__( 'Test mode', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'label'       => esc_html__( 'Enable / Disable', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'checkbox',
            'description' => esc_html__( 'Place the payment gateway in test mode using test API keys.', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'default'     => 'yes',
            'desc_tip'    => true,
        ];

        $fields['test_publishable_key'] = [
            'title'       => esc_html__( 'Client ID Test', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'text'
        ];
        $fields['test_private_key'] = [
            'title'       => esc_html__( 'Client Secret Test', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'password',
        ];

        $fields['test_webhook_key'] = [
            'title'       => esc_html__( 'Webhook Secret Test', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'password'
        ];

        $fields['publishable_key'] = [
            'title'       => esc_html__( 'Client ID Production', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'text'
        ];

        $fields['private_key'] = [
            'title'       => esc_html__( 'Client Secret Production', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'password'
        ];

        $fields['webhook_key'] = [
            'title'       => esc_html__( 'Webhook Secret Production', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'password'
        ];

        $fields['whitelist_enable'] = [
            'title'       => esc_html__( 'Enable Ip Whitelist' , WC_YOUNITEDPAY_GATEWAY_LANG),
            'type'        => 'checkbox',
            'default'     => 'false',
            'desc_tip'    => true,
        ];

        
        $fields['whitelist'] = [
            'title'       => esc_html__( 'Ip Whitelist', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'label'       => esc_html__( 'Ip Whitelist', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'text',
            'description' => esc_html__( 'Separate the different IPs with a comma.', WC_YOUNITEDPAY_GATEWAY_LANG ). "<br>" .
                             esc_html__( "When enable, only the listed IPs will see the module's component on the site", WC_YOUNITEDPAY_GATEWAY_LANG ),
            'default'     => '',
        ];

        return $fields;
    }

    public function behaviour_fields($possible_maturities){
        $fields=[];

        $fields['possible_maturities'] = [
            'title'       => esc_html__( 'Maturities possibles (in months)', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'text',
            'default'     => '10',
            'description' => esc_html__( 'Separate the different numbers with a comma.', WC_YOUNITEDPAY_GATEWAY_LANG )." <br> ".
                             esc_html__('To display the new maturities added, save the modifications,', WC_YOUNITEDPAY_GATEWAY_LANG). "<br>" .
                             esc_html__('the new maturities will appear below the existing ones.', WC_YOUNITEDPAY_GATEWAY_LANG)
        ];

        foreach($possible_maturities as $maturity){
            if(!empty($maturity) && is_numeric($maturity)){

                $title_min_amount = sprintf(
                    esc_html__( 'Maturity %s month - Minimum amount', WC_YOUNITEDPAY_GATEWAY_LANG ), $maturity
                );
                $title_max_amount = sprintf(
                    esc_html__( 'Maturity %s month - Maximum amount', WC_YOUNITEDPAY_GATEWAY_LANG ), $maturity
                );

                $fields['min_amount_'.$maturity] = [
                    'title'       => $title_min_amount,
                    'type'        => 'number',
                    'default'     => '0',
                ];
                $fields['max_amount_'.$maturity] = [
                    'title'       => $title_max_amount,
                    'type'        => 'number',
                    'default'     => '0',
                ];
            }
        }

        return $fields;
    }

    public function appearance_fields(){
        $fields=[];


        $fields['logo_color'] = [
            'title'       => esc_html__( 'Logo', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'select',
            'description' => esc_html__('Logo color',WC_YOUNITEDPAY_GATEWAY_LANG),
            'options' => array(
                "black" => esc_html__("Black logo",WC_YOUNITEDPAY_GATEWAY_LANG),
                "white" => esc_html__("White logo",WC_YOUNITEDPAY_GATEWAY_LANG),
            ),
            'default' => 'black'
        ];

        $fields['monthly_installments_enable'] = [
            'title'       => esc_html__( 'Monthly installments', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'label'       => esc_html__( 'Enable / Disable', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'checkbox',
            'default'     => 'no',
        ];

        $options_product_hooks = array(
            'woocommerce_before_single_product',
            'woocommerce_before_single_product_summary',
            'woocommerce_single_product_summary',
            'woocommerce_before_add_to_cart_form',
            'woocommerce_before_variations_form',
            'woocommerce_before_add_to_cart_button',
            'woocommerce_before_single_variation',
            'woocommerce_single_variation',
            'woocommerce_before_add_to_cart_quantity',
            'woocommerce_after_single_variation',
            'woocommerce_after_add_to_cart_button',
            'woocommerce_after_variations_form',
            'woocommerce_after_add_to_cart_form',
            'woocommerce_product_meta_start',
            'woocommerce_product_meta_end',
            'woocommerce_share',
            'woocommerce_after_single_product_summary',
            'woocommerce_after_single_productbest_price_on_product_page',
            'woocommerce_after_add_to_cart_quantity'
        );
    
        $description_monthly_installments_product_hook =
        esc_html__( 'Theses values are located registered by your current theme, you can choose any of them to place the widget where it looks the best.', WC_YOUNITEDPAY_GATEWAY_LANG )
        .'<br><a href="https://www.businessbloomer.com/woocommerce-visual-hook-guide-single-product-page/" target="_blank">'.
        esc_html__( 'Click on this link for more informations', WC_YOUNITEDPAY_GATEWAY_LANG)
        ."</a>";
        
        $fields['monthly_installments_product_hook'] = [
            'title'       => esc_html__( 'Monthly installments in product page', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'select',
            'description' => $description_monthly_installments_product_hook,
            'options' => array_merge( array("" => esc_html__('Nothing',WC_YOUNITEDPAY_GATEWAY_LANG)), array_combine($options_product_hooks,$options_product_hooks)),
            'default' => ''
        ];

        /*
        $options_cart_hooks = array(
            'woocommerce_before_cart_table',
            'woocommerce_before_cart',
            'woocommerce_before_cart_contents',
            'woocommerce_cart_contents',
            'woocommerce_cart_coupon',
            'woocommerce_after_cart_contents',
            'woocommerce_after_cart_table',
            'woocommerce_cart_collaterals',
            'woocommerce_before_cart_totals',
            'woocommerce_cart_totals_before_shipping',
            'woocommerce_before_shipping_calculator',
            'woocommerce_after_shipping_calculator',
            'woocommerce_cart_totals_after_shipping',
            'woocommerce_cart_totals_before_order_total',
            'woocommerce_cart_totals_after_order_total',
            'woocommerce_proceed_to_checkout',
            'woocommerce_after_cart_totals',
            'woocommerce_after_cart'
        );

        $description_monthly_installments_cart_hook =
        esc_html__( 'Theses values are located registered by your current theme, you can choose any of them to place the widget where it looks the best.', WC_YOUNITEDPAY_GATEWAY_LANG )
        .'<br><a href="https://www.businessbloomer.com/woocommerce-visual-hook-guide-cart-page/" target="_blank">'.
        esc_html__( 'Click on this link for more informations', WC_YOUNITEDPAY_GATEWAY_LANG)
        ."</a>";

        $fields['monthly_installments_cart_hook'] = [
            'title'       => esc_html__( 'Monthly installments in cart page', WC_YOUNITEDPAY_GATEWAY_LANG ),
            'type'        => 'select',
            'description' => $description_monthly_installments_cart_hook,
            'options' => array_merge( array("" => esc_html__('Nothing', WC_YOUNITEDPAY_GATEWAY_LANG)), array_combine($options_cart_hooks,$options_cart_hooks)),
            'default' => ''
        ];
        */

        return $fields;
    }

    

    public function form_fields($possible_maturities){
        return array_merge(
            $this->settings_fields(), 
            $this->behaviour_fields($possible_maturities),
            $this->appearance_fields()
        );
    }
}