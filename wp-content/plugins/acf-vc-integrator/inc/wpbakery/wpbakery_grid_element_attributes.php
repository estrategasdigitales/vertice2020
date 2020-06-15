<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get ACF data
 *
 * @param $value
 * @param $data
 *
 * @return string
 */
function vc_gitem_template_attribute_acfvc( $value, $data ) {
	$field_key = $label = '';
	$clone_field_key = "";
	/**
	 * @var null|Wp_Post $post ;
	 * @var string $data ;
	 */
	extract( array_merge( array(
		'post' => null,
		'data' => '',
	), $data ) );

	parse_str($data, $atts);
	extract( shortcode_atts( array(
		'el_class' => '',
		'get_field_data_from' => '',
		'field_group' => '',
		'show_label' => '',
		'custom_label' => '',
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
		'file_link_text' => '',
		'file_prepend_text' => '',
		'file_link_target' => '',
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

	/*Check if option page is selected as data source*/
    if ( empty( $get_field_data_from ) OR $get_field_data_from == false) {
		$post_id = $post->ID;
    } else {
        $post_id = $get_field_data_from;
    }

	$output = "";

	            $field_key_array = explode("_field_",$field_key);
	            if ( count($field_key_array) == 1 ) {
	                $field_key = $field_key_array[0];
	            } else {
	                $field_key = $field_key_array[0];
	                $clone_field_key = "field_".$field_key_array[1];
	            }
	        $custom_field = get_field_object($field_key,$post_id);
	            // print_r($field_key2);

	        if ( empty($align) OR $align == "default" ) {
	            $acfvc_option = get_option('acfvc_default');
	            if ( !array_key_exists('align',$acfvc_option['general']) ) {
	                $acfvc_option["general"]["align"] = "left";
	            }
	            $align = $acfvc_option["general"]["align"];
	        }
	        $css_class = 'vc_sw-acf' . ( strlen( $el_class ) ? ' ' . $el_class : '' ) . ( strlen( $align ) ? ' vc_sw-align-' . $align : '' ) . ( strlen( $field_key ) ? ' ' . $field_key : '' );
	        $link_text = ( strlen( $link_text ) ? $link_text : 'Link' );
	        $gallery_options["columns"] = $gallery_columns;
	        $gallery_options["image_size"] = $gallery_image_size;
	        $gallery_options["order_by"] = $gallery_order_by;
	        $gallery_options["order"] = $gallery_order;
	        if (empty($gallery_itemtag_dropdown)) {
	            $gallery_options["itemtag"] = 'default';
	        } else {
	            $gallery_options["itemtag"] = $gallery_itemtag;
	        }
	        if (empty($gallery_itemtag_dropdown)) {
	            $gallery_options["icontag"] = 'default';
	        } else {
	            $gallery_options["icontag"] = $gallery_icontag;
	        }
	        if (empty($gallery_itemtag_dropdown)) {
	            $gallery_options["captiontag"] = 'default';
	        } else {
	            $gallery_options["captiontag"] = $gallery_captiontag;
	        }
	        $gallery_options["link"] = $gallery_link;

			if ( empty( $gm_map_height ) ) {
				$google_map['map_height'] = '400px';
			} else {
				$google_map['map_height'] = $gm_map_height;
			}
			if ( empty( $gm_zoom_level ) ) {
				$google_map['zoom_level'] = '14';
			} else {
				$google_map['zoom_level'] = $gm_zoom_level;
			}
			if ( empty( $gm_show_placecard ) AND !is_numeric( $gm_show_placecard ) ) {
				$google_map['placecard'] = 'default';
			} else {
				$google_map['placecard'] = $gm_show_placecard;
			}
			if ( empty( $gm_map_type_control ) AND !is_numeric( $gm_map_type_control ) ) {
				$google_map['type'] = 'default';
			} else {
				$google_map['type'] = $gm_map_type_control;
			}
			if ( empty( $gm_fullscreen_control ) AND !is_numeric( $gm_fullscreen_control ) ) {
				$google_map['fullscreen'] = 'default';
			} else {
				$google_map['fullscreen'] = $gm_fullscreen_control;
			}
			if ( empty( $gm_street_view_control ) AND !is_numeric( $gm_street_view_control ) ) {
				$google_map['street_view'] = 'default';
			} else {
				$google_map['street_view'] = $gm_street_view_control;
			}
			if ( empty( $gm_zoom_control ) AND !is_numeric( $gm_zoom_control ) ) {
				$google_map['zoom'] = 'default';
			} else {
				$google_map['zoom'] = $gm_zoom_control;
			}
			if ( empty( $gm_scale ) AND !is_numeric( $gm_scale ) ) {
				$google_map['scale'] = 'default';
			} else {
				$google_map['scale'] = $gm_scale;
			}
	
			$args = array (
				"field_key" => $field_key,
				"clone_field_key" => $clone_field_key,
				"acf_version" => $acf_version,
				"link_text" => $link_text,
				'prepend_append' => $prepend_append,
				"gallery_options" => $gallery_options,
				"google_map" => $google_map
	
			);

			if ( $repeater_header ) {
				$args['repeater']['header'] = $repeater_header; 
			}
			
			if ( $file_link_text ) {
				$args['file']['file_link_text'] = $file_link_text; 
			}
			if ( $file_prepend_text ) {
				$args['file']['file_prepend_text'] = $file_prepend_text;
			}
			if ( $file_link_target ) {
				$args['file']['file_link_target'] = $file_link_target;
			}

			$acf_vc_helper = new acf_vc_helper();
	        $output_empty = false;
	        if (empty($custom_field["value"])) {
	            $output_empty = true;
	        } elseif('text' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->text($custom_field, $args, $post_id);
	        } elseif('textarea' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->textarea($custom_field, $args, $post_id);
	        } elseif('wysiwyg' === $custom_field["type"]) {
				$output = $acf_vc_helper->wysiwyg($custom_field, $args, $post_id);
	        } elseif('number' === $custom_field["type"]) {
				$output = $acf_vc_helper->number($custom_field, $args, $post_id);
	        } elseif('email' === $custom_field["type"]) {
		  		$output = $acf_vc_helper->email($custom_field, $args, $post_id);
	        } elseif('password' === $custom_field["type"]) {
				$output = $acf_vc_helper->password($custom_field, $args, $post_id);
	        } elseif('image' === $custom_field["type"]) {
				$output = $acf_vc_helper->image($custom_field, $args, $post_id);
	        } elseif('file' === $custom_field["type"]) {
				$output = $acf_vc_helper->file($custom_field, $args, $post_id);
	        } elseif('checkbox' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->checkbox($custom_field, $args, $post_id);
	        } elseif('radio' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->radio($custom_field, $args, $post_id);
	        } elseif('user' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->user($custom_field, $args, $post_id);
	        } elseif('page_link' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->page_link($custom_field, $args, $post_id);
	        } elseif('google_map' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->google_map($custom_field, $args, $post_id);
	        } elseif('date_picker' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->date_picker($custom_field, $args, $post_id);
	        } elseif('color_picker' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->color_picker($custom_field, $args, $post_id);
	        } elseif('true_false' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->true_false($custom_field, $args, $post_id);
	        } elseif('taxonomy' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->taxonomy($custom_field, $args, $post_id);
	        } elseif('post_object' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->post_object($custom_field, $args, $post_id);
	        } elseif('relationship' === $custom_field["type"]) {
	  			$output = $acf_vc_helper->relationship($custom_field, $args, $post_id);
	        } elseif('url' === $custom_field["type"]) {
		  		$output = $acf_vc_helper->url($custom_field, $args, $post_id);
		    } elseif('link' === $custom_field["type"]) {
		  		$output = $acf_vc_helper->link($custom_field, $args, $post_id);
		    } elseif('select' === $custom_field["type"]) {
		  		$output = $acf_vc_helper->select($custom_field, $args, $post_id);
		    } elseif('oembed' === $custom_field["type"]) {
		  		$output = $acf_vc_helper->oembed($custom_field, $args, $post_id);
		    } elseif('gallery' === $custom_field["type"]) {
		  		$output = $acf_vc_helper->gallery($custom_field, $args, $post_id);
		    } elseif('repeater' === $custom_field["type"]) {
	            $output = $acf_vc_helper->repeater($custom_field,$args,$post_id);
			} else {
				$output_filter = apply_filters( "acf_vc_add_on_fields",$custom_field,$args,$post_id );
	            if ( is_array( $output_filter ) ) {
	                $output = $output_filter["type"]." is not supported";
	            } else {
	                $output = $output_filter;
	            }
	        }

	        if($output == "data-mismatch") {
	            // set the mismatch error message here.
	            $output = 'Data mismatch error. Custom field value doesn\'t match the field type. Please set the field value again.';
	        }
	        if ( $show_label == "default" ) {
	            $acfvc_option = get_option('acfvc_default');
	            $show_label = $acfvc_option["general"]["show_label"];
	        }
	        if ( 'yes' === $show_label OR 'yes_no' === $show_label AND $output_empty === false) {
	            if(!isset($output)) {
	                $output = '<span class="sw-acf-field-label label-'.$field_key.'">'.$custom_field["label"].':</span> '.$custom_field["value"];
	            } else {
	                $output = '<span class="sw-acf-field-label label-'.$field_key.'">'.$custom_field["label"].':</span> '.$output;
	            }
	        } elseif ( 'custom_label' === $show_label OR 'custom_label_yes_no' === $show_label AND $output_empty === false AND !empty( $custom_label ) ) {
				if(!isset($output)) {
					$output = '<span class="sw-acf-field-label label-'.$field_key.'">'.$custom_label.'</span> '.$custom_field["value"];
				} else {
					$output = '<span class="sw-acf-field-label label-'.$field_key.'">'.$custom_label.'</span> '.$output;
				}
			} elseif ( 'yes_no' === $show_label OR 'custom_label_yes_no' === $show_label AND  $output_empty === true) {
				$output = "";
			} else {
	            if(!isset($output) OR empty($output)) $output = $custom_field["value"];
	        }

	        return $output;
}

add_filter( 'vc_gitem_template_attribute_acfvc', 'vc_gitem_template_attribute_acfvc', 10, 2 );
