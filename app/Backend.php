<?php
 class AK_Testimonials_Backend {
     public function __construct() {
         add_action('admin_menu', [$this, 'add_item_to_menu']);
     }

     public function add_item_to_menu() {
        add_menu_page(
            'Testimonials Slider',
            'Cigno Testimonials',
            'manage_options',
            'ak-testimonials',
            array($this, 'render'),
            'dashicons-format-chat' //icon
        );
     }

     public function render() {
         echo "<div class='wrap' id='app'></div>";
     }
 }