<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
 }

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
    function wcs_woo_remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    return $tabs;
}
 /* Add Show All Products to Woocommerce Shortcode */
function woocommerce_shortcode_display_all_products($args)
{
 if(strtolower(@$args['post__in'][0])=='all')
 {
  global $wpdb;
  $args['post__in'] = array();
  $products = $wpdb->get_results("SELECT ID FROM ".$wpdb->posts." WHERE `post_type`='product'",ARRAY_A);
  foreach($products as $k => $v) { $args['post__in'][] = $products[$k]['ID']; }
 }
 return $args;
}
add_filter('woocommerce_shortcode_products_query', 'woocommerce_shortcode_display_all_products');
// Change 'add to cart' text on archive product page
add_filter( 'woocommerce_product_add_to_cart_text', 'bryce_archive_add_to_cart_text' );
function bryce_archive_add_to_cart_text() {
        return __( 'AGREGAR', 'your-slug' );
}
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
return array(
'width' => 500,
'height' => 500,
'crop' => 0,
);
} );

add_filter( 'yith_wcas_submit_as_input', '__return_false' );
add_filter( 'yith_wcas_submit_label', 'my_yith_wcas_submit_label' );
function my_yith_wcas_submit_label( $label ) { 
    return '<i class="fa fa-search"></i>' . $label; 
}
add_filter( 'woocommerce_product_tabs', 'yikes_remove_description_tab', 20, 1 );

function yikes_remove_description_tab( $tabs ) {

	// Remove the description tab
    if ( isset( $tabs['description'] ) ) unset( $tabs['description'] );      	
    if ( isset( $tabs['additional_information'] ) ) unset( $tabs['additional_information'] );     
    return $tabs;
}

function shortcode_postshome( $atts ){
 $atts = shortcode_atts(
array(
'post_type' => 'product'
), $atts, 'slider-postshome' );

 include 'slider-postshome.php';
}
add_shortcode( 'slider-postshome', 'shortcode_postshome' );

function shortcode_categoriashome( $atts ){
 $atts = shortcode_atts(
array(
'post_type' => 'product'
), $atts, 'slider-categoriashome' );

 include 'slider-categoriashome.php';
}
add_shortcode( 'slider-categoriashome', 'shortcode_categoriashome' );

function shortcode_productoshome( $atts ){
 $atts = shortcode_atts(
array(
'post_type' => 'product'
), $atts, 'slider-productoshome' );

 include 'slider-productoshome.php';
}
add_shortcode( 'slider-productoshome', 'shortcode_productoshome' );

function shortcode_productoshome2( $atts ){
 $atts = shortcode_atts(
array(
'post_type' => 'product'
), $atts, 'slider-productoshome2' );

 include 'slider-productoshome2.php';
}
add_shortcode( 'slider-productoshome2', 'shortcode_productoshome2' );


function shortcode_productoshome3( $atts ){
 $atts = shortcode_atts(
array(
'post_type' => 'product'
), $atts, 'slider-productoshome3' );

 include 'slider-productoshome3.php';
}
add_shortcode( 'slider-productoshome3', 'shortcode_productoshome3' );

function shortcode_productoshome4( $atts ){
 $atts = shortcode_atts(
array(
'post_type' => 'product'
), $atts, 'slider-productoshome4' );

 include 'slider-productoshome4.php';
}
add_shortcode( 'slider-productoshome4', 'shortcode_productoshome4' );

function shortcode_sliderrelacionadosproducto( $atts ){
 $atts = shortcode_atts(
array(
'post_type' => 'product'
), $atts, 'slider-sliderrelacionadosproducto' );

 include 'slider-relacionados-producto.php';
}
add_shortcode( 'slider-sliderrelacionadosproducto', 'shortcode_sliderrelacionadosproducto' );

// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'COMPRAR', 'woocommerce' ); 
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'COMPRAR', 'woocommerce' );
}

if ( ! file_exists( get_template_directory() . '/class-wp-bootstrap-navwalker.php' ) ) {
    // File does not exist... return an error.
    return new WP_Error( 'class-wp-bootstrap-navwalker-missing', __( 'It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {
    // File exists... require it.
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
/**
 * Display category image on category archive
 */
// add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
// function woocommerce_category_image() {
//     if ( is_product_category() ){
//       global $wp_query;
//       $cat = $wp_query->get_queried_object();
//       $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
//       $image = wp_get_attachment_url( $thumbnail_id );
//       if ( $image ) {
//         echo '<img src="' . $image . '" alt="' . $cat->name . '" />';
//     }
//   }
// }
?>