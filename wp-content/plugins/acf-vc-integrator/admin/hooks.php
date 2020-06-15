<?php

    $output_text = '- '.__('ACF-VC default output','acf-vc-integrator');
    $field_text = '- '.__('ACF field data','acf-vc-integrator');
    $post_id_text = '- '.__('The post id','acf-vc-integrator');
    $gallery_option_text = '- '.__('Settings for the gallery field that have been set through the acf-vc element or as default settings','acf-vc-integrator');
    $link_text_text = '- '.__('Link text that is inserted through the acf-vc element','acf-vc-integrator');
    $args_text = '- '.__('Array','acf-vc-integrator');
    $acf_version_text = '- '.__('ACF version number','acf-vc-integrator');
    $field_key_text = '- '.__('Field key','acf-vc-integrator');
    $clone_field_key_text = '- '.__('Clone field key','acf-vc-integrator');

    $text_array = array(
      "output_text" => $output_text,
      "field_text" => $field_text,
      "post_id_text" => $post_id_text,
      "gallery_option_text" => $gallery_option_text,
      "link_text_text" => $link_text_text,
      "args_text" => $args_text,
      "acf_version_text" => $acf_version_text,
      "field_key_text" => $field_key_text,
      "clone_field_key_text" => $clone_field_key_text,
    );

?>
<div class="acf-vc-hooks-wrapper">
    <div class="acf-vc-hooks-intro">
        <p>
            You can change the way the ACF-VC shows the different fields on the front end using these filter hooks.
        </p>
        <p>
            To use hooks, add your filter hook to your function.php file in your theme or child theme.
        </p>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Text field</h3>
        <p>add_filter('acfvc_text','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Textarea field</h3>
        <p>add_filter('acfvc_textarea','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>WYSIWYG field</h3>
        <p>add_filter('acfvc_wysiwyg','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Number field</h3>
        <p>add_filter('acfvc_number','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Email field</h3>
        <p>add_filter('acfvc_email','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Password field</h3>
        <p>add_filter('acfvc_password','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Image field</h3>
        <p>add_filter('acfvc_image','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>File field</h3>
        <p>add_filter('acfvc_file','function_name',10,4);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$link_text
                <p><?php echo $link_text_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Select field</h3>
        <p>add_filter('acfvc_select','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Checkbox field</h3>
        <p>add_filter('acfvc_checkbox','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Radio button field</h3>
        <p>add_filter('acfvc_radio','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>User field</h3>
        <p>add_filter('acfvc_user','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Page link field</h3>
        <p>add_filter('acfvc_page_link','function_name',10,4);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$link_text
                <p><?php echo $link_text_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Google map field</h3>
        <p>add_filter('acfvc_google_map','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Date picker field</h3>
        <p>add_filter('acfvc_date_picker','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Color picker field</h3>
        <p>add_filter('acfvc_color_picker','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>True/False field</h3>
        <p>add_filter('acfvc_true_false','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Taxonomy field</h3>
        <p>add_filter('acfvc_taxonomy','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Post object field</h3>
        <p>add_filter('acfvc_post_object','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Relationship field</h3>
        <p>add_filter('acfvc_relationship','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Url field</h3>
        <p>add_filter('acfvc_url','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Link field</h3>
        <p>add_filter('acfvc_link','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>oEmbed field</h3>
        <p>add_filter('acfvc_oembed','function_name',10,3);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Gallery field</h3>
        <p>add_filter('acfvc_gallery','function_name',10,4);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$gallery_options
                <p><?php echo $gallery_option_text; ?></p>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Repeater field</h3>
        <p>add_filter('acfvc_repeater','function_name',10,5);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$args
                <p><?php echo $args_text; ?></p>
                <ol>
                  <li>$args["field_key"]
                      <p><?php echo $field_key_text; ?></p>
                  </li>
                  <li>$args["clone_field_key"]
                      <p><?php echo $clone_field_key_text; ?></p>
                  </li>
                  <li>$args["acf_version"]
                      <p><?php echo $acf_version_text; ?></p>
                  </li>
                  <li>$args["link_text"]
                      <p><?php echo $link_text_text; ?></p>
                  </li>
                  <li>$args["gallery_options"]
                      <p><?php echo $gallery_option_text; ?></p>
                  </li>
                </ol>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <div class="acf-vc-hook-wrapper">
        <h3>Repeater inside repeater field</h3>
        <p>add_filter('acfvc_sub_repeater','function_name',10,5);</p>
        <p class="parameters">Parameters</p>
        <ol>
            <li>$output
                <p><?php echo $output_text; ?></p>
            </li>
            <li>$field
                <p><?php echo $field_text; ?></p>
            </li>
            <li>$args
                <p><?php echo $args_text; ?></p>
                <ol>
                  <li>$args["field_key"]
                      <p><?php echo $field_key_text; ?></p>
                  </li>
                  <li>$args["clone_field_key"]
                      <p><?php echo $clone_field_key_text; ?></p>
                  </li>
                  <li>$args["acf_version"]
                      <p><?php echo $acf_version_text; ?></p>
                  </li>
                  <li>$args["link_text"]
                      <p><?php echo $link_text_text; ?></p>
                  </li>
                  <li>$args["gallery_options"]
                      <p><?php echo $gallery_option_text; ?></p>
                  </li>
                </ol>
            </li>
            <li>$post_id
                <p><?php echo $post_id_text; ?></p>
            </li>
        </ol>
    </div>
    <?php do_action("acf_vc_add_to_filter_hook_guide", $text_array) ?>
</div>
