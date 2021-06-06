<?php
/**
 * Plugin Name:       Testimonials Slider
 * Plugin URI:        https://abhinash.net/
 * Description:       Add testimonials slider.
 * Version:           1.0.0
 * Requires at least: 5.3
 * Author:            Abhinash Khatiwada
 * Author URI:        https://abhinash.net/
 * Text Domain:       abhinash-ts-slider
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/abh1nash/testimonial-slider
 */

if ( !defined( 'ABSPATH' ) ) exit;

final class Testimonials_Plugin {
    public $version = "1.0.0";
    public $container = [];

    public function __construct() {
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

     public function activate() {
         $is_installed = get_option('abhinash_testimonials_installed');
         
         if(!$is_installed) {
             update_option('abhinash_testimonials_installed', true);
            }
        
        update_option('abhinash_testimonials_version', $this->version);
     }

     public function deactivate() {

     }

     public function init_plugin() {
         require_once dirname(__FILE__) . '/app/Backend.php';
         require_once dirname(__FILE__) . '/app/Frontend.php';
         require_once dirname(__FILE__) . '/app/Assets.php';
         require_once dirname(__FILE__) . '/app/Api.php';

         $frontend = new AK_Testimonials_Frontend();
         $backend = new AK_Testimonials_Backend();
         $assets = new AK_Testimonials_Assets();
         $api = new AK_Testimonials_API();

         add_shortcode('testimonials_slider', [$frontend, 'render']);
     }
}

$testimonials_plugin = new Testimonials_Plugin();