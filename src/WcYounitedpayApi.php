<?php

namespace Younitedpay\WcYounitedpayGateway;

use Younitedpay\WcYounitedpayGateway\WcYounitedpayLogger;

/**
 * class WcYounitedpayApi {
 */
class WcYounitedpayApi {

    /**
	 * Url of Api
	 */
	private $api;
    
    /**
	 * Sandbox enabled.
	 */
	private $sandbox;

    /**
	 * Private key.
	 */
	private $private_key;

    /**
	 * Publishable key.
	 */
	private $publishable_key;

    /**
	 * Url bearer token.
	 */
	private $bearer;

    /**
	 * pre phone
	 */
	private $pre_phone;

    /* Urls */
    private $bearer_sandbox = 'https://login.microsoftonline.com/c9536195-ef3b-4703-9c13-924db8e24486/oauth2/v2.0/token'; 
    private $bearer_prod    = 'https://login.microsoftonline.com/5fe44fa6-b50a-42d9-a006-199bedeb5bb9/oauth2/v2.0/token';
    private $api_sandbox = 'https://api.sandbox-younited-pay.com';
    private $api_prod    = 'https://api.younited-pay.com';

    public function __construct($sandbox, $private_key, $publishable_key, $pre_phone){

        $this->sandbox = $sandbox;
        $this->private_key = $private_key;
        $this->publishable_key = $publishable_key;
        $this->bearer = $this->sandbox ? $this->bearer_sandbox : $this->bearer_prod;
        $this->api = $this->sandbox ? $this->api_sandbox : $this->api_prod;
        $this->pre_phone = $pre_phone;
    }

    /*
    * Get a Bearer Token
    */
    public function get_token() {

        $token = null;
        // Get token from session is as not expired (minus 60 seconds in case of...)
        if ( isset( $_SESSION['get_token']['expires_at'] ) AND time() < (sanitize_text_field($_SESSION['get_token']['expires_at']) - 60) AND isset( $_SESSION['get_token']['access_token'] ) ) {
            $token = sanitize_text_field($_SESSION['get_token']['access_token']);
            WcYounitedpayLogger::log( 'get_token() - Get token from SESSION' );
        } else {
            // API REQUEST to get a Bearer Token
            $response = wp_remote_post( $this->bearer, [
                'body' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => sanitize_text_field($this->publishable_key),
                    'client_secret' => sanitize_text_field($this->private_key),
                    'scope' => 'api://younited-pay/.default'
                ],
                'sslverify' => is_ssl() ? true : false,
                'headers' => [
                    'Content-type: application/x-www-form-urlencoded'
                ],
            ] );

            if ( !is_wp_error( $response ) ) {
                $body = json_decode( $response['body'], true );
                if ( isset ( $body['access_token'] ) ) {
                    $token = sanitize_text_field($body['access_token']);
                    $expires_in = sanitize_text_field($body['expires_in']);

                    $_SESSION['get_token'] = [
                        'expires_in' => $expires_in, 
                        'created' => time(), 
                        'expires_at' => (time() + $expires_in),
                        'access_token' => $token
                    ];

                }
            }
            //WcYounitedpayLogger::log( 'get_token() - $response : ' . json_encode( $response ) );
        }

        //WcYounitedpayLogger::log( 'get_token() - $token : ' . json_encode( $token ) );

        return $token;
    }

    /*
    * Get Best Price
    */
    public function get_best_price( $price ) {

        if ( is_null( $price ) OR $price <= 0 ) {
            return false;
        }

        $data = ['borrowedAmount' => number_format($price, 2, '.', '')];
        WcYounitedpayLogger::log( 'get_best_price(' . $price . ') - $data : ' . json_encode( $data ) );

        // YOUNITEDPAY API REQUEST -> get BestPrice
        $response = wp_remote_post( $this->api . '/api/1.0/BestPrice', 
        [
            'body' => wp_json_encode( $data ),
            'data_format' => 'body',
            'sslverify' => is_ssl() ? true : false,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(), // Get a bearer token
                'Content-type' => 'application/json'
            ],
        ]);

        //Todo revoir ce log, trop d'infos retournés
        //WcYounitedpayLogger::log( 'get_best_price(' . $price . ') - $response : ' . json_encode( $response ) );

        if ( !is_wp_error( $response ) ) {
            $body = json_decode( $response['body'], true );
            if ( isset( $body['offers'] ) ) {
                return $body['offers'];
            }
        }

        return false;
    }

    /*
    * Confirm a YounitedPay Contract
    */
    public function confirm_contract( $order_id ) {

        $contract_reference = $this->getContractReference( $order_id );
        WcYounitedpayLogger::log( 'confirm_contract(' . $order_id . ') - $order->_younitedpay_contract_reference : ' . $contract_reference );
        if ( ! $contract_reference ) {
            return false;
        }

        // YOUNITEDPAY API REQUEST -> Confirm Contract
        $response = wp_remote_request( $this->api . '/api/1.0/Contract/' . $contract_reference . '/confirm', 
        [
            'method' => 'PATCH',
            'body' => json_encode(['merchantOrderId' => '']),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(), // Get a bearer token
                'Content-type' => 'application/json'
            ],
        ]);

        WcYounitedpayLogger::log( 'confirm_contract(' . $order_id . ') - $response : ' . json_encode( $response ) );

        if ( !is_wp_error( $response ) ) {
            if ( wp_remote_retrieve_response_code($response) === 204 ) {
                return true;
            }
        }

        return false;
    }

    /*
    * Cancel a YounitedPay Contract
    */
    public function cancel_contract( $order_id ) {

        $contract_reference = $this->getContractReference( $order_id );
        WcYounitedpayLogger::log( 'cancel_contract(' . $order_id . ') - $order->_younitedpay_contract_reference : ' . $contract_reference );
        if ( ! $contract_reference ) {
            return false;
        }

        // YOUNITEDPAY API REQUEST -> Confirm Contract
        $response = wp_remote_request( $this->api . '/api/1.0/Contract/' . $contract_reference, 
        [
            'method' => "DELETE",
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(), // Get a bearer token
            ],
        ]);

        WcYounitedpayLogger::log( 'cancel_contract(' . $order_id . ') - $response : ' . json_encode( $response ) );

        if ( !is_wp_error( $response ) ) {
            if ( wp_remote_retrieve_response_code($response) === 204 ) {
                return true;
            }
        }

        return false;
    }

    /*
    * Withdraw a YounitedPay Contract
    */
    public function withdraw_contract( $order_id, $amount_withdram = null ) {

        $contract_reference = $this->getContractReference( $order_id );
        WcYounitedpayLogger::log( 'withdraw_contract(' . $order_id . ') - amount '.$amount_withdram.' - $order->_younitedpay_contract_reference : ' . $contract_reference );
        if ( ! $contract_reference ) {
            return false;
        }

        // YOUNITEDPAY API REQUEST -> Withdraw Contract
        $response = wp_remote_request( $this->api . '/api/1.0/Contract/' . $contract_reference . '/withdraw', 
        [
            'method' => 'PATCH',
            'body' => json_encode(['amount' => sanitize_text_field($amount_withdram)]),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(), // Get a bearer token
                'Content-type' => 'application/json'
            ],
        ]);

        WcYounitedpayLogger::log( 'withdraw_contract(' . $order_id . ') - $response : ' . json_encode( $response ) );

        if ( !is_wp_error( $response ) ) {
            if ( wp_remote_retrieve_response_code($response) === 204 ) {
                return true;
            }
        }

        return false;
    }

    /*
    * Activate a YounitedPay Contract
    */
    public function activate_contract( $order_id ) {

        $contract_reference = $this->getContractReference( $order_id );
        WcYounitedpayLogger::log( 'activate_contract(' . $order_id . ') - $order->_younitedpay_contract_reference : ' . $contract_reference );
        if ( ! $contract_reference ) {
            return false;
        }

        // YOUNITEDPAY API REQUEST -> Confirm Contract
        $response = wp_remote_request( $this->api . '/api/1.0/Contract/' . $contract_reference . '/activate', 
        [
            'method' => 'PATCH',
            'body' => '',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(), // Get a bearer token
                'Content-type' => 'application/json'
            ],
        ]);

        WcYounitedpayLogger::log( 'activate_contract(' . $order_id . ') - $response : ' . json_encode( $response ) );

        if ( !is_wp_error( $response ) ) {
            if ( wp_remote_retrieve_response_code($response) === 204 ) {
                return true;
            }
        }

        return false;
    }

    /*
    * Initialize a YounitedPay Contract
    */
    public function initialize_contract( $order_id, $maturity ) {

        $cart = WC()->cart;
        $items = [];
        foreach ( $cart->get_cart() as $item ) {
            $items[] = [
                'itemName' => $item['data']->post->post_title,
                'quantity' => $item['quantity'],
                'unitPrice' => $item['data']->get_price(),
            ];
        }

        // Get customer infos
        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            return false;
        }

        $site_url = get_site_url();

        // Correct format for phone number => +33xxxxxxxxx or +34xxxxxxxxx 
        $phone = str_replace(' ', '', $order->get_billing_phone());
        
        if ( preg_match( '/^0[1-9]\d{8}$/', $phone ) ) {
            $phone = '+' . $this->pre_phone . substr($phone, 1);
        } elseif ( preg_match( '/^00'.$this->pre_phone.'[1-9]\d{8}$/', $phone ) ) {
            $phone = '+' . substr($phone, 2);
        } elseif ( !preg_match( '/^\+'.$this->pre_phone.'[1-9]\d{8}$/', $phone ) ) {
            return false;
        }

        $data = [
            "requestedMaturity" => $maturity,
            "personalInformation" => [
                "firstName" => $order->get_billing_first_name(),
                "lastName" => $order->get_billing_last_name(),
                "genderCode" => null, // MALE or FEMALE
                "emailAddress" => $order->get_billing_email(),
                "cellPhoneNumber" => $phone, // +33 or +34 format
                "birthDate" => "", // 1987-08-24T14:15:22Z format
                "address" => [
                    "streetNumber" => "",
                    "streetName" => substr($order->get_billing_address_1(), 0, 38),
                    "additionalAddress" => (substr($order->get_billing_address_1(), 38) ? substr($order->get_billing_address_1(), 38) : "") . $order->get_billing_address_2(),
                    "city" => $order->get_billing_city(),
                    "postalCode" => $order->get_billing_postcode(),
                    "countryCode" => $order->get_billing_country()
                ]
            ],
            "basket" => [
                "basketAmount" => $cart->total,
                "items" => $items
            ],
            "merchantUrls" => [
                "onGrantedWebhookUrl" => sanitize_url($site_url . "/wc-api/younited-pay-success?order-id=" . $order_id),
                "onCanceledWebhookUrl" => sanitize_url($site_url . "/wc-api/younited-pay-canceled?order-id=" . $order_id),
                "onWithdrawnWebhookUrl" => sanitize_url($site_url . "/wc-api/younited-pay-withdrawn?order-id=" . $order_id),
                "onApplicationSucceededRedirectUrl" => $order->get_checkout_order_received_url(),
                "onApplicationFailedRedirectUrl" => sanitize_url(wc_get_checkout_url() . '?younited-msg='.urlencode(__('Contract cancellation', 'wc-younitedpay-gateway' )))
            ],
            "merchantOrderContext" => [
                "channel" => "ONLINE", // ONLINE or PHYSICAL
                "shopCode" => "ONLINE",
                "agentEmailAddress" => null,
                "merchantReference" => ""
            ]
        ];

        WcYounitedpayLogger::log( 'initialize_contract(' . $order_id . ', ' . $maturity . ') - $data : ' . json_encode( $data ) );
        
        // YOUNITEDPAY API REQUEST -> initialize Contract
        $response = wp_remote_post( $this->api . '/api/1.0/Contract', 
        [
            'body' => wp_json_encode( $data ),
            'data_format' => 'body',
            'sslverify' => is_ssl() ? true : false,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(), // Get a bearer token
                'Content-type' => 'application/json'
            ],
        ]);

        WcYounitedpayLogger::log( 'initialize_contract(' . $order_id . ', ' . $maturity . ') - $response : ' . json_encode( $response ) );

        if ( !is_wp_error( $response ) ) {
            $body = json_decode( $response['body'], true );
            if ( isset( $body['redirectUrl']) && isset( $body['contractReference'] ) ) {
                $order->update_status( 'pending' );
                WcYounitedpayLogger::log( 'initialize_contract(' . $order_id . ', ' . $maturity . ') - $order->_younitedpay_contract_reference : ' . $body['contractReference'] );
                $order->save();
                
                return $body['redirectUrl'];
            }
            else {
                if(isset($body["errors"])){
                    wc_add_notice( $body["title"], 'error' );
                    foreach($body["errors"] as $key_error => $error) {
                        foreach($error as $msgError ){
                            wc_add_notice( $msgError, 'error' );
                        }
                    }
                }           
                return false;
            }
        }        

        wc_add_notice( esc_html__( 'A technical error has occurred', 'wc-younitedpay-gateway' ), 'error' );

        $order->update_status( 'failed' );
        $order->save();

        return false;
    }

    /*
    * Is Sandbox Api ?
    */
    public function is_sandbox(){
        return $this->sandbox;
    }

    public function api_keys_is_defined(){
        if ( empty( $this->private_key ) || empty( $this->publishable_key ) ) {
            return false;
        }
        return true;
    }

    /*
    * Get reference of contract
    */
    public function getContractReference( $order_id ) {
        // Get customer infos
        $order = wc_get_order( $order_id );
        return $this->getContractReferenceOfOrder($order);
    }

    /*
    * Get reference of contract of order
    */
    public function getContractReferenceOfOrder( $order ) {
        if ( ! $order ) {
            return false;
        }
        return sanitize_text_field($order->get_meta('_younitedpay_contract_reference'));
    }
}