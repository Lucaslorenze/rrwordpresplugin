<?php
/**
 * Plugin Name: Coworking Manager
 * Plugin URI: https://example.com/
 * Description: Gestiona reservas, membresías, pases y accesos para espacios de coworking.
 * Version: 0.1.0
 * Author: Example Author
 * Text Domain: coworking-manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Coworking_Manager {

    public function __construct() {
        add_action( 'init', array( $this, 'register_post_types' ) );
        add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
    }

    public function register_post_types() {
        $this->register_reservation_cpt();
        $this->register_membership_cpt();
    }

    private function register_reservation_cpt() {
        $labels = array(
            'name' => __( 'Reservas', 'coworking-manager' ),
            'singular_name' => __( 'Reserva', 'coworking-manager' ),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'supports' => array( 'title', 'editor', 'custom-fields' ),
            'menu_icon' => 'dashicons-calendar-alt',
        );

        register_post_type( 'cw_reservation', $args );
    }

    private function register_membership_cpt() {
        $labels = array(
            'name' => __( 'Membresías', 'coworking-manager' ),
            'singular_name' => __( 'Membresía', 'coworking-manager' ),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'supports' => array( 'title', 'editor', 'custom-fields' ),
            'menu_icon' => 'dashicons-groups',
        );

        register_post_type( 'cw_membership', $args );
    }

    public function add_admin_pages() {
        add_menu_page(
            __( 'Coworking Manager', 'coworking-manager' ),
            __( 'Coworking', 'coworking-manager' ),
            'manage_options',
            'coworking-manager',
            array( $this, 'render_dashboard' ),
            'dashicons-building',
            25
        );
    }

    public function render_dashboard() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__( 'Coworking Manager Dashboard', 'coworking-manager' ) . '</h1>';
        echo '<p>' . esc_html__( 'Desde aquí podrás administrar reservas, membresías y accesos.', 'coworking-manager' ) . '</p>';
        echo '</div>';
    }
}

new Coworking_Manager();

/**
 * Utilidad para enviar mensajes de WhatsApp.
 * @param string $number Número de teléfono en formato internacional.
 * @param string $message Mensaje a enviar.
 * @return string URL generada.
 */
function cw_get_whatsapp_link( $number, $message ) {
    $base = 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $number );
    $query = '?text=' . urlencode( $message );
    return esc_url( $base . $query );
}

