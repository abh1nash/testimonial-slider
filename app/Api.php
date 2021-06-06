<?php

class AK_Testimonials_API extends WP_REST_Controller {
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }
    public function register_routes() {
        register_rest_route(
            'abhinash/testimonials-slider',
            '/api',
            [
                [
                'methods'=>'POST',
                'callback'=>[$this, 'set_testimonials'],
                'permission_callback'=>[$this, 'authenticate_user']
                ],
                [
                'methods'=>'GET',
                'callback'=>[$this, 'get_testimonials'],
                'permission_callback'=>[$this, 'permission']
                ]
           ]
        );
    }
    public function get_testimonials($request) {
        $result = get_option('abhinash_testimonials_collection');
        return rest_ensure_response($result ? json_encode($result) : [] );
    }
    public function set_testimonials($request) {
        $result = update_option('abhinash_testimonials_collection', $request->get_body());
        return rest_ensure_response($request->get_body());
    }
    public function permission() {
        return true;
    }
    public function authenticate_user() {
        return current_user_can('publish_posts');
    }
}