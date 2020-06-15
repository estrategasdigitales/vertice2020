<?php
$destacada = get_post_meta(get_the_ID(), '_wpfp_featured_post');
$postcat = get_the_category(get_the_ID());
?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 element">
<div class="noticia <?php if($destacada[0] == 1){echo 'destacada ';} echo $postcat[0]->slug; ?>">
	<div class="cover"></div>		
	<h4><?php the_title(); ?></h4>
	<p><?php the_excerpt(); ?></p>
	<p class="fecha"><?php echo get_the_date(); ?></p>
	<a href="<?php the_permalink(); ?>">Leer más</a>
</div>
</div>