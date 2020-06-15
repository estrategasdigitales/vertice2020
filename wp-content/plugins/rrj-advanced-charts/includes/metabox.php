<?php
$meta = get_post_meta( $post->ID, RRJ_AC_METAINIT, true );
$default = array(
	'enabled' => false,
	'value' => 33,
);
if ( !is_array( $meta ) ) {
	$meta = array();
}
$meta += $default;
?>
<p>
	<input type="checkbox" value="1" name="rrjac[enabled]" <?php checked( $meta['enabled'] ) ?> />
	<label><b><?php _e( 'Override default setting', 'rrj-ac' ) ?></b></label>
</p>
<p class="description"><?php _e( 'If checked, blog wide setting will be ignored on this page', 'rrj-ac' ) ?></p>
<p><label><b><?php _e( 'Delay', 'rrj-ac' ) ?></b></label></p>
</p><input type="number" name="rrjac[value]" min="0" max="100" step="1" value="<?php echo absint( $meta['value'] ) ?>" />&nbsp;<b>%</b></p>
<p class="description"><?php _e( "Delay (relative to the chart's real time height) after which a chart will be initialized.", 'rrj-ac' ) ?></p>
