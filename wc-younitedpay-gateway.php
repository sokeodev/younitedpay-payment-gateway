<?php
/**
 * Plugin Name: YounitedPay Payment Gateway
 * Plugin URI: https://younited.com/
 * Description: YounitedPay Payment Gateway for WooCommerce
 * Author: Sokeo
 * Author URI: https://sokeo.fr
 * Version: 1.2.0
 * Requires at least: 6.0
 * Tested up to: 6.2
 * Text Domain: wc-younitedpay-gateway
 * Domain Path: /languages
 */

use Younitedpay\WcYounitedpayGateway\WcYounitedpayUtils;
use Younitedpay\WcYounitedpayGateway\WcYounitedpayPage;

 //si on est pas dans wordpress => exit
 if ( ! defined( 'ABSPATH' ) )
    exit;

//TODO amélioration activation plugin
define('WC_YOUNITEDPAY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WC_YOUNITEDPAY_GATEWAY_CLASS', "WcYounitedpayGateway");
define('WC_YOUNITEDPAY_GATEWAY_LANG', 'wc-younitedpay-gateway');
require WC_YOUNITEDPAY_PLUGIN_DIR . 'vendor/autoload.php';

/*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter( 'woocommerce_payment_gateways', 'wc_younitedpay_add_gateway' );
function wc_younitedpay_add_gateway( $gateways ) {
	$gateways[] = WC_YOUNITEDPAY_GATEWAY_CLASS;
	return $gateways;
}

add_action( 'plugins_loaded', 'wc_younitedpay_add_plugin' );
function wc_younitedpay_add_plugin() {

	if ( !class_exists( 'WC_Payment_Gateway' ) ) return;

	require_once plugin_dir_path( __FILE__ ) . "src/".WC_YOUNITEDPAY_GATEWAY_CLASS.".php";

	//initialise le module pour ajouter les hooks sur la page produit et la page commande ( mode admin )
	new WcYounitedpayGateway(false);
}

//langue du module
WcYounitedpayUtils::load_textdomain();
new WcYounitedpayPage();
