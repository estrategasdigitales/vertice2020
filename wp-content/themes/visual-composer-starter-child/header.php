<?php
/**
 * Header
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php visualcomposerstarter_hook_after_head(); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  
  <script src="https://kit.fontawesome.com/656d775063.js" crossorigin="anonymous"></script>


 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
  <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">


   <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/visual-composer-starter-child/css/slick.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/visual-composer-starter-child/css/slick-theme.css"/>
  <script src="<?php echo site_url(); ?>/wp-content/themes/visual-composer-starter-child/js/slick.js" type="text/javascript" charset="utf-8"></script>
  <script
  src="<?php echo get_site_url(); ?>/wp-content/themes/visual-composer-starter-child/js/scripts.js"></script>
<script src="https://kit.fontawesome.com/d718b59fa5.js" crossorigin="anonymous"></script>

	<?php wp_head() ?>
</head>
<body <?php body_class(); ?>>
<header id="header">
<div id="myOverlay" class="overlay">
  <span class="closebtn" onclick="closeSearch()" title="Close Overlay">x</span>
  <div class="overlay-content">
   <?php get_search_form(); ?>
  </div>
</div>
  
    
  </header>


  
 <nav  id="myHeader" class="navbar navbar-inverse navbar-fixed-top">
  <div class="row barrasuperior">
    <div class="container">
      <div class="navbar-header col-md-2">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo site_url(); ?>/wp-content/themes/visual-composer-starter-child/img/logo.png"></a>
      </div>
      <div class="collapse navbar-collapse col-md-10" id="myNavbar">
        <div class="col-md-12">
          <div class="col-md-2">
            </div>
          <div class="col-md-4">
            <?php get_search_form(); ?>
             
          </div>
          <div class="col-md-6">
          </div>
        </div>
        <div class="col-md-12">
          <div class="col-md-1">
            </div>
          <div class="col-md-11">
            <ul class="nav navbar-nav menudespliega">

              <?php
          wp_nav_menu( array(
              'theme_location'    => 'primary',
              'depth'             => 2,
              'container'         => 'div',
              'container_class'   => 'collapse navbar-collapse',
              'container_id'      => 'bs-example-navbar-collapse-1',
              'menu_class'        => 'nav navbar-nav',
              'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
              'walker'            => new WP_Bootstrap_Navwalker(),
          ) );
          ?>
              <!-- <li class="active"><a href="#">Home</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Page 1-1</a></li>
                  <li><a href="#">Page 1-2</a></li>
                  <li><a href="#">Page 1-3</a></li>
                </ul>
              </li>
              <li><a href="#">Page 1</a></li>
              <li><a href="#">Page 2</a></li>
              <li><a href="#">Page 3</a></li> -->
              <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
              <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </ul>
            <ul class="nav navbar-nav navbar-right lateralderecho">
                
                <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><i class="fa fa-shopping-cart"></i> (<?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?>)</a>
                  <?php if ( is_user_logged_in() ) { ?>
                    <a class="enlacecuenta" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','woothemes'); ?>"><?php _e('Mi cuenta','woothemes'); ?></a>
                   <?php } 
                   else { ?>
                    <a class="enlacecuenta" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Entrar','woothemes'); ?></a>
                   <?php } 
                   ?>

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
