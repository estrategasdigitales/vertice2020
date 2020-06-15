<?php
if ( ! class_exists( 'acf_vc_helper' ) ) {
  class acf_vc_helper {

	  public function __construct() {
		  $this->construct = 'we are in the parent class';
	  }

	  	public static function is_acf_repeater_active( $val = false ) {
			$return = false;

			if ( $val == "repeater_plugin" ) {
				if( is_plugin_active( 'acf-repeater/acf-repeater.php' ) AND !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
					$return = true;
				} 
			} elseif ( $val == "repeater_check" ) {
				if( is_plugin_active( 'acf-repeater/acf-repeater.php' ) || is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
					$return = true;
				} 
			}

			if ( $return === true ) {
				return true;
			} else {
				return false;
			}
		
		}

	 	public function text($field, $args, $post_id) {
			$prepend = "";
		  	$append = "";
		  	$prepend_append_array = array();

			if ( array_key_exists( 'prepend_append', $args ) ) {
				$prepend_append_array = explode( ',', $args["prepend_append"] );

				if ( $field["prepend"] && in_array( 'prepend', $prepend_append_array ) ) {
					$prepend = '<span class="prepend" >'.$field["prepend"].'</span> ';
				}
				if ( $field["append"] && in_array( 'append', $prepend_append_array ) ) {
					$append = ' <span class="append" >'.$field["append"].'</span>';
				}
			}

		 	 $output = $prepend.$field["value"].$append;

		  	return apply_filters('acfvc_text',$output,$field,$post_id);
		}

	  public function textarea($field, $args,$post_id) {
		  $output = $field["value"];
		  return apply_filters('acfvc_textarea',$output,$field,$post_id);
	  }

	  public function wysiwyg($field, $args,$post_id) {
		  $output = $field["value"];
		  return apply_filters('acfvc_wysiwyg',$output,$field,$post_id);
	  }

	  public function number($field, $args,$post_id) {
		  $prepend = "";
		  $append = "";
		  $prepend_append_array = array();

			if ( array_key_exists( 'prepend_append', $args ) ) {
				$prepend_append_array = explode( ',', $args["prepend_append"] );

				if ( $field["prepend"] && in_array( 'prepend', $prepend_append_array ) ) {
					$prepend = '<span class="prepend" >'.$field["prepend"].'</span> ';
				}
				if ( $field["append"] && in_array( 'append', $prepend_append_array ) ) {
					$append = ' <span class="append" >'.$field["append"].'</span>';
				}
			}

		  $output = $prepend.$field["value"].$append;

		  return apply_filters('acfvc_number',$output,$field,$post_id);
	  }

	  public function email($field, $args,$post_id) {
		  $prepend = "";
		  $append = "";
		  $prepend_append_array = array();

			if ( array_key_exists( 'prepend_append', $args ) ) {
				$prepend_append_array = explode( ',', $args["prepend_append"] );

				if ( $field["prepend"] && in_array( 'prepend', $prepend_append_array ) ) {
					$prepend = '<span class="prepend" >'.$field["prepend"].'</span> ';
				}
				if ( $field["append"] && in_array( 'append', $prepend_append_array ) ) {
					$append = ' <span class="append" >'.$field["append"].'</span>';
				}
			}

		  $acfvc_option = get_option('acfvc_default');
		  $email_as_link = false;
		  if ($acfvc_option) {
			  if (array_key_exists('email_as_link',$acfvc_option['general'])) {
				  $email_as_link = $acfvc_option['general']['email_as_link'];
			  }
		  }
		  if ($email_as_link == true) {
			  $output = '<a href="mailto:'.$field["value"].'">'.$field["value"].'</a>';
		  } else {
			  $output = $field["value"];
		  }
		  $output = $prepend.$output.$append;
		  return apply_filters('acfvc_email',$output,$field,$post_id);
	  }

	  public function password($field, $args,$post_id) {
		  $prepend = "";
		  $append = "";
		  $prepend_append_array = array();

			if ( array_key_exists( 'prepend_append', $args ) ) {
				$prepend_append_array = explode( ',', $args["prepend_append"] );

				if ( $field["prepend"] && in_array( 'prepend', $prepend_append_array ) ) {
					$prepend = '<span class="prepend" >'.$field["prepend"].'</span> ';
				}
				if ( $field["append"] && in_array( 'append', $prepend_append_array ) ) {
					$append = ' <span class="append" >'.$field["append"].'</span>';
				}
			}

		  $output = $prepend.$field["value"].$append;

		  return apply_filters('acfvc_password',$output,$field,$post_id);
	  }


	public function image($field, $args,$post_id) {
	  $img_details = $field["value"];
	  $acf_version = $args["acf_version"];
	  if($acf_version >= 5) {
		if($field["return_format"] == "array") {
		  if(isset($img_details["url"])) {
			$output = '<img title="'.$img_details["title"].'" src="'.$img_details["url"].'" alt="'.$img_details["alt"].'" width="'.$img_details["width"].'" height="'.$img_details["height"].'" />';
		  } else {
			$output = 'data-mismatch';
		  }
		} elseif ($field["return_format"]=="url") {
		  $output = '<img src="'.$img_details.'"/>';
		} elseif ($field["return_format"]=="id") {
		  $img_details = wp_get_attachment_image_src($img_details);
		  $output = '<img src="'.$img_details[0].'"/>';
		} else {
		  $output = $field["value"];
		}
	  } else {
		if($field["save_format"] == "object" ) {
			if(isset($img_details["url"])) {
				$output = '<img title="'.$img_details["title"].'" src="'.$img_details["url"].'" alt="'.$img_details["alt"].'" width="'.$img_details["width"].'" height="'.$img_details["height"].'" />';
			} else {
				$output = 'data-mismatch';
			}
		} elseif ($field["save_format"]=="url") {
		  $output = '<img src="'.$img_details.'"/>';
		} elseif ($field["save_format"]=="id") {
		  $img_details = wp_get_attachment_image_src($img_details);
		  $output = '<img src="'.$img_details[0].'"/>';
		} else {
		  $output = $field["value"];
		}
	  }
	  return apply_filters('acfvc_image',$output,$field,$post_id);
	}

	public function file($field, $args, $post_id) {
	  $file_details = $field["value"];
	  $acf_version = $args["acf_version"];
	  $link_text = $args["link_text"];
	  $file_prepend_text = "";
	  $file_link_target = "_self";

		if ( array_key_exists( 'file', $args ) ) {
			if ( array_key_exists( 'file_prepend_text', $args["file"] ) ) {
				if ( !empty( $args["file"]["file_prepend_text"] ) ) {
					$file_prepend_text = $args["file"]["file_prepend_text"]." ";
				}
			}
			if ( array_key_exists( 'file_link_target', $args["file"] ) ) {
				if ( $args["file"]["file_link_target"] == "_blank" ) {
					$file_link_target = "_blank";
				}
			}			
		}	  

	  if($acf_version >= 5) {
		if($field["return_format"] == "array" ) {
		  if(isset($file_details["url"])) {

			if ( array_key_exists( 'file', $args ) ) {
				if ( array_key_exists( 'file_link_text', $args["file"] ) ) {
				
					if ( $args["file"]["file_link_text"] == "title" ) {
						$link_text = $file_details["title"];
					} elseif ( $args["file"]["file_link_text"] == "filename" ) {
						$link_text = $file_details["filename"];
					}

				}
			}

			$output = '<a target="'.$file_link_target.'" title="'.$file_prepend_text.$link_text.'" href="'.$file_details["url"].'">'.$file_prepend_text.$link_text.'</a>';
		  } else {
			$output = 'data-mismatch';
		  }
		} elseif ($field["return_format"]=="url") {
		  $output = '<a target="'.$file_link_target.'" title="'.$file_prepend_text.'" href="'.$file_details.'">'.$file_prepend_text.$link_text.'</a>';
		} elseif ($field["return_format"]=="id") {
		  $file_details = wp_get_attachment_url($file_details);
		  $output = '<a target="'.$file_link_target.'" title="'.$file_prepend_text.'" href="'.$file_details.'">'.$link_text.'</a>';
		} else {
		  $output = $field["value"];
		}
	  } else {
		if($field["save_format"] == "object" ) {
			if(isset($file_details["url"])) {
				$output = '<a target="'.$file_link_target.'" title="'.$file_prepend_text.$link_text.'" href="'.$file_details["url"].'">'.$file_prepend_text.$link_text.'</a>';
			} else {
				$output = 'data-mismatch';
			}
		} elseif ($field["save_format"]=="url") {
		  $output = '<a target="'.$file_link_target.'" title="'.$file_prepend_text.'" href="'.$file_details.'">'.$link_text.'</a>';
		} elseif ($field["save_format"]=="id") {
		  $file_details = wp_get_attachment_url($file_details);
		  $output = '<a target="'.$file_link_target.'" title="'.$file_prepend_text.'" href="'.$file_details.'">'.$link_text.'</a>';
		} else {
		  $output = $field["value"];
		}
	  }
	  return apply_filters('acfvc_file',$output,$field,$link_text,$post_id);
	}

	public function select($field, $args, $post_id) {
	  if ( $field["multiple"] === 1 ) {
		if ( !empty($field["value"]) ) {
		  $output = '<ul>';
		  foreach ($field["value"] as $key => $value) {
			  if($field["return_format"] == "array" ) {
				  $output .= '<li class="'.$field["name"].' '.$field["name"].'-'.$value["value"].' '.$field["name"].'_'.$key.'">'.$value["label"].'</li>';
			  } else {
				  $output .= '<li class="'.$field["name"].' '.$field["name"].'-'.$value.' '.$field["name"].'_'.$key.'">'.$value.'</li>';
			  }
		  }
		  $output .= '</ul>';
		}
	  } else {
		  if($field["return_format"] == "array" ) {
			  $output =  $field["value"]["label"];
		  } else {
			  $output =  $field["value"];
		}
	  }
	  return apply_filters('acfvc_select',$output,$field,$post_id);
	}

	public function checkbox($field, $args, $post_id) {
	  $check_values = $field["value"];
	  $output = '';
	  if ( $field["return_format"] == "array" ) {
		  foreach ($check_values as $key => $value) {

			  if ( $value == end($check_values) ) {
				  $output .= $value["label"];
			  } else {
				  $output .= $value["label"].", ";
			  }

		  }
	  } else {
		  if(is_array($check_values)) {
			$output = implode(", ", $check_values);
		  }
	  }
	  return apply_filters('acfvc_checkbox',$output,$field,$post_id);
	}

	public function radio($field, $args, $post_id) {
	  $radio_value = $field["value"];
	  $output = '';
	  if ( $field["return_format"] == "array" ) {
		  $output = $radio_value["label"];
	  } else {
		  if ( !empty($radio_value) ) {
			  $output = $radio_value;
		  }
	  }
	  return apply_filters('acfvc_radio',$output,$field,$post_id);
	}

	public function user_return_displayname ($return_format, $field_value ) {

		// object
		if( $return_format == 'object' ) {
			$display_name = $field_value->data->display_name;
		// array
		} elseif( $return_format == 'array' ) {
			$display_name = $field_value["display_name"];
		// id
		} else {
			$user_data = get_userdata($field_value);
			$display_name = $user_data->data->display_name;
		}
		return $display_name;
	}

	public function user($field, $args, $post_id) {

	  $user_details = $field["value"];

	  if (array_key_exists("field_type",$field))  {
		if ($field["field_type"]=="multi_select") {
		  $output = "<ul>";
			foreach ($user_details as $key => $value) {
			  $output .= "<li>".$value["display_name"]."</li>";
			}
		  $output .= "</ul>";
		} else {
		  $output = $user_details["display_name"];
		}
	  } elseif (array_key_exists("multiple",$field)) {
		if ($field["multiple"]==1) {
		  $output = "<ul>";
			foreach ($user_details as $key => $value) {
				$display_name = self::user_return_displayname($field["return_format"], $value);
			  $output .= "<li>".$display_name."</li>";
			}
		  $output .= "</ul>";
		} else {
			$display_name = self::user_return_displayname($field["return_format"], $user_details);
		  $output = $display_name;
		}
	  }
	  return apply_filters('acfvc_user',$output,$field,$post_id);
	}

	  public function page_link($field, $args, $post_id) {
		  $page_link = $field["value"];
		   $link_text = $args["link_text"];
		  if ($field["multiple"] == 1) {
			  $output = "<ul>";
			  foreach ($page_link as $key => $value) {
				  $output .= '<li><a title="'.$value.'" href="'.$value.'">'.$link_text.'</a></li>';
			  }
			  $output .= "</ul>";
		  } else {
			  $output = '<a title="'.$page_link.'" href="'.$page_link.'">'.$link_text.'</a>';
		  }
		  return apply_filters('acfvc_page_link',$output,$field,$link_text,$post_id);
	  }

	public function google_map($field, $args, $post_id) {
		$map_details = $field["value"];
		
		$acfvc_option = get_option('acfvc_default');
		
		if ( !array_key_exists( 'google_map', $args ) ) {
			
			$google_map_options["map_height"] = '400px';
			$google_map_options["zoom_level"] = '14';
			$google_map_options["placecard"] = 1;
			$google_map_options["zoom"] = 1;
			$google_map_options["type"] = 1;
			$google_map_options["fullscreen"] = 0;
			$google_map_options["street_view"] = 0;
			$google_map_options["scale"] = 0;

		} else {
			$google_map_options = $args["google_map"];
		}

		if  ( $google_map_options["placecard"] === 'default' ) {
			if ( $acfvc_option ) {
				if ( array_key_exists( 'google_map', $acfvc_option ) ) {
					if ( array_key_exists( 'placecard', $acfvc_option['google_map'] ) ) {
						$google_map_options["placecard"] = $acfvc_option['google_map']['placecard'];
					}
				} else {
					$google_map_options["placecard"] = 1;					
				}
			}
		}
		if  ( $google_map_options["zoom"] === 'default' ) {
			if ( $acfvc_option ) {
				if ( array_key_exists( 'google_map', $acfvc_option ) ) {
					if ( array_key_exists( 'zoom', $acfvc_option['google_map'] ) ) {
						$google_map_options["zoom"] = $acfvc_option['google_map']['zoom'];
					}
				} else {
					$google_map_options["zoom"] = 1;					
				}
			}
		}	
		if  ( $google_map_options["type"] === 'default' ) {
			if ( $acfvc_option ) {
				if ( array_key_exists( 'google_map', $acfvc_option ) ) {
					if ( array_key_exists( 'type', $acfvc_option['google_map'] ) ) {
						$google_map_options["type"] = $acfvc_option['google_map']['type'];
					}
				} else {
					$google_map_options["type"] = 1;					
				}
			}
		}	
		if  ( $google_map_options["fullscreen"] === 'default' ) {
			if ( $acfvc_option ) {
				if ( array_key_exists( 'google_map', $acfvc_option ) ) {
					if ( array_key_exists( 'fullscreen', $acfvc_option['google_map'] ) ) {
						$google_map_options["fullscreen"] = $acfvc_option['google_map']['fullscreen'];
					}
				} else {
					$google_map_options["fullscreen"] = 0;					
				}
			}
		}		
		if  ( $google_map_options["street_view"] === 'default' ) {
			if ( $acfvc_option ) {
				if ( array_key_exists( 'google_map', $acfvc_option ) ) {
					if ( array_key_exists( 'street_view', $acfvc_option['google_map'] ) ) {
						$google_map_options["street_view"] = $acfvc_option['google_map']['street_view'];
					}
				} else {
					$google_map_options["street_view"] = 0;					
				}
			}
		}		
		if  ( $google_map_options["scale"] === 'default' ) {
			if ( $acfvc_option ) {
				if ( array_key_exists( 'google_map', $acfvc_option ) ) {
					if ( array_key_exists( 'scale', $acfvc_option['google_map'] ) ) {
						$google_map_options["scale"] = $acfvc_option['google_map']['scale'];
					}
				} else {
					$google_map_options["scale"] = 0;					
				}
			}
		}		

		$google_api = array();
		$google_api_key = "";
		$map_region = "";
		$gadress_title = "";
		$gadress = $map_details["lat"].', '.$map_details["lng"];
		$move_type_control = "";
		$output = "";

		if ( $field["value"]["address"] ) {
			$gadress = $field["value"]["address"];
			$gadress_explode = explode( ',', $gadress );
			$gadress_title = $gadress_explode[0];
		}
	
		$google_api = array(
			'key'		=> acf_get_setting('google_api_key'),
		);

		$google_api = apply_filters('acf/fields/google_map/api', $google_api);

		if ( $google_api["key"] ) {
			$google_api_key = $google_api["key"];
		}

		if ( get_locale() ) {
			$local = explode( '_', get_locale() );
			$map_language = $local[0];
			if ( array_key_exists("1",$local) ) {
				$map_language .= "&region=".$local[1];
			}
			// $map_region = "";
			
		}
		
		if ( $google_map_options["placecard"] ) {
			$output .= '<div class="map-container">
			<div class="placeDiv">
				<div class="placecard__container">
				<div class="placecard__left">
					<p class="placecard__business-name">'.$gadress_title.'</p>
					<p class="placecard__info">'.$gadress.'</p>
					<a class="placecard__view-large" target="_blank" href="https://www.google.com/maps?ll='.$map_details["lat"].','.$map_details["lng"].'&z=9&t=m&mapclient=embed&q='.$gadress.'" id="A_41">'.__( "View larger map", "acf-vc-integrator" ).'</a>
				</div>
				<div class="placecard__right">
					<a class="placecard__direction-link" target="_blank" href="https://maps.google.com/maps?ll='.$map_details["lat"].','.$map_details["lng"].'&z=9&t=m&mapclient=embed&daddr='.$gadress.'" id="A_9">
						<div class="placecard__direction-icon"></div>
						'.__( "Directions", "acf-vc-integrator" ).'
					</a>
				</div>
				</div>
			</div>
			</div>';
			if ( $google_map_options["type"] ) { 
				$move_type_control = "mapTypeControlOptions: {
					style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
					position: google.maps.ControlPosition.TOP_RIGHT
				},";
			}
		}
		$output .= '<div style="height: '.$google_map_options["map_height"].'" id="map"></div>';
		$output .= "<script>
		function initMap() {
		var lat_lng = {lat: ".$map_details['lat'].", lng: ".$map_details['lng']."};
		  var map = new google.maps.Map(document.getElementById('map'), {
			zoom: ".$google_map_options['zoom_level'].",
			center: lat_lng,
			disableDefaultUI: true,
			zoomControl: ".$google_map_options['zoom'].",
			mapTypeControl: ".$google_map_options['type'].",
			".$move_type_control."
			streetViewControl: ".$google_map_options['street_view'].",
			scaleControl: ".$google_map_options['scale'].",
			fullscreenControl: ".$google_map_options['fullscreen']."
		  });
		  var marker = new google.maps.Marker({map: map, position: lat_lng});
		}
        
	  </script>";
		$output .= '<script async defer src="https://maps.googleapis.com/maps/api/js?key='.$google_api_key.'&callback=initMap&language='.$map_language.'"></script>';
		return apply_filters('acfvc_google_map',$output,$field,$post_id);
	}

	public function date_picker($field, $args, $post_id) {
	  $acfvc_option = get_option('acfvc_default');
	  if ($acfvc_option) {
		  if (array_key_exists('date_format',$acfvc_option['general'])) {
			  $date_format_selected = $acfvc_option['general']['date_format'];
		  }
	  }

	  if ( $date_format_selected == "acf_default" ) {
		  $output = $field["value"];
	  } else {
		  $unixtimestamp = strtotime($field["value"]);
		  $date_format = get_option( 'date_format' );
		  $output = date_i18n($date_format,$unixtimestamp);
	  }
	  return apply_filters('acfvc_date_picker',$output,$field,$post_id);
	}

	public function color_picker($field, $args, $post_id) {
	  $output = '<div style="display: inline-block; height: 15px; width: 15px; margin: 0px 5px 0px 0px; background-color: '.$field["value"].'"></div>'.$field["value"];
	  return apply_filters('acfvc_color_picker',$output,$field,$post_id);
	}

	public function true_false($field, $args, $post_id) {
	  if(1 == $field["value"]) $output = 'True'; else $output = "False";
	  return apply_filters('acfvc_true_false',$output,$field,$post_id);
	}

	public function taxonomy($field, $args, $post_id) {
	  $terms = $field["value"];
		if(!empty($terms)) {
		  if ($field["field_type"]=="checkbox" OR $field["field_type"]=="multi_select") {
		  $output = "<ul>";
		  foreach($terms as $term) {
			$term_details = get_term( $term, 'category', ARRAY_A );
			$output .= '<li><a href="'.get_term_link( $term_details["term_id"], 'category' ).'" title="'.$term_details["name"].'">'.$term_details["name"].'</a></li>';
		  }
		  $output .= "</ul>";
		} elseif ($field["field_type"]=="radio" OR $field["field_type"]=="select") {
		  $term_details = get_term( $terms, 'category', ARRAY_A );
		  $output = '<a href="'.get_term_link( $term_details["term_id"], 'category' ).'" title="'.$term_details["name"].'">'.$term_details["name"].'</a>';
		}
	  }
	  return apply_filters('acfvc_taxonomy',$output,$field,$post_id);
	}

	public function post_object($field, $args, $post_id) {
	  $post_obj = $field["value"];
	  $output = "<ul>";
	  if (is_array($post_obj)) {
		foreach($post_obj as $post_obj_details) {
		  if (array_key_exists("return_format",$field))  {
			if ($field["return_format"]=="id") {
			  $post_id = $post_obj_details;
			} else {
			  $post_id = $post_obj_details->ID;
			}
		  } else {
			$post_id = $post_obj_details;
		  }
		  $output .= '<li><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">'.get_the_title($post_id).'</a></li>';
		}
	  } else {
		$output .= '<li><a href="'.get_permalink($post_obj).'" title="'.get_the_title($post_obj).'">'.get_the_title($post_obj).'</a></li>';
	  }
	  $output .= "</ul>";
	  return apply_filters('acfvc_post_object',$output,$field,$post_id);
	}

	public function relationship($field, $args, $post_id) {
	  $posts = $field["value"];
	  $output = "<ul>";
	  foreach($posts as $post_details) {
	  if ($field["return_format"]=="id") {
		$post_id = $post_details;
	  } else {
		$post_id = $post_details->ID;
	  }
		$output .= '<li><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">'.get_the_title($post_id).'</a></li>';
	  }
	  $output .= "</ul>";
	  return apply_filters('acfvc_relationship',$output,$field,$post_id);
	}

	  public function url($field, $args, $post_id) {
		  $url = $field["value"];
		  $output = '<a href="'.$url.'">'.$url.'</a>';
		  return apply_filters('acfvc_url',$output,$field,$post_id);
	  }

	  public function link($field,$args,$post_id) {
		  $link = $field["value"];

		  if ( $field["return_format"] == "array" ) {
			  if ( empty( $link["title"] ) ) {
				   $link_titel =  $link["url"];
			  } else {
				  $link_titel = $link["title"];
			  }

			  if ($link['target']) {
				  $link_target = $link['target'];
			  } else {
				  $link_target = "_self";
			  }

			  $output = '<a href="'.esc_url($link["url"]).'" target="'.esc_attr($link_target).'">'.esc_html($link_titel).'</a>';
		  } else{
			  $output = '<a href="'.esc_url($link).'" >'.esc_html($link).'</a>';
		  }
		  return apply_filters('acfvc_link',$output,$field,$post_id);
	  }

	public function oembed($field, $args,$post_id) {
		$output = $field["value"];
		return apply_filters('acfvc_oembed',$output,$field,$post_id);
	}

	public function gallery($field, $args,$post_id) {
		/*https://codex.wordpress.org/Gallery_Shortcode*/
		$gallery_options = $args["gallery_options"];
		$acfvc_option = get_option('acfvc_default');
		if  ($gallery_options["itemtag"] == 'default') {
			if ($acfvc_option) {
				if (array_key_exists('itemtag',$acfvc_option['gallery'])) {
					$gallery_options["itemtag"] = $acfvc_option['gallery']['itemtag'];
				}
			}
		}
		if  ($gallery_options["icontag"] == 'default') {
			if ($acfvc_option) {
				if (array_key_exists('icontag',$acfvc_option['gallery'])) {
					$gallery_options["icontag"] = $acfvc_option['gallery']['icontag'];
				}
			}
		}
		if  ($gallery_options["captiontag"] == 'default') {
			if ($acfvc_option) {
				if (array_key_exists('captiontag',$acfvc_option['gallery'])) {
					$gallery_options["captiontag"] = $acfvc_option['gallery']['captiontag'];
				}
			}
		}

		$columns = "";
		if (!empty($gallery_options["columns"])) {
			$columns = 'columns="'.$gallery_options["columns"].'"';
		}
		$image_size = "";
		if ($gallery_options["image_size"]) {
			$image_size = 'size="'.$gallery_options["image_size"].'"';
		}
		$order_by = "";
		if ($gallery_options["order_by"]) {
			$order_by = 'orderby="'.$gallery_options["order_by"].'"';
		}
		$order = "";
		if ($gallery_options["order"]) {
			$order = 'order="'.$gallery_options["order"].'"';
		}
		$itemtag = "";
		if ($gallery_options["itemtag"]) {
			$itemtag = 'itemtag="'.$gallery_options["itemtag"].'"';
		}
		$icontag = "";
		if ($gallery_options["icontag"]) {
			$icontag = 'icontag="'.$gallery_options["icontag"].'"';
		}
		$captiontag = "";
		if ($gallery_options["captiontag"]) {
			$captiontag = 'captiontag="'.$gallery_options["captiontag"].'"';
		}
		$link = "";
		if ($gallery_options["link"]) {
			$link = 'link="'.$gallery_options["link"].'"';
		}
		$gallery_array = array();
		foreach ($field["value"] as $key => $value) {
			$gallery_array[] = intval($value["ID"]);
		}
		$gallery_images = implode(",",$gallery_array);
		$gallery = "[gallery ids='{$gallery_images}' {$columns} {$image_size} {$order} {$order_by} {$itemtag} {$icontag} {$captiontag} {$link}]";
		return apply_filters('acfvc_gallery',do_shortcode($gallery),$field,$gallery_options,$post_id);
	}

	public function repeater_child($field, $args, $post_id) {
	  $repeaterParentName = $args["repeaterParentName"];
	  $acf_version = $args["acf_version"];
	  $link_text = $args["link_text"];
	  $gallery_options = $args["gallery_options"];

	  $output = '<div class="reapeter-column '.$field["key"].' '.$field["name"].'">';
		if ( 'text' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::text($field, $args, $post_id);
		  }
		} elseif ( 'textarea' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::textarea($field, $args, $post_id);
		  }
		} elseif ( 'wysiwyg' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::wysiwyg($field, $args, $post_id);
		  }
		} elseif ( 'number' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::number($field, $args, $post_id);
		  }
		} elseif ( 'email' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::email($field, $args, $post_id);
		  }
		} elseif ( 'password' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::password($field, $args, $post_id);
		  }
		} elseif ( 'image' === $field["type"]) {
		  if ( !empty($field["value"]) ) {
			$output .= self::image($field, $args, $post_id);
		  }
		} elseif('file' === $field["type"]) {
		  if ( !empty($field["value"]) ) {
			$output .= self::file($field, $args, $post_id);
		  }
  			} elseif ( 'select' === $field["type"]) {
		  if ( !empty($field["value"]) ) {
			$output .= self::select($field, $args, $post_id);
		  }
		} elseif ( 'checkbox' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::checkbox($field, $args, $post_id);
		  }
  			} elseif ( 'radio' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::radio($field, $args, $post_id);
		  }
  			} elseif ( 'user' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::user($field, $args, $post_id);
		  }
  			} elseif ( 'page_link' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::page_link($field, $args, $post_id);
		  }
  			} elseif ( 'google_map' === $field["type"] ) {
		  if ( !empty($field["value"]) ) {
			$output .= self::google_map($field, $args, $post_id);
		  }
  			} elseif ('date_picker' === $field["type"]) {
		  if ( !empty($field["value"]) ) {
			$output .= self::date_picker($field, $args, $post_id);
		  }
		} elseif ('color_picker' === $field["type"]) {
		  if ( !empty($field["value"]) ) {
			$output .= self::color_picker($field, $args, $post_id);
		  }
		} elseif ('true_false' === $field["type"]) {
			$output .= self::true_false($field, $args, $post_id);
		} elseif ('taxonomy' === $field["type"]) {
			$output .= self::taxonomy($field, $args, $post_id);
		} elseif('post_object' === $field["type"]) {
		  if ( !empty($field["value"]) ) {
			$output .= self::post_object($field, $args, $post_id);
		  }
		} elseif('relationship' === $field["type"]) {
		  if ( !empty($field["value"]) ) {
			$output .= self::relationship($field, $args, $post_id);
		  }
		} elseif('url' === $field["type"]) {
		  $output .= self::url($field, $args, $post_id);
		} elseif('link' === $field["type"]) {
		  $output .= self::link($field, $args, $post_id);
		} elseif('oembed' === $field["type"]) {
		  $output .= self::oembed($field, $args, $post_id);
	  } elseif('gallery' === $field["type"]) {
		  $output .= self::gallery($field, $args, $post_id);
	  } elseif('repeater' === $field["type"]) {
		if (!empty($field['value'][0])) :
		  $fieldNames = array_keys($field['value'][0]);
		  $output .= '<div class="repeater-child-wrapper">';

			if ( $args["showHeader"] ) {
				$output .= '<div class="repeater-header header">';
				$i = 1;
					foreach ($field['sub_fields'] as $key_sb => $value_sb) {
							$output .= '<div class="column column-'.$i.'">'.$value_sb["label"].'</div>';
							$i++;
					}		
				$output .= '</div>';
			}	

			while ( have_rows($field['name'],$post_id) ) : the_row();
			  $output .= '<div class="reapeater-row row-'.get_row_index().'">';
			  foreach ($fieldNames as $key => $value) {
			  $subSeild = get_sub_field_object($value);
				$subSeildValue = get_sub_field($value);
				$subSeild["value"] = $subSeildValue;
				$output .= self::repeater_child($subSeild,$args,$post_id);
			  }
			  $output .= '</div>';
			endwhile;
		  $output .= '</div>';
		endif;
  		} else {
		$output_filter = apply_filters( "acf_vc_repeater_add_on_fields",$field,$args,$post_id );
		if ( is_array( $output_filter ) ) {
			$output .= $output_filter["type"]." is not supported";
		} else {
			$output .= $output_filter;
		}
	  }
	  $output .= '</div>';

	  return apply_filters('acfvc_sub_repeater',$output,$field,$args,$post_id);
	}

	public function repeater($field, $args, $post_id) {
		$args["repeaterParentName"] = $field["name"];
		$fieldNames = array_keys($field['value'][0]);
		$args["showHeader"] = false;

		$repeater_header = '';
		if ( key_exists( 'repeater', $args ) ) {
			if ( key_exists( 'header', $args['repeater'] ) ) {
				$repeater_header = $args['repeater']['header'];
			}
		}

		if ( $repeater_header == "show" ) {
			$args["showHeader"] = true;
		} else if ( $repeater_header == "hide" ) {
			$args["showHeader"] = false;
		} else {
			if ( get_option('acfvc_default') ) {
				$acfvc_option = get_option('acfvc_default');
				if ( array_key_exists( 'repeater', $acfvc_option ) ) {
					if ( array_key_exists( 'header',$acfvc_option['repeater'] ) ) {
						if ( $acfvc_option['repeater']['header'] === 'show' ) {
							$args["showHeader"] = true;
						}
					}
				}
			}
		}
		
		if (!empty($field['value'][0])) :

			$repeater = '<div class="repeater-wrapper">';
			
			if ( $args["showHeader"] ) {
				$repeater .= '<div class="repeater-header header">';
				$i = 1;
					foreach ($field['sub_fields'] as $key_sb => $value_sb) {
							$repeater .= '<div class="column column-'.$i.'">'.$value_sb["label"].'</div>';
							$i++;
					}		
				$repeater .= '</div>';
			}	
			
			while ( have_rows($field['name'],$post_id) ) : the_row();
				$repeater .= '<div class="reapeater-row row-'.get_row_index().'">';
					foreach ($fieldNames as $key => $value) {
						$subSeild = get_sub_field_object($value);
						if( self::is_acf_repeater_active( "repeater_plugin" ) ) {
							$subSeildValue = get_sub_field($value);
							$subSeild["value"] = $subSeildValue;
						}
						$repeater .= self::repeater_child($subSeild,$args,$post_id);
					}
				$repeater .= '</div>';
			endwhile;
		
			$repeater .= '</div>';

			return apply_filters('acfvc_repeater',$repeater,$field,$args,$post_id);
		endif;
	}

  }
}
