<?php
/**
* Plugin Name: Web Domain Checker
* Description: This plugin allows create Web Domain Checker plugin.
* Version: 1.0.1
* Copyright: 2020
* Text Domain: web-domain-checker
* Domain Path: /languages 
*/


if (!defined('ABSPATH')) {
  die('-1');
}
if (!defined('OCWDC_PLUGIN_NAME')) {
  define('OCWDC_PLUGIN_NAME', 'Web Domain checker');
}
if (!defined('OCWDC_PLUGIN_VERSION')) {
  define('OCWDC_PLUGIN_VERSION', '2.0.0');
}
if (!defined('OCWDC_PLUGIN_FILE')) {
  define('OCWDC_PLUGIN_FILE', __FILE__);
}
if (!defined('OCWDC_PLUGIN_DIR')) {
  define('OCWDC_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('OCWDC_BASE_NAME')) {
    define('OCWDC_BASE_NAME', plugin_basename(OCWDC_PLUGIN_FILE));
}
if (!defined('OCWDC_DOMAIN')) {
  define('OCWDC_DOMAIN', 'web-domain-checker');
}

if (!class_exists('OCWDC')) {

  	class OCWDC {
      protected static $OCWDC_instance;
  
      function includes() {
        include_once('front/ocwdc_domain_availability.php');
		    include_once('admin/ocwdc_admin.php');
        include_once('front/ocwdc_front.php');
      }


      function init() {
        add_action( 'wp_enqueue_scripts', array($this,'OCWDC_enqueue_custom_script'));
        add_action('admin_enqueue_scripts', array($this, 'OCWDC_load_admin_script_style'));
        add_filter( 'plugin_row_meta', array( $this, 'OCWDC_plugin_row_meta' ), 10, 2 );
      }


      function OCWDC_load_admin_script_style() {
        wp_enqueue_style( 'OCWDC_admin_css', OCWDC_PLUGIN_DIR . '/includes/css/back_style.css', false, '1.0.0' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker-alpha', OCWDC_PLUGIN_DIR . '/includes/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true );
        wp_enqueue_script( 'OCWDC_admin_script', OCWDC_PLUGIN_DIR.'/includes/js/ocwdc_admin.js');
      }


      function OCWDC_enqueue_custom_script() {
        $ocwdc_srchreset_font_size = '18px';
        $ocwdc_domain_ext_req_bg_color = '#8a0e0e';
        $ocwdc_domain_ext_req_color = '#ffffff';
        $ocwdc_domain_empty_text = 'Please enter domain name.';

        wp_enqueue_script( 'OCWDC_front_script', OCWDC_PLUGIN_DIR.'/includes/js/ocwdc_front.js');
        wp_enqueue_style( 'OCWDC_admin_css', OCWDC_PLUGIN_DIR . '/includes/css/front_style.css', false, '1.0.0' );
        wp_localize_script( 'OCWDC_front_script', 'ocwdc_ajax', array(
	        'ajaxurl'       => admin_url( 'admin-ajax.php' ),
	        'ocwdc_nonce'   => wp_create_nonce( 'ocwdc_nonce' ))
	      );
        wp_localize_script( 'OCWDC_front_script', 'ocwdc_options', array( 'ocwdc_srchreset_font_size' => $ocwdc_srchreset_font_size, 'ocwdc_domain_ext_req_bg_color' => $ocwdc_domain_ext_req_bg_color, 'ocwdc_domain_ext_req_color' => $ocwdc_domain_ext_req_color, 'ocwdc_domain_empty_text' => $ocwdc_domain_empty_text ));
      }


      function OCWDC_plugin_row_meta( $links, $file ) {
        if ( OCWDC_BASE_NAME === $file ) {
          $row_meta = array(
            'rating'    =>  '<a href="https://oceanwebguru.com/web-domain-checker/" target="_blank">Documentation</a> | <a href="https://oceanwebguru.com/contact-us/" target="_blank">Support</a> | <a href="https://wordpress.org/support/plugin/web-domain-checker/reviews/?filter=5#new-post" target="_blank"><img src="'.OCWDC_PLUGIN_DIR.'/includes/images/star.png" class="ocwdc_rating_div"></a>',
          );
          return array_merge( $links, $row_meta );
        }
        return (array) $links;
      }


      //Plugin Rating
      public static function do_activation() {
		    set_transient('ocgfrs-first-rating', true, MONTH_IN_SECONDS);
      }


      public static function OCWDC_instance() {
        if (!isset(self::$OCWDC_instance)) {
          self::$OCWDC_instance = new self();
          self::$OCWDC_instance->init();
          self::$OCWDC_instance->includes();
        }
        return self::$OCWDC_instance;
      }
  	}

  	add_action('plugins_loaded', array('OCWDC', 'OCWDC_instance'));
    register_activation_hook(OCWDC_PLUGIN_FILE, array('OCWDC', 'do_activation'));
}


add_action( 'plugins_loaded', 'OCWDC_load_textdomain' );
 
function OCWDC_load_textdomain() {
    load_plugin_textdomain( 'web-domain-checker', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

function OCWDC_load_my_own_textdomain( $mofile, $domain ) {
    if ( 'web-domain-checker' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'OCWDC_load_my_own_textdomain', 10, 2 );
