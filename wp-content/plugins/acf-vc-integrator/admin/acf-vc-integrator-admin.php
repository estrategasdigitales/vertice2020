<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function acf_vc_integrator_admin() {
    ?>
        <div class="wrap">
        <div id="icon-options-general" class="icon32"></div>
        <h1>ACF-VC Integrator</h1>
        <h2>ACF VC Integrator plugin is the easiest way to output your Advanced Custom Post type fields in a WPBakery Page Builder (Visual Composer) Grid.</h2>
 
        <?php
            $active_tab = "default-settings";
            if(isset($_GET["tab"])) {
                $active_tab = $_GET["tab"];
            }
        ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=acf-vc-integrator&tab=default-settings" class="nav-tab <?php if($active_tab == 'default-settings'){echo 'nav-tab-active';} ?> "><?php _e('Default settings', 'acf-vc-integrator'); ?></a>
            <a href="?page=acf-vc-integrator&tab=hooks" class="nav-tab <?php if($active_tab == 'hooks'){echo 'nav-tab-active';} ?> "><?php _e('Hooks', 'acf-vc-integrator'); ?></a>
            <a href="https://wordpress.org/plugins/acf-vc-integrator/#developers" title="<?php _e('Changelog', 'acf-vc-integrator'); ?>" target="_blank" class="nav-tab"><?php _e('Changelog', 'acf-vc-integrator'); ?> <span class="dashicons dashicons-external" aria-hidden="true"></span></a>
        </h2>

        <form method="post" action="options.php">
            <?php

                settings_fields("acfvc_content");
                do_settings_sections("display_acfvc_content");
                do_settings_sections("display_acfvc_gallery");
                do_settings_sections("display_acfvc_google_map");
                if(!isset($_GET["tab"]) OR $_GET["tab"] == "default-settings") {
                    submit_button();
                }

            ?>
        </form>
    </div>
    <?php
}


function acfvc_display_options() {

        if(!isset($_GET["tab"]) OR $_GET["tab"] == "default-settings") {
            require_once ACFVC_PATH.'inc/acf_vc_helper.php';
            require_once ACFVC_PATH.'inc/acf_vc_helper_pro.php';

            add_settings_section("acfvc_content", __("Default settings", "acf-vc-integrator"), "display_acfvc_default_settings_content", "display_acfvc_content");
            add_settings_section("acfvc_content", __("Gallery settings", "acf-vc-integrator"), "display_acfvc_default_settings_gallery", "display_acfvc_gallery");
            add_settings_section("acfvc_content", __("Goolge map settings", "acf-vc-integrator"), "display_acfvc_default_settings_google_map", "display_acfvc_google_map");

            /*default settings*/
            add_settings_field("acfvc_default_show_label", __("Show label", "acf-vc-integrator"), "acfvc_display_show_label_option", "display_acfvc_content", "acfvc_content");
            add_settings_field("acfvc_default_align", __("Align", "acf-vc-integrator"), "acfvc_display_align_option", "display_acfvc_content", "acfvc_content");
            add_settings_field("acfvc_default_email_as_link", __("Email as link", "acf-vc-integrator"), "acfvc_email_as_link_option", "display_acfvc_content", "acfvc_content");
            add_settings_field("acfvc_default_date_format", __("Date format", "acf-vc-integrator"), "acfvc_date_format_option", "display_acfvc_content", "acfvc_content");
            if (class_exists('acf_vc_helper_pro')) {
              add_settings_field("acfvc_default_date_time_format", __("Date Time format", "acf-vc-integrator"), "acfvc_date_time_format_option", "display_acfvc_content", "acfvc_content");
              add_settings_field("acfvc_default_time_format", __("Time format", "acf-vc-integrator"), "acfvc_time_format_option", "display_acfvc_content", "acfvc_content");
            }

            if ( class_exists('acf_vc_helper') ) {
                if ( acf_vc_helper::is_acf_repeater_active( "repeater_check" ) ) {
                    // add_settings_field("acfvc_default_repeater_html", __("Repeater HTML", "acf-vc-integrator"), "acfvc_repeater_html_option", "display_acfvc_content", "acfvc_content");
                    add_settings_field("acfvc_default_repeater_header", __("Repeater header", "acf-vc-integrator"), "acfvc_repeater_header_option", "display_acfvc_content", "acfvc_content");
                }
            }

            /*galery settings*/
            add_settings_field("acfvc_default_gallery_columns", __("Columns", "acf-vc-integrator"), "acfvc_display_gallery_columns_option", "display_acfvc_gallery", "acfvc_content");
            add_settings_field("acfvc_default_gallery_image_size", __("Image size", "acf-vc-integrator"), "acfvc_display_gallery_image_size_option", "display_acfvc_gallery", "acfvc_content");
            add_settings_field("acfvc_default_gallery_order_by", __("Order by", "acf-vc-integrator"), "acfvc_display_gallery_order_by_option", "display_acfvc_gallery", "acfvc_content");
            add_settings_field("acfvc_default_gallery_order", __("Order", "acf-vc-integrator"), "acfvc_display_gallery_order_option", "display_acfvc_gallery", "acfvc_content");
            add_settings_field("acfvc_default_gallery_itemtag", __("Itemtag", "acf-vc-integrator"), "acfvc_display_gallery_itemtag_option", "display_acfvc_gallery", "acfvc_content");
            add_settings_field("acfvc_default_gallery_icontag", __("Icontag", "acf-vc-integrator"), "acfvc_display_gallery_icontag_option", "display_acfvc_gallery", "acfvc_content");
            add_settings_field("acfvc_default_gallery_captiontag", __("Captiontag", "acf-vc-integrator"), "acfvc_display_gallery_captiontag_option", "display_acfvc_gallery", "acfvc_content");
            add_settings_field("acfvc_default_gallery_link", __("Link", "acf-vc-integrator"), "acfvc_display_gallery_link_option", "display_acfvc_gallery", "acfvc_content");

            /*Google map settings */
            add_settings_field("acfvc_default_google_map_placecard", __("Placecard", "acf-vc-integrator"), "acfvc_display_google_map_placecard_option", "display_acfvc_google_map", "acfvc_content");
            add_settings_field("acfvc_default_google_map_zoom", __("Zoom control", "acf-vc-integrator"), "acfvc_display_google_map_zoom_option", "display_acfvc_google_map", "acfvc_content");
            add_settings_field("acfvc_default_google_map_type", __("Type control", "acf-vc-integrator"), "acfvc_display_google_map_type_option", "display_acfvc_google_map", "acfvc_content");
            add_settings_field("acfvc_default_google_map_fullscreen", __("Fullscreen control", "acf-vc-integrator"), "acfvc_display_google_map_fullscreen_option", "display_acfvc_google_map", "acfvc_content");
            add_settings_field("acfvc_default_google_map_street_view", __("Street view", "acf-vc-integrator"), "acfvc_display_google_map_street_view_option", "display_acfvc_google_map", "acfvc_content");
            add_settings_field("acfvc_default_google_map_scale", __("Show scale", "acf-vc-integrator"), "acfvc_display_google_map_scale_option", "display_acfvc_google_map", "acfvc_content");

            register_setting("acfvc_content", "acfvc_default", "acfvc_validate_option_fields");
        } elseif ($_GET["tab"] == "changelog") {
            add_settings_section("acfvc_content", "Changelog", "display_acfvc_changelog_content", "display_acfvc_content");
        } elseif ($_GET["tab"] == "hooks") {
            add_settings_section("acfvc_content", "Hooks", "display_acfvc_hooks_content", "display_acfvc_content");
        }

}

/*content for changelog section*/
function display_acfvc_changelog_content(){ require_once dirname(__FILE__)."/changelog.php"; }
function display_acfvc_hooks_content(){ require_once dirname(__FILE__)."/hooks.php"; }

/*content for general section*/
function display_acfvc_default_settings_content() {
    echo "Set some default settings to use for acf-vc element";
}
/*content for gallery section*/
function display_acfvc_default_settings_gallery() {}
function display_acfvc_default_settings_google_map() {}

/*General element settings - show label*/
function acfvc_display_show_label_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('show_label',$acfvc_option['general'])) {
            $option_value = $acfvc_option['general']['show_label'];
        }
    }
    ?>
        <select name="acfvc_default[general][show_label]" id="acfvc_show_label">
            <option <?php if($option_value == '') echo "selected"; ?> value=""><?php _e( 'No', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'yes') echo "selected"; ?> value="yes"><?php _e( 'Yes', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'yes_no') echo "selected"; ?> value="yes_no"><?php _e( 'Yes and hide if no result', 'acf-vc-integrator' ); ?></option>
        </select>
    <?php
}

/*General element settings - align*/
function acfvc_display_align_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('align',$acfvc_option['general'])) {
            $option_value = $acfvc_option['general']['align'];
        }
    }
    ?>
        <select name="acfvc_default[general][align]" id="acfvc_align">
            <option <?php if($option_value == 'left') echo "selected"; ?> value="left"><?php _e( 'left', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'right') echo "selected"; ?> value="right"><?php _e( 'right', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'center') echo "selected"; ?> value="center"><?php _e( 'center', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'justify') echo "selected"; ?> value="justify"><?php _e( 'justify', 'acf-vc-integrator' ); ?></option>
        </select>
    <?php
}

/*General element settings - email as link*/
function acfvc_email_as_link_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('email_as_link',$acfvc_option['general'])) {
            $option_value = $acfvc_option['general']['email_as_link'];
        }
    }
    $checked = "";
    if ($option_value == true) {
        $checked = "checked";
    }
    ?>
    <input type="checkbox"id="acfvc_email_as_link" name="acfvc_default[general][email_as_link]" value="true" <?php echo $checked; ?>>
    <?php
}

/*General element settings - Date format*/
function acfvc_date_format_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('date_format',$acfvc_option['general'])) {
            $option_value = $acfvc_option['general']['date_format'];
        }
    }
    ?>
        <select name="acfvc_default[general][date_format]" id="acfvc_date_format">
            <option <?php if($option_value == 'wp_default') echo "selected"; ?> value="wp_default"><?php _e( 'WordPress date format', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'acf_default') echo "selected"; ?> value="acf_default"><?php _e( 'ACF return format', 'acf-vc-integrator' ); ?></option>
        </select>
    <?php
}

/*General element settings - Date TIme format*/
function acfvc_date_time_format_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('date_time_format',$acfvc_option['general'])) {
            $option_value = $acfvc_option['general']['date_time_format'];
        }
    }
    ?>
        <select name="acfvc_default[general][date_time_format]" id="acfvc_date_time_format">
            <option <?php if($option_value == 'wp_default') echo "selected"; ?> value="wp_default"><?php _e( 'WordPress date time format', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'acf_default') echo "selected"; ?> value="acf_default"><?php _e( 'ACF return format', 'acf-vc-integrator' ); ?></option>
        </select>
    <?php
}

/*General element settings - Time format*/
function acfvc_time_format_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('time_format',$acfvc_option['general'])) {
            $option_value = $acfvc_option['general']['time_format'];
        }
    }
    ?>
        <select name="acfvc_default[general][time_format]" id="acfvc_time_format">
            <option <?php if($option_value == 'wp_default') echo "selected"; ?> value="wp_default"><?php _e( 'WordPress time format', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'acf_default') echo "selected"; ?> value="acf_default"><?php _e( 'ACF return format', 'acf-vc-integrator' ); ?></option>
        </select>
    <?php
}

/*General element settings - Repeater html*/
function acfvc_repeater_html_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ( $acfvc_option && array_key_exists( 'repeater',$acfvc_option ) ) {
        if (array_key_exists('html',$acfvc_option['repeater'])) {
            $option_value = $acfvc_option['repeater']['html'];
        }
    }
    ?>
        <select name="acfvc_default[repeater][html]" id="acfvc_repeater_html">
            <option <?php if($option_value == 'div') echo "selected"; ?> value="div"><?php _e( 'div', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'table') echo "selected"; ?> value="table"><?php _e( 'table', 'acf-vc-integrator' ); ?></option>
        </select>
    <?php
}

/*General element settings - Repeater header*/
function acfvc_repeater_header_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ( $acfvc_option && array_key_exists( 'repeater',$acfvc_option ) ) {
        if (array_key_exists('header',$acfvc_option['repeater'])) {
            $option_value = $acfvc_option['repeater']['header'];
        }
    }
    ?>
        <select name="acfvc_default[repeater][header]" id="acfvc_repeater_header">
            <option <?php if($option_value == '') echo "selected"; ?> value=""><?php _e( 'Hide repeater header', 'acf-vc-integrator' ); ?></option>
            <option <?php if($option_value == 'show') echo "selected"; ?> value="show"><?php _e( 'Show repeater header', 'acf-vc-integrator' ); ?></option>
        </select>
    <?php
}



/*Gallery columns settings*/
function acfvc_display_gallery_columns_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('columns',$acfvc_option['gallery'])) {
            $option_value = $acfvc_option['gallery']['columns'];
        }
    }
    ?>
        <select name="acfvc_default[gallery][columns]" id="acfvc_gallery_columns">
            <option <?php if($option_value == '1') echo "selected"; ?> value="1">1</option>
            <option <?php if($option_value == '2') echo "selected"; ?> value="2">2</option>
            <option <?php if($option_value == '3') echo "selected"; ?> value="3">3</option>
            <option <?php if($option_value == '4') echo "selected"; ?> value="4">4</option>
            <option <?php if($option_value == '5') echo "selected"; ?> value="5">5</option>
            <option <?php if($option_value == '6') echo "selected"; ?> value="6">6</option>
            <option <?php if($option_value == '7') echo "selected"; ?> value="7">7</option>
            <option <?php if($option_value == '8') echo "selected"; ?> value="8">8</option>
            <option <?php if($option_value == '9') echo "selected"; ?> value="9">9</option>
        </select>
    <?php
}

/*Gallery image sieze settings*/
function acfvc_display_gallery_image_size_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('image_size',$acfvc_option['gallery'])) {
            $option_value = $acfvc_option['gallery']['image_size'];
        }
    }
    $wp_image_sizes = get_intermediate_image_sizes();
    $wp_image_sizes_array = array();
    foreach ($wp_image_sizes as $key => $value) {
        $wp_image_sizes_array[$value] = $value;
    }
    ?>
        <select name="acfvc_default[gallery][image_size]" id="acfvc_gallery_image_size">
            <?php
                foreach ($wp_image_sizes_array as $key => $value) {
                ?>
                    <option <?php if($option_value == $value) echo "selected"; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php
                }
            ?>
        </select>
    <?php
}

/*Gallery order by settings*/
function acfvc_display_gallery_order_by_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('order_by',$acfvc_option['gallery'])) {
            $option_value = $acfvc_option['gallery']['order_by'];
        }
    }
    ?>
        <select name="acfvc_default[gallery][order_by]" id="acfvc_gallery_order_by">
            <option <?php if($option_value == 'ID') echo "selected"; ?> value="ID"><?php _e("ID", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 'menu_order') echo "selected"; ?> value="menu_order"><?php _e("Menu order", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 'title') echo "selected"; ?> value="title"><?php _e("Title", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 'post_date') echo "selected"; ?> value="post_date"><?php _e("Post date", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 'rand') echo "selected"; ?> value="rand"><?php _e("Random", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*Gallery order settings*/
function acfvc_display_gallery_order_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('order',$acfvc_option['gallery'])) {
            $option_value = $acfvc_option['gallery']['order'];
        }
    }
    ?>
        <select name="acfvc_default[gallery][order]" id="acfvc_gallery_corder">
            <option <?php if($option_value == 'ASC') echo "selected"; ?> value="ASC"><?php _e("ASC", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 'DESC') echo "selected"; ?> value="DESC"><?php _e("DESC", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*Gallery itemtag settings*/
function acfvc_display_gallery_itemtag_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('itemtag',$acfvc_option['gallery'])) {
            $option_value = $acfvc_option['gallery']['itemtag'];
        }
    }
    ?>
        <input type="text" name="acfvc_default[gallery][itemtag]" id="acfvc_gallery_itemtag" value="<?php echo $option_value; ?>">
    <?php
}
/*Gallery icontag settings*/
function acfvc_display_gallery_icontag_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('icontag',$acfvc_option['gallery'])) {
            $option_value = $acfvc_option['gallery']['icontag'];
        }
    }
    ?>
        <input type="text" name="acfvc_default[gallery][icontag]" id="acfvc_gallery_icontag" value="<?php echo $option_value; ?>">
    <?php
}
/*Gallery captiontag settings*/
function acfvc_display_gallery_captiontag_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('captiontag',$acfvc_option['gallery'])) {
            $option_value = $acfvc_option['gallery']['captiontag'];
        }
    }
    ?>
        <input type="text" name="acfvc_default[gallery][captiontag]" id="acfvc_gallery_captiontag" value="<?php echo $option_value; ?>">
    <?php
}

/*Gallery link settings*/
function acfvc_display_gallery_link_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if (array_key_exists('link',$acfvc_option['gallery'])) {
            $option_value = $acfvc_option['gallery']['link'];
        }
    }
    ?>
        <select name="acfvc_default[gallery][link]" id="acfvc_gallery_columns">
            <option <?php if($option_value == 'none') echo "selected"; ?> value="none"><?php _e("None", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 'file') echo "selected"; ?> value="file"><?php _e("File", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*Google map placecard settings */
function acfvc_display_google_map_placecard_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if ( array_key_exists( 'google_map', $acfvc_option ) ) {
            if (array_key_exists('placecard',$acfvc_option['google_map'])) {
                $option_value = $acfvc_option['google_map']['placecard'];
            }
        } else {
            $option_value = 1;
        }
    }
    ?>
        <select name="acfvc_default[google_map][placecard]" id="acfvc_google_map_columns">
            <option <?php if($option_value == 0) echo "selected"; ?> value=0><?php _e("No", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 1) echo "selected"; ?> value=1><?php _e("Yes", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*Google map zoom settings */
function acfvc_display_google_map_zoom_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if ( array_key_exists( 'google_map', $acfvc_option ) ) {
            if (array_key_exists('zoom',$acfvc_option['google_map'])) {
                $option_value = $acfvc_option['google_map']['zoom'];
            }
        } else {
            $option_value = 1;
        }
    }
    ?>
        <select name="acfvc_default[google_map][zoom]" id="acfvc_google_map_columns">
            <option <?php if($option_value == 0) echo "selected"; ?> value=0><?php _e("No", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 1) echo "selected"; ?> value=1><?php _e("Yes", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*Google map type settings */
function acfvc_display_google_map_type_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if ( array_key_exists( 'google_map', $acfvc_option ) ) {
            if (array_key_exists('type',$acfvc_option['google_map'])) {
                $option_value = $acfvc_option['google_map']['type'];
            }
        } else {
            $option_value = 1;
        }
    }
    ?>
        <select name="acfvc_default[google_map][type]" id="acfvc_google_map_columns">
            <option <?php if($option_value == 0) echo "selected"; ?> value=0><?php _e("No", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 1) echo "selected"; ?> value=1><?php _e("Yes", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*Google map fullscreen settings */
function acfvc_display_google_map_fullscreen_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if ( array_key_exists( 'google_map', $acfvc_option ) ) {
            if (array_key_exists('fullscreen',$acfvc_option['google_map'])) {
                $option_value = $acfvc_option['google_map']['fullscreen'];
            }
        } else {
            $option_value = 0;
        }
    }
    ?>
        <select name="acfvc_default[google_map][fullscreen]" id="acfvc_google_map_columns">
            <option <?php if($option_value == 0) echo "selected"; ?> value=0><?php _e("No", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 1) echo "selected"; ?> value=1><?php _e("Yes", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*Google map street view settings */
function acfvc_display_google_map_street_view_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if ( array_key_exists( 'google_map', $acfvc_option ) ) {
            if (array_key_exists('street_view',$acfvc_option['google_map'])) {
                $option_value = $acfvc_option['google_map']['street_view'];
            }
        } else {
            $option_value = 0;
        }
    }
    ?>
        <select name="acfvc_default[google_map][street_view]" id="acfvc_google_map_columns">
            <option <?php if($option_value == 0) echo "selected"; ?> value=0><?php _e("No", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 1) echo "selected"; ?> value=1><?php _e("Yes", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*Google map scale settings */
function acfvc_display_google_map_scale_option() {
    $acfvc_option = get_option('acfvc_default');
    $option_value = "";
    if ($acfvc_option) {
        if ( array_key_exists( 'google_map', $acfvc_option ) ) {
            if (array_key_exists('scale',$acfvc_option['google_map'])) {
                $option_value = $acfvc_option['google_map']['scale'];
            }
        } else {
            $option_value = 0;
        }
    }
    ?>
        <select name="acfvc_default[google_map][scale]" id="acfvc_google_map_columns">
            <option <?php if($option_value == 0) echo "selected"; ?> value=0><?php _e("No", "acf-vc-integrator") ?></option>
            <option <?php if($option_value == 1) echo "selected"; ?> value=1><?php _e("Yes", "acf-vc-integrator") ?></option>
        </select>
    <?php
}

/*validate and sanitize fields*/
function acfvc_validate_option_fields($input) {
    foreach ($input as $key_input => $value_input) {
        foreach ($value_input as $key => $value) {
            $input[$key_input][$key] = sanitize_text_field($input[$key_input][$key]);
        }

    }
    return $input;
}

add_action("admin_init", "acfvc_display_options");

 ?>
