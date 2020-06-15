<?php
$id = wp_generate_password( 20, false );
?><div class="rrj-jseditor-container" style="border:1px solid #d6d6d6;padding:4px;font-size:0.8em;">
<input type="hidden" id="<?php echo $id; ?>" name="<?php echo esc_attr( $settings['param_name'] ); ?>"
class="wpb_vc_param_value <?php echo esc_attr( $settings['param_name'] ) . ' ' .
	esc_attr( $settings['type'] ) ?>_field" value="<?php echo esc_attr( $value ); ?>" />
</div>
<script type="text/javascript">
if ( 'function' == typeof window.rrjJsEditor ) {
	new window.rrjJsEditor( '<?php echo $id; ?>' );
}
</script>