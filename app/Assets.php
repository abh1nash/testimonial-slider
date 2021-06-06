<?php

class AK_Testimonials_Assets {
    public function __construct() {
        $this->load_assets();
    }

    public function load_assets() {
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_admin_assets'] );
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_public_assets'] );
    }

    public function enqueue_public_assets() {
        wp_enqueue_style('ak-testimonials-style', plugin_dir_url( __DIR__ ).'dist/frontend/styles.css');
        wp_enqueue_script('ak-testimonials-script', plugin_dir_url( __DIR__ ).'dist/frontend/index.js', array(), '', true);
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style('ak-testimonials-admin-style', plugin_dir_url( __DIR__ ).'dist/backend/index.css');
        wp_enqueue_script('ak-testimonials-admin-script', plugin_dir_url( __DIR__ ).'dist/backend/index.js', array(), '', true);
        wp_localize_script( 'ak-testimonials-admin-script', 'wpApiSettings', array(
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' )
        ) );
    }
}