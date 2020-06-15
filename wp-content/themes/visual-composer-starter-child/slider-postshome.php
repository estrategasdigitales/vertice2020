<div class="container posteoshome" data-slick='{"slidesToShow": 3, "slidesToScroll": 3}'>
<?php
    $args = array(
        'post_type' => 'post'
    );

    $post_query = new WP_Query($args);

    if($post_query->have_posts() ) {
        while($post_query->have_posts() ) {
            $post_query->the_post();
            ?>
            <div class="col-md-12">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( 'full' ); ?>
                    <h2><?php the_title(); ?></h2>
                    <?php visualcomposerstarter_entry_meta(); ?>
                </a>
            </div>

            <?php
            }
        }
?>
</div>