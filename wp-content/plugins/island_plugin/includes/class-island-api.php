<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Island_Api_Wp {

    public function __construct() {
        $this->load_dependencies();
        $this->define_api_routes();
    }

    private function load_dependencies() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/api-route-functions.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/island-functions.php';
    }

    private function define_api_routes() {
        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/get-island-users/';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_island_users',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/get-island-user/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_island_user',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/edit-island-user/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'edit_island_user',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/add-island-user/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'add_island_user',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/delete-island-user/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'DELETE',
                'callback' => 'delete_island_user',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/get-island-items/';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_island_items',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/get-island-item/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_island_item',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/add-island-item/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'add_island_item',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/delete-island-item/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'DELETE',
                'callback' => 'delete_island_item',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/add-island-lot/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'add_island_lot',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/get-island-available-lots/';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_island_available_lots',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/get-island-own-lots/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_island_own_lots',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/get-island-consumer-lots/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_island_consumer_lots',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/accept-public-island-lot/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'accept_public_island_lot',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'island/v1';
            $rout = '/accept-private-island-lot/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'accept_private_island_lot',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

    }
}
