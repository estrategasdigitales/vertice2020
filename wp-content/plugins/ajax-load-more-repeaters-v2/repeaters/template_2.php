<?php
echo '<div class="col-lg-4"><div class="post-bloque">';	
	echo '<div class="info"><h5>';
	echo the_title();
	echo '</h5>';
	echo '<p>';
	$excerpt = get_the_excerpt(get_the_id());
	echo wp_trim_words($excerpt, 8, ' ...' );
	echo '</p>';
	echo '<a href="';
	echo the_permalink();
	echo '">LEER MÁS</a></div>';
	echo '<div style="background-image:url(';
	$img_url = get_the_post_thumbnail_url(get_the_id(),'full');	
	if (!empty($img_url) || $img_url!=null) {		
		echo $img_url;		
	}else{
		echo 'https://dummyimage.com/300x300/ededed/000000.jpg&text=FMYP';		
	}	
	echo ')" class="img-post"></div>';
echo '</div></div>';
?>