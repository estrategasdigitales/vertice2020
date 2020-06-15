<?php
/**
 * Footer
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

if ( visualcomposerstarter_is_the_footer_displayed() ) : ?>
	<?php visualcomposerstarter_hook_before_footer(); ?>
	<footer id="footer">	
		<div class="row">
			<div class="container contfooter">
        <div class="col-md-12 text-center contfoots">
          <img class="logofoot" src="<?php echo site_url(); ?>/wp-content/themes/visual-composer-starter-child/img/logofooter.png">
          <a target="_blank"  class="iconfoo" href="https://www.instagram.com/"  target="_blank"><i class="fab fa-instagram"></i></a>
          <a target="_blank" class="iconfoo" href="https://www.facebook.com/"><i class="fab fa-facebook-square" target="_blank"></i></a>
        </div>
				<div class="col-md-3 aliglis">
					
				

					<p>Isabel La Católica 455, Algarín</p>
          <p>Ciudad de México, CDMX.</p>
					<p>55 1243 1890</p>
					<p><a>info@verticeindustrial.com</a></p>
					
					
					
				</div>
				<div class="col-md-3 footsupr">
					
					
					<p><a href="<?php echo site_url(); ?>/preguntas-frecuentes/">Preguntas frecuentes</a></p>
					<!-- <p><a href="<?php echo site_url(); ?>/terminos-y-condiciones/">Términos y condiciones</a></p> -->
					<p><a href="<?php echo site_url(); ?>/aviso-de-privacidad/">Aviso de privacidad</a></p>

				</div>
        <div class="col-md-1 footsupr">
				</div>
				<div class="col-md-2 col-xs-6 footsupr">
					<!-- <p><a href="<?php echo site_url(); ?>/product-category/muebles/">Muebles</a></p>
					<p><a href="<?php echo site_url(); ?>/product-category/electronica/">Electrónica</a></p>
					<p><a href="<?php echo site_url(); ?>/product-category/pantallas/">Pantallas</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/linea-blanca/">Línea Blanca</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/belleza-y-cuidado-personal/">Belleza y cuidado personal</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/colchones/">Colchones</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/audio_y_video/">Audio y Video</a></p> -->

					
				</div>
				<div class="col-md-2  col-xs-6 footsupr">
					<!-- <p><a href="<?php echo site_url(); ?>/product-category/relojes/">Relojes</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/bicicletas/">Bicicletas</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/electrodomesticos/">Electrodomésticos</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/computo/">Cómputo</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/telefonia/">Telefonía</a></p>
          <p><a href="<?php echo site_url(); ?>/product-category/ventiladores-y-aires-acond/">Ventiladores y aires acond.</a></p> -->
				</div>
				


				
			</div>
			
		</div>
		<div class="row" style="">
			<div class="container text-center">
					<span style="color:#ffffff"><?php echo date("Y");?> Todos los derechos reservados</span>
					
			</div>
		</div>
	</footer>




<script type="text/javascript">
	// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the header
var header = document.getElementById("myHeader");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}



    $(document).ready(function(){
      $('.posteoshome').slick({
        	responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
      });
      $('.productoshome').slick({
        	responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
      });
    });


$('.contenedorprodc').hover(function(){
    $(this).find('.sombrarosa').show();
},function(){
     $(this).find('.sombrarosa').hide();
});


  </script>
<script>
function openSearch() {
  document.getElementById("myOverlay").style.display = "block";
}

function closeSearch() {
  document.getElementById("myOverlay").style.display = "none";
}
</script>



	<?php visualcomposerstarter_hook_after_footer(); ?>
<?php endif; ?>
<?php wp_footer(); ?>

</body>
</html>




