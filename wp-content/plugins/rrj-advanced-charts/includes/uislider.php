<?php
$min = !empty( $settings['min'] )? absint( $settings['min'] ) : 0;
$min = ( 0 > $min )? 0 : $min; 
$max = !empty( $settings['max'] )? absint( $settings['max'] ) : 255;
$max = ( 255 < $max )? 255 : $max;
$step = !empty( $settings['step'] )? absint( $settings['step'] ) : 1;
$step = ( ( $max - $min ) < $step )? $max - $min : $step;
$id = wp_generate_password( 20, false );
?><div class="rrj-uislider-container" id="<?php echo $id; ?>">
	<div class="rrj-uislider-display"><span><?php echo $value ?></span></div>
	<div class="rrj-uislider-holder"><div class="rrj-uislider-slider"></div></div>
	<input type="hidden" name="<?php echo esc_attr( $settings['param_name'] ); ?>"
	data-min="<?php echo $min; ?>" data-max="<?php echo $max; ?>" data-step="<?php echo $step; ?>"
	value="<?php echo esc_attr( $value ); ?>"
	class="wpb_vc_param_value rrj-uislider-input <?php echo esc_attr( $settings['param_name'] ) . ' ' .
	esc_attr( $settings['type'] ) ?>_field" />
</div>
<script type="text/javascript">
if ( 'function' == typeof window.rrjUiSlider ) {
	new window.rrjUiSlider( '<?php echo $id; ?>' );
}
</script>