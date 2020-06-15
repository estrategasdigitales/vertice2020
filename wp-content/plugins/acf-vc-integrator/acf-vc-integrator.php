<?php
/*
Plugin Name: ACF-VC Integrator
Plugin URI:https://wordpress.org/plugins/acf-vc-integrator/
Description: ACF VC Integrator plugin is the easiest way to output your Advanced Custom Posttype fields in a WPBakery Page Builder (Visual Composer) Grid.
Author: Frederik Rosendahl-Kaa
Version: 1.8.1
Author URI: https://frederikrosendahlkaa.dk/
Text Domain: acf-vc-integrator
Domain Path: /languages
*/
?>
<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function avi_uninstall_cleanup () {
	if (get_option('acfvc_default')) {
		delete_option('acfvc_default');
	}
	if (get_option('acfvc_version')) {
		delete_option('acfvc_version');
	}
}

function acfvc_add_default_options() {
	$value = Array (
		"general" => Array (
				"show_label" => "",
				"align" => "left",
				"date_format" => "wp_default",
				"date_time_format" => "wp_default",
				"time_format" => "wp_default",
			),
			"gallery" => Array (
					"columns" => 3,
					"image_size" => "thumbnail",
					"order_by" => "ID",
					"order" => "ASC",
					"itemtag" => "",
					"icontag" => "",
					"captiontag" => "",
					"link" => "none",
				),
			"gooogle_map" => Array (
					"placecard" => 1,
					"zoom" => 1,
					"type" => 1,
					"fullscreen" => 0,
					"street_view" => 0,
					"scale" => 0
				),
	);
	if (!get_option('acfvc_default')) {
		add_option( "acfvc_default", $value );
	}
}
function acfvc_add_version_number() {
	if (!get_option('acfvc_version')) {
		add_option( "acfvc_version", "1.8.1" );
	} else {
		if (get_option('acfvc_version') != "1.8.1") {
			update_option( "acfvc_version", "1.8.1" );
		}
	}
}

function acfvc_plugin_activate() {
	acfvc_add_default_options();
	acfvc_add_version_number();

	register_uninstall_hook( __FILE__, 'avi_uninstall_cleanup' );
}
register_activation_hook( __FILE__, 'acfvc_plugin_activate' );

if ( !defined('ACFVC_PATH') ) {
	define('ACFVC_PATH', plugin_dir_path( __FILE__ ));
}
if ( !defined('ACFVC_URL') ) {
	define('ACFVC_URL', plugin_dir_url( __FILE__ ));
}

function acf_vc_load_plugin_textdomain() {
    load_plugin_textdomain( 'acf-vc-integrator', FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'acf_vc_load_plugin_textdomain' );

function acf_vc_integrator_check_for_dependancy() {
	function acf_vc_integrator_showMessage($message, $msgn = 'success', $isDismissible = false)
	{
		if ($msgn == "error") {
			echo '<div class="notice notice-error '.$isDismissible.'">';
		} elseif ($msgn == "info") {
			echo '<div class="notice notice-info '.$isDismissible.'">';
		}	else {
			echo '<div class="notice notice-success '.$isDismissible.'">';
		}
		echo "<p><strong>$message</strong></p></div>";
	}

	function acf_vc_integrator_showAdminMessages() {
		if ( !class_exists('Vc_Manager') and  !is_plugin_active( 'advanced-custom-fields/acf.php' ) AND !is_plugin_active( 'advanced-custom-fields-pro/acf.php' )) {
			acf_vc_integrator_showMessage("ACF-VC Integrator require both WPBakery Page Builder and Advanced Custom Fields plugins installed and activated.", "error");
		} elseif ( !class_exists('Vc_Manager') ) {
			acf_vc_integrator_showMessage("ACF-VC Integrator require WPBakery Page Builder plugin installed and activated.", "error");
		} elseif ( !is_plugin_active( 'advanced-custom-fields/acf.php' ) AND !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
			acf_vc_integrator_showMessage("ACF-VC Integrator require Advanced Custom Fields or Advanced Custom Fields Pro plugin installed and activated.", "error");
		}
		if(is_plugin_active( 'advanced-custom-fields-pro/acf.php' )) {
			$screen = get_current_screen();
			if( $screen->parent_base === "acf-vc-integrator" ) {
			  // acf_vc_integrator_showMessage("ACF-VC Integrator version 1.2 supports the Repeater field in ACF-Pro, as well as fields also found in ACF.", "info");
			} elseif($screen->parent_base === "plugins") {
			  // acf_vc_integrator_showMessage("ACF-VC Integrator version 1.2 supports the Repeater field in ACF-Pro, as well as fields also found in ACF.", "info", "is-dismissible");
			}
		}
	}
	add_action('admin_notices', 'acf_vc_integrator_showAdminMessages');
}

//Check for ACF and VC plugins
add_action('admin_init', 'acf_vc_integrator_check_for_dependancy');

//Get acf OR acf pro version number
function get_acf_version_number() {
	if ( defined('ACF_VERSION') ) {
		return ACF_VERSION;
	}	else {
		return NULL;
	}
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'acfvc_add_action_links' );
function acfvc_add_action_links ( $links ) {
	$settings_link = '<a href="options-general.php?page=acf-vc-integrator">' . __( 'Settings' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}

function acf_vc_load_custom_wp_admin_style($hook) {
        if($hook != 'settings_page_acf-vc-integrator') {
                return;
        }
        wp_enqueue_style( 'acf_vc_admin_style', plugins_url('css/admin-style.css', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'acf_vc_load_custom_wp_admin_style' );

function acf_vc_integrator_admin_actions() {
	add_options_page("ACF-VC Integrator", "ACF-VC Integrator", "manage_options", "acf-vc-integrator", "acf_vc_integrator_admin");
}
add_action('admin_menu', 'acf_vc_integrator_admin_actions');
require_once dirname(__FILE__).'/admin/acf-vc-integrator-admin.php';

/*include wpbakery element*/
// include_once 'inc/wpbakery/wpbakery_element.php';
add_action( 'vc_before_init', 'acf_vc_integrator_elem' );
function acf_vc_integrator_elem() {
	if ( class_exists('Vc_Manager') ) {

		function acfvc_wpbakery_hidden_field_name_callback( $settings, $value ) {
			return '<input name="' . $settings['param_name'] . '" class="wpb_vc_param_value acfvc_hidden-field vc_hidden-field vc_param-name-' . $settings['param_name'] . ' ' . $settings['type'] . '" type="hidden" value=""/>';
		}
		function vc_edit_form_fields_render_field_acfvc_wpbakery_hidden_field_name_before( $output ) {
			return '<div class="vc_column vc_edit-form-hidden-field-wrapper">';
		}
		function vc_edit_form_fields_render_field_acfvc_wpbakery_hidden_field_name_after( $output ) {
			return '</div>';
		}

		vc_add_shortcode_param( 'acfvc_wpbakery_hidden_field_name', 'acfvc_wpbakery_hidden_field_name_callback', ACFVC_URL.'inc/wpbakery/acfvc_hidden_field.js' );
		add_filter( 'vc_edit_form_fields_render_field_acfvc_wpbakery_hidden_field_name_before', 'vc_edit_form_fields_render_field_acfvc_wpbakery_hidden_field_name_before' );
		add_filter( 'vc_edit_form_fields_render_field_acfvc_wpbakery_hidden_field_name_after', 'vc_edit_form_fields_render_field_acfvc_wpbakery_hidden_field_name_after' );

		require_once dirname(__FILE__).'/inc/wpbakery/wpbakery_element_shortcode.php';
		vc_lean_map('acf_vc_integrator', null, dirname(__FILE__).'/inc/wpbakery/wpbakery_element.php');

		add_filter( 'vc_grid_item_shortcodes','mapacfvcGridItemShortcodes',10,1);
		function mapacfvcGridItemShortcodes( array $shortcodes ) {
			require_once dirname(__FILE__).'/inc/wpbakery/wpbakery_grid_element_shortcode.php';
			require_once dirname(__FILE__).'/inc/wpbakery/wpbakery_grid_element_attributes.php';

			$wc_shortcodes = include dirname(__FILE__).'/inc/wpbakery/wpbakery_grid_element.php';

			return $shortcodes + $wc_shortcodes;
		}
	}
}
?>
