<?php  
// function woocommerce_subcats_from_parentcat_by_NAME($parent_cat_NAME) {
// $IDbyNAME = get_term_by('name', $parent_cat_NAME, 'product_cat');
// $product_cat_ID = $IDbyNAME->term_id;
// $args = array(
//    'hierarchical' => 1,
//    'show_option_none' => '',
//    'hide_empty' => 0,
//    'parent' => $product_cat_ID,
//    'taxonomy' => 'product_cat'
// );

// $subcats = get_categories($args);
// echo '<div class="container">';
//   foreach ($subcats as $sc) {
//   	$thumbnail_id = get_woocommerce_term_meta( $sc->term_id, 'thumbnail_id', true );
// 	$image = wp_get_attachment_url( $thumbnail_id );
//     $link = get_term_link( $sc->slug, $sc->taxonomy );
//       echo '<div class="categoriashome a'.$sc->term_id.'">';
//       echo '<a href="'. $link .'">'.$sc->name.'</a>';
//       echo  '<a href="'. $link .'"><img src="'.$image.'"></a></div>';
//   }
// echo '</div>';
// } 

// echo woocommerce_subcats_from_parentcat_by_NAME('categorias');
?>