<?php
if ( ! defined( 'ABSPATH' ) ) exit;

    $data_where_from_array = array();
    $data_where_from_array["This post / page"] = "";

    $pages = "";
    if ( function_exists( 'acf_get_options_pages' ) ) {
        $pages = acf_get_options_pages();
    }

    if( !empty($pages) ) {
        foreach( $pages as $page ) {
            $data_where_from_array[ $page['menu_title'] ] = $page['post_id'];
        }
    } else {
        $data_where_from_array[__('No options pages exist', 'acf')] = "";
    }

$groups = function_exists( 'acf_get_field_groups' ) ? acf_get_field_groups() : apply_filters( 'acf/get_field_groups', array() );

$groups_param_values = $fields_params = array();
if (is_array( $groups )) {
    foreach ( $groups as $group ) {
        $flg = 1;

        $id = isset( $group['id'] ) ? 'id' : ( isset( $group['ID'] ) ? 'ID' : 'id' );
        $groups_param_values[ $group['title'] ] = $group[ $id ];
        $fields = function_exists( 'acf_get_fields' ) ? acf_get_fields( $group[ $id ] ) : apply_filters( 'acf/field_group/get_fields', array(), $group[ $id ] );
  $fields_param_value = array();
  if ($fields != false) :
        foreach ( $fields as $field ) {
            $fields_param_value[ $field['label'] ] = (string) $field['key'];
        }
  endif;
        $fields_params[] = array(
            'type' => 'dropdown',
            'heading' => __( 'Field name', 'acf-vc-integrator' ),
            'param_name' => 'field_from_' . $group[ $id ],
            'value' => $fields_param_value,
            'save_always' => true,
            'description' => __( 'Select field from group.', 'acf-vc-integrator' ),
            'dependency' => array(
                'element' => 'field_group',
                'value' => array( (string) $group[ $id ] ),
            )
        );

    }
}
$wp_image_sizes = get_intermediate_image_sizes();
$wp_image_sizes_array = array();
$wp_image_sizes_array["Default"] = "";
foreach ($wp_image_sizes as $key => $value) {
    $wp_image_sizes_array[$value] = $value;
}

wp_enqueue_style( 'acf-vc-integrator-style', ACFVC_URL.'css/acf-vc-integrator-style.css');
include_once(ACFVC_PATH.'inc/acf_vc_helper.php');
include_once(ACFVC_PATH.'inc/acf_vc_helper_pro.php');

return array(
    'acf_vc_grid' => array(
        'name' => __( 'ACF-VC Integrator', 'acf-vc-integrator' ),
        'base' => 'acf_vc_grid',
        'icon' => ACFVC_URL."images/acf_icon1.png",
        'category' => __( 'Content', 'acf-vc-integrator' ),
        'description' => __( 'Advanced Custom Field - Visual Composer Integrator', 'acf-vc-integrator' ),
        'php_class_name' => 'Acf_vc_integrator_grid_Shortcode',
        'admin_enqueue_css' => array( ACFVC_URL.'css/acf-vc-integrator-style.css' ),
        'params' => array_merge(
            array(
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Get field data from', 'acf-vc-integrator' ),
                    'param_name' => 'get_field_data_from',
                    'admin_label' => true,
                    'value' => $data_where_from_array,
                    'save_always' => true,
                    'description' => __( 'Choose where from the field retrieve data from.', 'acf-vc-integrator' ),
                ),
            ),
            array(
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Field group', 'acf-vc-integrator' ),
                    'param_name' => 'field_group',
                    'admin_label' => true,
                    'value' => $groups_param_values,
                    'save_always' => true,
                    'description' => __( 'Select field group.', 'acf-vc-integrator' ),
                ),
            ),
            $fields_params,
            array(
                array(
                    'type' => 'acfvc_wpbakery_hidden_field_name',
                    'heading' => __( 'Field name', 'acf-vc-integrator' ),
                    'param_name' => 'hidden_field_name',
                    'admin_label' => true,
                ),
            ),
            array(
                array(
                    'type' => 'css_editor',
                    'heading' => __( 'Css', 'acf-vc-integrator' ),
                    'param_name' => 'css',
                    'group' => __( 'Design options', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Show label', 'acf-vc-integrator' ),
                    'param_name' => 'show_label',
                    'value' => array(
                        "Default" => "default",
                        __( 'No', 'acf-vc-integrator' ) => 'No',
                        __( 'Yes', 'acf-vc-integrator' ) => 'yes',
                        __( 'Yes and hide if no result', 'acf-vc-integrator' ) => 'yes_no',
                        __( 'Custom label' ) => 'custom_label',
                        __( 'Custom label and hide if no result' ) => 'custom_label_yes_no'
                    ),
                    'save_always' => true,
                    'description' => __( 'Enter label to display before key value.', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Custom label', 'acf-vc-integrator' ),
                    'param_name' => 'custom_label',
                    'dependency'=>array(
                                        'element'=>'show_label',
                                        'value'=>array( 'custom_label', 'custom_label_yes_no' ),
                                        'not_empty'=>false
                                ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Align', 'acf-vc-integrator' ),
                    'param_name' => 'align',
                    'value' => array(
                        "Default" => "default",
                        __( 'left', 'acf-vc-integrator' ) => 'left',
                        __( 'right', 'acf-vc-integrator' ) => 'right',
                        __( 'center', 'acf-vc-integrator' ) => 'center',
                        __( 'justify', 'acf-vc-integrator' ) => 'justify',
                    ),
                    'save_always' => true,
                    'description' => __( 'Select alignment.', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Extra class name', 'acf-vc-integrator' ),
                    'param_name' => 'el_class',
                    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'acf-vc-integrator' ),
                ),
                array(
                    "type" => 'checkbox',
                    "class" => '',
                    "heading" => __( 'Show prepend/append', 'acf-vc-integrator' ),
                    "param_name" => 'prepend_append',
                    "value" => array( 'Prepend' => 'prepend', 'Append' => 'append' ),
                    "description" => __( 'Applicable only for text, number, range, email and password fields.', 'acf-vc-integrator' )
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Custom Link Text', 'acf-vc-integrator' ),
                    'param_name' => 'link_text',
                    'description' => __( 'Applicable only for File Objects and Page Links', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Repeater header', 'acf-vc-integrator' ),
                    'param_name' => 'repeater_header',
                    'value' => array(
                        "Default" => "",
                        "Hide header" => "hide",
                        "Show header" => "show",
                    ),
                    'description' => __( 'Display a row with field labels', 'acf-vc-integrator' ),
                    'group' => __( 'Repeater', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Columns', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_columns',
                    'value' => array(
                        "Default" => "",
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                        6 => 6,
                        7 => 7,
                        8 => 8,
                        9 => 9,
                    ),
                    'description' => __( 'Select number of columns.', 'acf-vc-integrator' ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Image size', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_image_size',
                    'value' => $wp_image_sizes_array,
                    'description' => __( 'Select a iamge size.', 'acf-vc-integrator' ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Order by', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_order_by',
                    'value' => array(
                        "Default" => "",
                        "ID" => "ID",
                        "Menu order" => "menu_order",
                        "Title" => "title",
                        "Post date" => "post_date",
                        "Random" => "rand",
                    ),
                    'description' => __( 'Order image by', 'acf-vc-integrator' ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Order', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_order',
                    'value' => array(
                        "Default" => "",
                        "ASC" => "ASC",
                        "DESC" => "DESC",
                    ),
                    'description' => __( 'Order image', 'acf-vc-integrator' ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Itemtag', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_itemtag_dropdown',
                    'value' => array(
                        "Default" => "",
                        "Custom" => "custom",
                    ),
                    'description' => __( 'The name of the XHTML tag used to enclose each item in the gallery.', 'acf-vc-integrator' ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Custom itemtag', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_itemtag',
                    'dependency'=>array(
                        'element'=>'gallery_itemtag_dropdown',
                        'value'=>array('custom'),
                    ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Icontag', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_icontag_dropdown',
                    'value' => array(
                        "Default" => "",
                        "Custom" => "custom",
                    ),
                    'description' => __( 'The name of the XHTML tag used to enclose each thumbnail icon in the gallery.', 'acf-vc-integrator' ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Custom icontag', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_icontag',
                    'dependency'=>array(
                        'element'=>'gallery_icontag_dropdown',
                        'value'=>array('custom'),
                    ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Captiontag', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_captiontag_dropdown',
                    'value' => array(
                        "Default" => "",
                        "Custom" => "custom",
                    ),
                    'description' => __( 'The name of the XHTML tag used to enclose each caption.', 'acf-vc-integrator' ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Custom captiontag', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_captiontag',
                    'dependency'=>array(
                        'element'=>'gallery_captiontag_dropdown',
                        'value'=>array('custom'),
                    ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Link', 'acf-vc-integrator' ),
                    'param_name' => 'gallery_link',
                    'value' => array(
                        "Default" => "",
                        "None" => "none",
                        "File" => "file",
                    ),
                    'description' => __( 'Specify where you want the image to link.', 'acf-vc-integrator' ),
                    'group' => __( 'Gallery field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Prepend text', 'acf-vc-integrator' ),
                    'param_name' => 'file_prepend_text',
                    'group' => __( 'File field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Link text', 'acf-vc-integrator' ),
                    'param_name' => 'file_link_text',
                    'value' => array(
                        "Custom link text" => "custom_link_text",
                        "Title" => "title",
                        "Filename" => "filename",
                    ),
                    'description' => __( 'Applicable only for File Objects. The custom link text field is found under the General tab', 'acf-vc-integrator' ),
                    'group' => __( 'File field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Link target', 'acf-vc-integrator' ),
                    'param_name' => 'file_link_target',
                    'value' => array(
                        "_self" => "_self",
                        "_blank" => "_blank",
                    ),
                    'group' => __( 'File field', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Map height', 'acf-vc-integrator' ),
                    'param_name' => 'gm_map_height',
                    'value' => '400px',
                    'group' => __( 'Google map', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Zoom level', 'acf-vc-integrator' ),
                    'param_name' => 'gm_zoom_level',
                    'value' => '',
                    'group' => __( 'Google map', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Display placecard', 'acf-vc-integrator' ),
                    'param_name' => 'gm_show_placecard',
                    'value' => array(
                        "Default" => "default",
                        "No" => 0,
                        "Yes" => 1,
                    ),
                    'save_always' => true,
                    'group' => __( 'Google map', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Display map type control', 'acf-vc-integrator' ),
                    'param_name' => 'gm_map_type_control',
                    'value' => array(
                        "Default" => "default",
                        "No" => 0,
                        "Yes" => 1,
                    ),
                    'save_always' => true,
                    'group' => __( 'Google map', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Display fullscreen control', 'acf-vc-integrator' ),
                    'param_name' => 'gm_fullscreen_control',
                    'value' => array(
                        "Default" => "default",
                        "No" => 0,
                        "Yes" => 1,
                    ),
                    'save_always' => true,
                    'group' => __( 'Google map', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Display street view control', 'acf-vc-integrator' ),
                    'param_name' => 'gm_street_view_control',
                    'value' => array(
                        "Default" => "default",
                        "No" => 0,
                        "Yes" => 1,
                    ),
                    'save_always' => true,
                    'group' => __( 'Google map', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Display zoom control', 'acf-vc-integrator' ),
                    'param_name' => 'gm_zoom_control',
                    'value' => array(
                        "Default" => "default",
                        "No" => 0,
                        "Yes" => 1,
                    ),
                    'save_always' => true,
                    'group' => __( 'Google map', 'acf-vc-integrator' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Display scale', 'acf-vc-integrator' ),
                    'param_name' => 'gm_scale',
                    'value' => array(
                        "Default" => "default",
                        "No" => 0,
                        "Yes" => 1,
                    ),
                    'save_always' => true,
                    'group' => __( 'Google map', 'acf-vc-integrator' ),
                ),
            )
        ),
        'post_type' => Vc_Grid_Item_Editor::postType(),
    ),
);

 ?>
