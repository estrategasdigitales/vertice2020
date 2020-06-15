<?php
$options = rrj_charts::get_option();
$t_sep = $options['t-separator'];
if ( empty( $t_sep ) ) {
	$t_sep =  __( 'empty', 'rrj-ac' );
} else {
	if ( '' == trim( $t_sep ) ) {
		$t_sep = '<strong><code>&laquo;' . $t_sep . '&raquo;</code></strong> <em>( ' . __( 'blank space(s)', 'rrj-ac' ) . ' )</em>';
	} else {
		$t_sep = '<strong><code>&laquo;' . $t_sep . '&raquo;</code></strong>';
	}
}
?>
<div class="form-wrap">
	<form name="char-settings" id="chart-settings">
		<h4 class="section-head"><?php _e( 'Axes and grid color', 'rrj-ac' ); ?></h4>
		<div class="form-field">
			<label>
				<input type="checkbox" name="force-axes-color" value="1" <?php checked( $options['force-axes-color'] ); ?> />
				<?php _e( 'Use global axis and grid color', 'rrj-ac' ); ?>
			</label>
			<p class="description"><?php _e( 'Ignore individual chart settings and use the color below for all chart axes and grid', 'rrj-ac' ); ?></p>
			<input type="text" name="axes-color" class="color-input" value="<?php echo $options['axes-color']; ?>" />
		</div>
		<h4 class="section-head"><?php _e( 'Legends font size', 'rrj-ac' ) ?></h4>
		<div class="form-field">
			<input type="number" style="width:8em;" name="legend-font-size" min="8" value="<?php echo esc_attr( $options['legend-font-size'] ); ?>" />&nbsp;<b>px</b>
			<p class="description"><?php _e( 'font size for legends in pixels', 'rrj-ac' ); ?></p>
		</div>
		<h4 class="section-head"><?php _e( 'Legends font color', 'rrj-ac' ) ?></h4>
		<div class="form-field">
			<input type="text" name="legend-font-color" class="color-input" value="<?php echo $options['legend-font-color']; ?>" />
		</div>
		<h4 class="section-head"><?php _e( 'Font family', 'rrj-ac' ); ?></h4>
		<div class="form-field">
			<input type="text" name="font-family" class="widefat" value="<?php echo esc_attr( $options['font-family'] ); ?>" />
			<p class="description"><?php _e( 'Default font family for all charts.', 'rrj-ac' ); ?>&nbsp;<i class="dashicons dashicons-info"></i>&nbsp;<?php
			_e( 'If it&#39;s a web font (like Google Fonts), it must be loaded elsewhere (from the current theme or an active plugin).', 'rrj-ac' ); ?></p>
		</div>
		<h4 class="section-head"><?php _e( 'Thousand separator', 'rrj-ac' ); ?></h4>
		<div class="form-field">
			<input type="text" name="t-separator" style="width:6em;font-weight:700;" value="<?php echo esc_attr( $options['t-separator'] ); ?>" />
			<p class="description"><?php printf( __( 'This separator will be applied to all axes and all tooltips. Leave empty to not use it. Currently %s', 'rrj-ac' ), $t_sep ); ?></p>
		</div>
		<h4 class="section-head"><?php _e( 'Chart initialization', 'rrj-ac' ); ?></h4>
		<div class="form-field">
			<input name="init" style="width:8em;" type="number" min="0" max="100" value="<?php echo esc_attr( $options['init'] ); ?>" >&nbsp;<b>%</b>
			<p class="description"><?php _e( "Delay (relative to the chart's real time height) after which a chart will be initialized.", 'rrj-ac' ); ?><br />
			<?php _e( '0 corresponds the the instant while the chart in entering the screen, and 100 the instant while the bottom of the chart is visible on the screen', 'rrj-ac' ); ?></p>
		</div>
		<p class="submit">
			<button class="button-primary" id="save-settings"><?php _e( 'Save Changes', 'rrj-ac' ); ?></button>
			<button class="button-secondary" id="reset-settings"><?php _e( 'Restore defaults', 'rrj-ac' ); ?></button>
		</p>
	</form>
</div>