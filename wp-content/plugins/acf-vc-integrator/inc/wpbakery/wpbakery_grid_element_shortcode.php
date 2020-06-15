<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class Acf_vc_integrator_grid_Shortcode extends WPBakeryShortCode {
    /**
     * @param $atts
     * @param null $content
     *
     * @return mixed|void
     */
    protected function content( $atts, $content = null ) {
        $field_key = $label = '';
        $clone_field_key = "";
        /**
         * @var string $el_class
         * @var string $show_label
         * @var string $align
         * @var string $get_field_data_from
         * @var string $field_group
         * @var string $link_text
         * @var string $prepend_append
         * @var string $repeater_header
         * @var string $gallery_columns
         * @var string $gallery_image_size
         * @var string $gallery_order_by
         * @var string $gallery_order
         * @var string $gallery_itemtag_dropdown
         * @var string $gallery_itemtag
         * @var string $gallery_icontag_dropdown
         * @var string $gallery_icontag
         * @var string $gallery_captiontag_dropdown
         * @var string $gallery_captiontag
         * @var string $gallery_link
         * @var string $file_link_text
         * @var string $file_prepend_text
         * @var string $file_link_traget
         * @var string $gm_show_placecard
         * @var string $gm_map_type_control
         * @var string $gm_fullscreen_control
         * @var string $gm_street_view_control
         * @var string $gm_zoom_control
         * @var string $gm_scale
         * @var string $gm_map_height
         * @var string $gm_zoom_level
         */
        extract( shortcode_atts( array(
            'el_class' => '',
            'get_field_data_from' => '',
            'field_group' => '',
            'show_label' => '',
            'align' => '',
            'link_text' => '',
            'prepend_append' => '',
            'repeater_header' => '',
            'gallery_columns' => '',
            'gallery_image_size' => '',
            'gallery_order_by' => '',
            'gallery_order' => '',
            'gallery_itemtag_dropdown' => '',
            'gallery_itemtag' => '',
            'gallery_icontag_dropdown' => '',
            'gallery_icontag' => '',
            'gallery_captiontag_dropdown' => '',
            'gallery_captiontag' => '',
            'gallery_link' => '',
            'gm_show_placecard' => '',
            'gm_map_type_control' => '',
            'gm_fullscreen_control' => '',
            'gm_street_view_control' => '',
            'gm_zoom_control' => '',
            'gm_scale' => '',
            'gm_map_height' => '',
            'gm_zoom_level' => '',
        ), $atts ) );

$acf_version = get_acf_version_number();

if (!get_option('acfvc_default')) {
    acfvc_add_default_options();
}

if ( 0 === strlen( $field_group ) ) {
            $groups = function_exists( 'acf_get_field_groups' ) ? acf_get_field_groups() : apply_filters( 'acf/get_field_groups', array() );
            if ( is_array( $groups ) && isset( $groups[0] ) ) {
                $key = isset( $groups[0]['id'] ) ? 'id' : ( isset( $groups[0]['ID'] ) ? 'ID' : 'id' );
                $field_group = $groups[0][ $key ];
            }
        }
        if ( ! empty( $field_group ) ) {
            $field_key = ! empty( $atts[ 'field_from_' . $field_group ] ) ? $atts[ 'field_from_' . $field_group ] : 'field_from_group_' . $field_group;
        }

        $css_class = 'vc_sw-acf' . ( strlen( $el_class ) ? ' ' . $el_class : '' ) . ( strlen( $align ) ? ' vc_sw-align-' . $align : '' ) . ( strlen( $field_key ) ? ' ' . $field_key : '' );

        $css = '';
        extract(shortcode_atts(array(
            'css' => ''
        ), $atts));
        $css_class_vc = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        $field = get_field_object($field_key, false, false, false);
               return '<div id="' . $field_key . '" class="type-'.$field["type"].' ' . esc_attr( $css_class_vc ) . ' ' . esc_attr( $css_class ) . '">'
       		       . '{{ acfvc:' .  http_build_query( (array) $atts ) . ' }}'
       		       . '</div>';
    }
}

 ?>
