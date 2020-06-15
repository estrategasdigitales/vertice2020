
<div class="wrap">
	<div class="nav-tab-wrapper">
		<a class="nav-tab" href="#charts-settings-div"><?php _e( 'Default Charts Settings', 'rrj-ac' ); ?></a>
		<a class="nav-tab" href="#php-functions-div"><?php _e( 'PHP data functions', 'rrj-ac' ); ?></a>
	</div>
	<input type="hidden" id="settings-nonce" value="<?php echo wp_create_nonce( 'rrj-settings' ); ?>" />
	<div id="charts-settings-div" class="nav-tab-div"><?php require_once RRJ_AC_PATH . 'includes/tab-charts-settings.php' ?></div>
	<div id="php-functions-div"class="nav-tab-div"><?php require_once RRJ_AC_PATH . 'includes/tab-php-functions.php' ?></div>
	<div id="loading-overlay">
		<img alt="..." src="<?php echo esc_url( RRJ_AC_URL . '/assets/images/loading.gif' ); ?>" />
	</div>
</div>