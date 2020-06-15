<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */
?>
<article class="" id="post-<?php the_ID(); ?>" <?php post_class( 'entry-preview' ); ?>>

<a class="contenedorprodc" href="<?php echo get_permalink(); ?>">
	<?php echo get_the_post_thumbnail( $page->ID, 'full' ); ?>
	

		<div class="infoproducto">
            <p><?php the_title(); ?><p>
            <div class="btncomprhome">
                <span>Ver producto</span>
            </div>
        </div>
	
	
</a>



</article><!--.entry-preview-->
