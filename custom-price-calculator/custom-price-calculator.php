<?php

/**

 * custom-price-calculator

 *

 * Plugin Name: Coffee Custom Price Calculator 

 * Description: Enables the WordPress to Calculate Custom Price Calculator

 * Version:     1.0

 * Author:      full stack developer  

 * Text Domain: coffee-custom-price-calculator

 * Domain Path: /languages

 */
if ( ! defined( 'ABSPATH' ) ) {

	die( 'Invalid request.' );

}
 

add_action( 'plugins_loaded', 'coffee_custom_price_calculator_init' );
function coffee_custom_price_calculator_init() {
    load_plugin_textdomain( 'coffee-custom-price-calculator', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
 
    if ( ! class_exists( 'CCP_Calculator' ) ) :

        define( 'CCPC_MAIN_FILE', __FILE__ );

        define( 'CCPC_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

        define( 'CCPC_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

        class CCP_Calculator {
            /**
             * @var CCP_Calculator The reference the *CCP_Calculator* instance of this class
             */
            private static $instance;

            /**
             * Returns the *CCP_Calculator* instance of this class.
             *
             * @return CCP_Calculator The *CCP_Calculator* instance.
             */
            public static function get_instance() {
                if ( null === self::$instance ) {
                    self::$instance = new self();
                }
                return self::$instance;
            }

            /**
             * Private clone method to prevent cloning of the instance of the
             * *CCP_Calculator* instance.
             *
             * @return void
             */
            private function __clone() {}

            /**
             * Private unserialize method to prevent unserializing of the *CCP_Calculator*
             * instance.
             *
             * @return void
             */
            private function __wakeup() {}

            /**
             * Protected constructor to prevent creating a new instance of the
             * *CCP_Calculator* via the `new` operator from outside of this class.
             */
            private function __construct() {
                $this->init();
            }

            /**
             * Init the plugin after plugins_loaded so environment variables are set.
             *
             * @since 1.0.0
             * @version 1.0.0
             */
            public function init() {
                if ( is_admin() ) {
                     //admin 
                    require_once dirname( __FILE__ ) . '/includes/admin/class-ccpc-admin.php';
                }
                //helpers 
                require_once dirname( __FILE__ ) . '/includes/class-ccpc-helper.php';
                
                //ccpc base classes 
                require_once dirname( __FILE__ ) . '/includes/class-ccpc-base.php'; 

                //Ajax class
                require_once dirname( __FILE__ ) . '/includes/class-ccpc-ajax.php'; 
                
            }

        }
        CCP_Calculator::get_instance();
    endif;
} 