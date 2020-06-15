<div class="container productoshome" data-slick='{"slidesToShow": 4, "slidesToScroll": 2}'>

<?php 
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'product_cat' => 'ofertas',
    );
    $query = new WP_Query($args);
    foreach($query->posts as $p):
    $pid = $p->ID;
    $product = wc_get_product($pid);
    
?>
<div class="col-md-12">
    <a class="contenedorprodc" href="<?php echo get_permalink($pid); ?>">
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $pid  ), 'single-post-thumbnail' );?>
    <img src="<?php  echo $image[0]; ?>">
        <div class="infoproducto">
            <p><?php echo $p->post_title; ?><p>
            <span><?php echo $product->get_price_html(); ?></span>
            <div class="btncomprhome">
                <span>COMPRAR</span>
            </div>
        </div>
        <?php
        
        ?>
        
    </a>
</div>


<?php endforeach; ?>
</div>