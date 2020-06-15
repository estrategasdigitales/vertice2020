<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
<div class="entrada dispositivo">
	<p><b><?php the_title(); ?></b></p>
	<p><?php 
	if (isset($_GET["lang"]) & $_GET["lang"] == 	"en") {
	echo the_field('brand');
	}else{
	echo the_field('marca');			
	}
    ?></p>
	<?php the_post_thumbnail('full'); ?>    
	<hr>
	<p><b>Dimensions:</b> <?php echo the_field('dimensions'); ?></p>
	<p><b>F Cam:</b> <?php echo the_field('f_cam'); ?></p>
	<p><b>B Cam:</b> <?php echo the_field('b_cam'); ?></p>
	<p><b>Memory:</b> <?php echo the_field('memory'); ?></p>
	<p><b>CPU:</b> <?php echo the_field('cpu'); ?></p>
	<p><b>Spec:</b> <?php echo the_field('spectrum'); ?></p>
</div>
</div>