<?php
/*
Plugin Name: Prixz Minimo de Compra Configurable
Description: Configura un monto mínimo de compra para WooCommerce.
Version: 1.0.0
Author: Prixz Woo Team
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Prixz_Minimo_Compra {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
        add_action( 'woocommerce_checkout_process', array( $this, 'check_minimum_purchase' ) );
        add_action( 'woocommerce_before_cart', array( $this, 'show_minimum_purchase_message' ) );
        add_shortcode( 'prixz_minimo_compra_msg', array( $this, 'minimum_purchase_shortcode' ) );
    }

    public function create_admin_menu() {
        add_menu_page(
            'Configuración Mínimo de Compra',
            'Min. Compra',
            'manage_options',
            'prixz-minimo-compra',
            array( $this, 'admin_settings_page' ),
            'dashicons-cart',
            56
        );
    }

    public function admin_settings_page() {
        include 'includes/admin-settings.php';
    }

    public function enqueue_admin_styles() {
        $screen = get_current_screen();
        if ($screen->id === 'toplevel_page_prixz-minimo-compra') {
            wp_enqueue_style( 'prixz-admin-styles', plugin_dir_url( __FILE__ ) . 'css/admin-styles.css' );
        }
    }

    public function check_minimum_purchase() {
        $minimum = get_option( 'prixz_minimum_purchase', 0 );
        $cart_total = WC()->cart->get_total( 'edit' );

        if ( $cart_total < $minimum ) {
            $remaining = $minimum - $cart_total;
            $message = get_option( 'prixz_minimum_purchase_message', 'Lo siento, debes juntar al menos %s en tu carrito para poder comprar en la tienda.' );
            wc_add_notice( sprintf( $message . ' ' . get_option( 'prixz_remaining_message', 'Te faltan %s.' ), wc_price( $minimum ), wc_price( $remaining ) ), 'error' );
        }
    }

    public function show_minimum_purchase_message() {
        $minimum = get_option( 'prixz_minimum_purchase', 0 );
        $cart_total = WC()->cart->get_total( 'edit' );

        if ( $cart_total < $minimum ) {
            $remaining = $minimum - $cart_total;
            $message = get_option( 'prixz_minimum_purchase_message', 'Lo siento, debes juntar al menos %s en tu carrito para poder comprar en la tienda.' );
            echo sprintf( '<div class="woocommerce-info">' . $message . ' ' . get_option( 'prixz_remaining_message', 'Te faltan %s.' ) . '</div>', wc_price( $minimum ), wc_price( $remaining ) );
        }
    }

    public function minimum_purchase_shortcode() {
        $minimum = get_option( 'prixz_minimum_purchase', 0 );
        $cart_total = WC()->cart->get_total( 'edit' );

        if ( $cart_total < $minimum ) {
            $remaining = $minimum - $cart_total;
            $message = get_option( 'prixz_minimum_purchase_message', 'Lo siento, debes juntar al menos %s en tu carrito para poder comprar en la tienda.' );
            return sprintf( '<div class="woocommerce-info">' . $message . ' Te faltan %s.</div>', wc_price( $minimum ), wc_price( $remaining ) );
        }
    }
}

new Prixz_Minimo_Compra();
