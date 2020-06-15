<?php
  if ( ! class_exists( 'acf_vc_helper_pro' ) ) {
    class acf_vc_helper_pro extends acf_vc_helper {

      public function __construct() {
          parent::__construct();
          $this->construct = 'we are in the child class';
      }

      public function date_time_picker($field, $args,$post_id) {
        $acfvc_option = get_option('acfvc_default');
        if ($acfvc_option) {
            if (array_key_exists('date_time_format',$acfvc_option['general'])) {
                $date_time_format_selected = $acfvc_option['general']['date_time_format'];
            }
        }

        if ( $date_time_format_selected == "acf_default" ) {
            $output = $field["value"];
        } else {
            $dateObj = DateTime::createFromFormat($field["return_format"], $field["value"]);
            $unixtimestamp = $dateObj->getTimestamp();
            $date_format = get_option( 'date_format' );
            $time_format = get_option( 'time_format' );
            $date_time_format = $date_format.' '.$time_format;
            $output = date_i18n($date_time_format,$unixtimestamp);
        }
        return apply_filters('acfvc_date_time_picker',$output,$field,$post_id);
      }

      public function time_picker($field, $args,$post_id) {
        $acfvc_option = get_option('acfvc_default');
        if ($acfvc_option) {
            if (array_key_exists('time_format',$acfvc_option['general'])) {
                $time_format_selected = $acfvc_option['general']['time_format'];
            }
        }
        if ( $time_format_selected == "acf_default" ) {
            $output = $field["value"];
        } else {
            $unixtimestamp = strtotime($field["value"]);
            $time_format = get_option( 'time_format' );
            $output = date_i18n($time_format,$unixtimestamp);
        }
        return apply_filters('acfvc_time_picker',$output,$field,$post_id);
      }

      public function range($field, $args, $post_id) {
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

        return apply_filters('acfvc_range',$output,$field,$post_id);
      }

      public function button_group($field, $args,$post_id) {
        $button_values = $field["value"];
        $output = '';
        if ( $field["return_format"] == "array" ) {
            $output = $button_values["label"];
        } else {
            if ( !empty($button_values) ) {
                $output = $button_values;
            }
        }
        return apply_filters('acfvc_button_group',$output,$field,$post_id);
      }

      public function clone_field($field,$args,$post_id) {
        $field_key = $args["field_key"];
        $clone_field_key = $args["clone_field_key"];
        $acf_version = $args["acf_version"];
        $link_text = $args["link_text"];
        $gallery_options = $args["gallery_options"];
        $clone_field_data = get_field_object($clone_field_key);

        if ( !empty($field["value"]) ) {
          foreach ($field["value"] as $key => $value) {

            if ($key == $clone_field_data["name"]) {
              $clone_field_data["value"] = $value;
              $field_data = $clone_field_data;
              $output .= '<div id="' . $clone_field_key . '" class="'.$field_data["name"].' '.$field_data["type"].'">';

              if ( 'text' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::text($field_data, $args, $post_id);
                }
              } elseif ( 'textarea' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::textarea($field_data, $args, $post_id);
                }
              } elseif ( 'wysiwyg' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::wysiwyg($field_data, $args, $post_id);
                }
              } elseif ( 'number' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::number($field_data, $args, $post_id);
                }
              } elseif ( 'email' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::email($field_data, $args, $post_id);
                }
              } elseif ( 'password' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::password($field_data, $args, $post_id);
                }
              } elseif ( 'image' === $field_data["type"]) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::image($field_data, $args, $post_id);
                }
              } elseif('file' === $field_data["type"]) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::file($field_data, $args, $post_id);
                }
              } elseif ( 'select' === $field_data["type"]) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::select($field_data, $args, $post_id);
                }
              } elseif ( 'checkbox' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::checkbox($field_data, $args, $post_id);
                }
              } elseif ( 'radio' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::radio($field_data, $args, $post_id);
                }
              } elseif ( 'user' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::user($field_data, $args, $post_id);
                }
              } elseif ( 'page_link' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::page_link($field_data, $args, $post_id);
                }
              } elseif ( 'google_map' === $field_data["type"] ) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::google_map($field_data, $args, $post_id);
                }
              } elseif ('date_picker' === $field_data["type"]) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::date_picker($field_data, $args, $post_id);
                }
              } elseif ('color_picker' === $field_data["type"]) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::color_picker($field_data, $args, $post_id);
                }
              } elseif ('true_false' === $field_data["type"]) {
                  $output .= parent::true_false($field_data, $args, $post_id);
              } elseif ('taxonomy' === $field_data["type"]) {
                  $output .= parent::taxonomy($field_data, $args, $post_id);
              } elseif('post_object' === $field_data["type"]) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::post_object($field_data, $args, $post_id);
                }
              } elseif('relationship' === $field_data["type"]) {
                if ( !empty($field_data["value"]) ) {
                  $output .= parent::relationship($field_data, $args, $post_id);
                }
              } elseif('url' === $field_data["type"]) {
                  $output .= parent::url($field_data, $args, $post_id);
              } elseif('link' === $field["type"]) {
                  $output .= parent::link($field, $args, $post_id);
  		      } elseif('oembed' === $field_data["type"]) {
                  $output .= parent::oembed($field_data, $args, $post_id);
              } elseif('gallery' === $field_data["type"]) {
                  $output .= parent::gallery($field_data, $args, $post_id);
              } elseif('repeater' === $field_data["type"]) {
                  $output .= parent::repeater($field_data, $args, $post_id);
              } else {
                // $output .= $field_data["type"]." is not supported";
                $output_filter = apply_filters( "acf_vc_clone_add_on_fields",$field_data,$args,$post_id );
                if ( is_array( $output_filter ) ) {
                    $output .= $output_filter["type"]." is not supported";
                } else {
                    $output .= $output_filter;
                }
              }

              $output .= '</div>';
            }

          }
        }
        // $output = $field["value"];
        return apply_filters('acfvc_clone',$output,$field,$args,$post_id);
      }

      public static function flexible_content($field,$args,$post_id) {
        $acf_version = $args["acf_version"];
        $link_text = $args["link_text"];
        $gallery_options = $args["gallery_options"];

        if( have_rows($field["key"]) ):
            while ( have_rows($field["key"]) ) : the_row();
              $layout = get_row_layout();
              $row_fields = get_row();
              unset($row_fields["acf_fc_layout"]);

              $output .= '<div class="flexible-content-row row-'.get_row_index().'">';

              foreach ($row_fields as $key => $value) {
                $field_data = get_sub_field_object($key);
                  $output .= '<div id="' . $key . '" class="'.$field_data["name"].' '.$field_data["type"].'">';

                  if ( 'text' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::text($field_data, $args, $post_id);
                    }
                  } elseif ( 'textarea' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::textarea($field_data, $args, $post_id);
                    }
                  } elseif ( 'wysiwyg' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::wysiwyg($field_data, $args, $post_id);
                    }
                  } elseif ( 'number' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::number($field_data, $args, $post_id);
                    }
                  } elseif ( 'email' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::email($field_data, $args, $post_id);
                    }
                  } elseif ( 'password' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::password($field_data, $args, $post_id);
                    }
                  } elseif ( 'image' === $field_data["type"]) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::image($field_data, $args, $post_id);
                    }
                  } elseif('file' === $field_data["type"]) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::file($field_data, $args, $post_id);
                    }
                  } elseif ( 'select' === $field_data["type"]) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::select($field_data, $args, $post_id);
                    }
                  } elseif ( 'checkbox' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::checkbox($field_data, $args, $post_id);
                    }
                  } elseif ( 'radio' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::radio($field_data, $args, $post_id);
                    }
                  } elseif ( 'user' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::user($field_data, $args, $post_id);
                    }
                  } elseif ( 'page_link' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::page_link($field_data, $args, $post_id);
                    }
                  } elseif ( 'google_map' === $field_data["type"] ) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::google_map($field_data, $args, $post_id);
                    }
                  } elseif ('date_picker' === $field_data["type"]) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::date_picker($field_data, $args, $post_id);
                    }
                  } elseif ('color_picker' === $field_data["type"]) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::color_picker($field_data, $args, $post_id);
                    }
                  } elseif ('true_false' === $field_data["type"]) {
                      $output .= parent::true_false($field_data, $args, $post_id);
                  } elseif ('taxonomy' === $field_data["type"]) {
                      $output .= parent::taxonomy($field_data, $args, $post_id);
                  } elseif('post_object' === $field_data["type"]) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::post_object($field_data, $args, $post_id);
                    }
                  } elseif('relationship' === $field_data["type"]) {
                    if ( !empty($field_data["value"]) ) {
                      $output .= parent::relationship($field_data, $args, $post_id);
                    }
                  } elseif('url' === $field_data["type"]) {
                      $output .= parent::url($field_data, $args, $post_id);
                  } elseif('link' === $field["type"]) {
                      $output .= parent::link($field, $args, $post_id);
      		      } elseif('oembed' === $field_data["type"]) {
                      $output .= parent::oembed($field_data, $args, $post_id);
                  } elseif('gallery' === $field_data["type"]) {
                      $output .= parent::gallery($field_data, $args, $post_id);
                  } elseif('repeater' === $field_data["type"]) {
                      $output .= parent::repeater($field_data, $args, $post_id);
                  } else {
                    // $output .= $field_data["type"]." is not supported";
                    $output_filter = apply_filters( "acf_vc_flexible_content_add_on_fields",$field_data,$args,$post_id );
                    if ( is_array( $output_filter ) ) {
                        $output .= $output_filter["type"]." is not supported";
                    } else {
                        $output .= $output_filter;
                    }
                  }

                  $output .= '</div>';
              }

              $output .= '</div>';

            endwhile;
        else :
            // no layouts found
        endif;

        return apply_filters('acfvc_flexible_content',$output,$field,$post_id);
      }

    }
  }

  add_filter( "acf_vc_repeater_add_on_fields", "acf_vc_add_pro_fields_to_fields",1,3 );
  add_filter( "acf_vc_flexible_content_add_on_fields", "acf_vc_add_pro_fields_to_fields",1,3 );
  add_filter( "acf_vc_clone_add_on_fields", "acf_vc_add_pro_fields_to_fields",1,3 );
  function acf_vc_add_pro_fields_to_fields ($field, $args, $post_id ) {

    if (class_exists('acf_vc_helper_pro')) {
        $acf_vc_helper_pro = new acf_vc_helper_pro();

      if('date_time_picker' === $field["type"]) {
        $field = $acf_vc_helper_pro->date_time_picker($field, $args, $post_id);
      } elseif('time_picker' === $field["type"]) {
        $field = $acf_vc_helper_pro->time_picker($field, $args, $post_id);
      } elseif('range' === $field["type"]) {
        $field = $acf_vc_helper_pro->range($field, $args, $post_id);
      } elseif('button_group' === $field["type"]) {
        $field = $acf_vc_helper_pro->button_group($field, $args, $post_id);
      } elseif('flexible_content' === $field["type"]) {
        $field = '<div class="flexible-content-row row-'.get_row_index().'">';
        $field .= $acf_vc_helper_pro->flexible_content($field, $args, $post_id);
        $field .= '</div>';
      } elseif('clone' === $field["type"]) {
        $field = $acf_vc_helper_pro->clone_field($field,$args,$post_id);
      }

    }

    return $field;
  }

  add_filter( "acf_vc_add_on_fields", "acf_vc_add_pro_fields",1,3 );
  function acf_vc_add_pro_fields ($field,$args,$post_id ) {

    if (class_exists('acf_vc_helper_pro')) {
        $acf_vc_helper_pro = new acf_vc_helper_pro();
        if('date_time_picker' === $field["type"]) {
          $field = $acf_vc_helper_pro->date_time_picker($field, $args, $post_id);
        } elseif('time_picker' === $field["type"]) {
          $field = $acf_vc_helper_pro->time_picker($field, $args, $post_id);
        } elseif('range' === $field["type"]) {
          $field = $acf_vc_helper_pro->range($field, $args, $post_id);
        } elseif('button_group' === $field["type"]) {
          $field = $acf_vc_helper_pro->button_group($field, $args, $post_id);
        } elseif('flexible_content' === $field["type"]) {
          $field = $acf_vc_helper_pro->flexible_content($field, $args, $post_id);
        } elseif('clone' === $field["type"]) {
          $field = $acf_vc_helper_pro->clone_field($field, $args, $post_id);
        }
    }


    return $field;

  }

  /*Add filter hooks to the admin guide*/
  add_action("acf_vc_add_to_filter_hook_guide", "acf_vc_date_time_filter_guide",10,1);
  function acf_vc_date_time_filter_guide($text_array) {
    if (class_exists('acf_vc_helper_pro')) {
      ?>
      <div class="acf-vc-hook-wrapper">
          <h3>Date Time picker field</h3>
          <p>add_filter('acfvc_date_time_picker','function_name',10,3);</p>
          <p class="parameters">Parameters</p>
          <ol>
              <li>$output
                  <p><?php echo $text_array["output_text"]; ?></p>
              </li>
              <li>$field
                  <p><?php echo $text_array["field_text"]; ?></p>
              </li>
              <li>$post_id
                  <p><?php echo $text_array["post_id_text"]; ?></p>
              </li>
          </ol>
      </div>
      <?php
    }
  }

  add_action("acf_vc_add_to_filter_hook_guide", "acf_vc_time_filter_guide",10,1);
  function acf_vc_time_filter_guide($text_array) {
    if (class_exists('acf_vc_helper_pro')) {
      ?>
      <div class="acf-vc-hook-wrapper">
          <h3>Time picker field</h3>
          <p>add_filter('acfvc_time_picker','function_name',10,3);</p>
          <p class="parameters">Parameters</p>
          <ol>
            <li>$output
                <p><?php echo $text_array["output_text"]; ?></p>
            </li>
            <li>$field
                <p><?php echo $text_array["field_text"]; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $text_array["post_id_text"]; ?></p>
            </li>
          </ol>
      </div>
      <?php
    }
  }

  add_action("acf_vc_add_to_filter_hook_guide", "acf_vc_range_filter_guide",10,1);
  function acf_vc_range_filter_guide($text_array) {
    if (class_exists('acf_vc_helper_pro')) {
      ?>
      <div class="acf-vc-hook-wrapper">
          <h3>Range field</h3>
          <p>add_filter('acfvc_time_picker','function_name',10,3);</p>
          <p class="parameters">Parameters</p>
          <ol>
            <li>$output
                <p><?php echo $text_array["output_text"]; ?></p>
            </li>
            <li>$field
                <p><?php echo $text_array["field_text"]; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $text_array["post_id_text"]; ?></p>
            </li>
          </ol>
      </div>
      <?php
    }
  }

  add_action("acf_vc_add_to_filter_hook_guide", "acf_vc_button_group_filter_guide",10,1);
  function acf_vc_button_group_filter_guide($text_array) {
    if (class_exists('acf_vc_helper_pro')) {
      ?>
      <div class="acf-vc-hook-wrapper">
          <h3>Button group field</h3>
          <p>add_filter('acfvc_button_group','function_name',10,3);</p>
          <p class="parameters">Parameters</p>
          <ol>
            <li>$output
                <p><?php echo $text_array["output_text"]; ?></p>
            </li>
            <li>$field
                <p><?php echo $text_array["field_text"]; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $text_array["post_id_text"]; ?></p>
            </li>
          </ol>
      </div>
      <?php
    }
  }

  add_action("acf_vc_add_to_filter_hook_guide", "acf_vc_clone_filter_guide",10,1);
  function acf_vc_clone_filter_guide($text_array) {
    if (class_exists('acf_vc_helper_pro')) {
      ?>
      <div class="acf-vc-hook-wrapper">
          <h3>Clone field</h3>
          <p>add_filter('acfvc_clone','function_name',10,5);</p>
          <p class="parameters">Parameters</p>
          <ol>
              <li>$output
                  <p><?php echo $text_array["output_text"]; ?></p>
              </li>
              <li>$field
                  <p><?php echo $text_array["field_text"]; ?></p>
              </li>
              <li>$args
                  <p><?php echo $text_array["args_text"]; ?></p>
                  <ol>
                    <li>$args["field_key"]
                        <p><?php echo $text_array["field_key_text"]; ?></p>
                    </li>
                    <li>$args["clone_field_key"]
                        <p><?php echo $text_array["clone_field_key_text"]; ?></p>
                    </li>
                    <li>$args["acf_version"]
                        <p><?php echo $text_array["acf_version_text"]; ?></p>
                    </li>
                    <li>$args["link_text"]
                        <p><?php echo $text_array["link_text_text"]; ?></p>
                    </li>
                    <li>$args["gallery_options"]
                        <p><?php echo $text_array["gallery_option_text"]; ?></p>
                    </li>
                  </ol>
              </li>
              <li>$post_id
                  <p><?php echo $text_array["post_id_text"]; ?></p>
              </li>
          </ol>
      </div>
      <?php
    }
  }

  add_action("acf_vc_add_to_filter_hook_guide", "acf_vc_flexible_content_filter_guide",10,1);
  function acf_vc_flexible_content_filter_guide($text_array) {
    if (class_exists('acf_vc_helper_pro')) {
      ?>
      <div class="acf-vc-hook-wrapper">
          <h3>Flexible content field</h3>
          <p>add_filter('acfvc_flexible_content','function_name',10,5);</p>
          <p class="parameters">Parameters</p>
          <ol>
              <li>$output
                  <p><?php echo $text_array["output_text"]; ?></p>
              </li>
              <li>$field
                  <p><?php echo $text_array["field_text"]; ?></p>
              </li>
              <li>$args
                  <p><?php echo $text_array["args_text"]; ?></p>
                  <ol>
                    <li>$args["field_key"]
                        <p><?php echo $text_array["field_key_text"]; ?></p>
                    </li>
                    <li>$args["clone_field_key"]
                        <p><?php echo $text_array["clone_field_key_text"]; ?></p>
                    </li>
                    <li>$args["acf_version"]
                        <p><?php echo $text_array["acf_version_text"]; ?></p>
                    </li>
                    <li>$args["link_text"]
                        <p><?php echo $text_array["link_text_text"]; ?></p>
                    </li>
                    <li>$args["gallery_options"]
                        <p><?php echo $text_array["gallery_option_text"]; ?></p>
                    </li>
                  </ol>
              </li>
              <li>$post_id
                  <p><?php echo $text_array["post_id_text"]; ?></p>
              </li>
          </ol>
      </div>
      <?php
    }
  }
