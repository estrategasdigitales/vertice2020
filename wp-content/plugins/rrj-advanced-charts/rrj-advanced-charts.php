<?php
/**
 * Advanced Charts for WPBackery Page Builder
 *
 * Plugin Name:     Advanced Charts for WPBackery Page Builder
 * Description:     Advanced chart elements for WPBackery Page Builder
 * Version:         1.5.3.1
 * Author:          wprj
 * Plugin URI:		https://codecanyon.net/item/advanced-charts-addon-for-visual-composer/19237508	
 * Text Domain:     rrj-ac
 * Domain Path:     /languages
 * License:         -
 * License URI:     -
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) die;

if ( defined( 'RRJ_AC_PATH' ) ) return;

define( 'RRJ_AC_PATH', plugin_dir_path( __FILE__ ) );
define( 'RRJ_AC_URL', plugin_dir_url( __FILE__ ) );
define( 'RRJ_AC_VERSION', '1.5.3.1' );
define( 'RRJ_AC_METAINIT', '_rrjac_init' );

// load helper functions
require_once RRJ_AC_PATH . 'includes/functions.php';

// load the color calculation class
require_once RRJ_AC_PATH . 'includes/colors.class.php';

// load the main class
require_once RRJ_AC_PATH . 'includes/charts.class.php';
