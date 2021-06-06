<?php

class AK_Testimonials_Frontend {
    public function __construct() {}
    public static function render() {
        $data = get_option('abhinash_testimonials_collection');
        $output = (array) json_decode($data)->data;
        
        // Brace yourselves for sphagetti.

        echo '<div id="ak-testimonial-slider" class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">';

        foreach ($output as $item) {
            echo '<li class="glide__slide">';
                echo '<div class="slide-body">';
                    echo '<div class="slide-stars">';
                        for($i = 0; $i<$item->rating; $i++) {
                            echo '<i class="dashicons dashicons-star-filled"></i>';
                        }
                    echo '</div>';
                    echo '<div class="slide-testimonial">';
                        echo $item->review;
                    echo '</div>';
                    echo '<div class="platform-img">';
                    echo '<div class="slide-logo-container" id="'.$item->platform.'"><span>'.$item->platform.'</span></div>';
                    echo '</div>';
                    echo '<div class="testimonial-date">';
                        echo date('F Y', strtotime($item->date));
                    echo '</div>';
                echo '</div>';
            echo '</li>';
        }
        
        
        echo "</ul></div>";

        echo '<div class="glide__bullets" data-glide-el="controls[nav]">';
        foreach ($output as $key=>$value) {
            echo '<button class="glide__bullet" data-glide-dir="='.$key.'"></button>';
        }
        echo '</div>';

        echo '</div>';
    }
}