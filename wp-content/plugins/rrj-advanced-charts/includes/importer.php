<div class="rrj-csv-importer-wrap" id="<?php $_param_id = wp_generate_password( 16, false ); echo $_param_id; ?>">
	<input type="hidden" name="<?php echo esc_attr( $settings['param_name'] ); ?>"
	class="data-holder wpb_vc_param_value <?php echo esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) ?>_field" value="<?php echo esc_attr( $value ); ?>" />
	<input type="hidden" class="type-holder" value="<?php echo $settings['set_type']; ?>" />
	<input type="hidden" class="rrj-importer-nonce" value="<?php echo wp_create_nonce( 'rrj-importer' ); ?>" />
	<div class="form-group">
		<p><button class="button-secondary file-btn"><?php _e( 'Choose file', 'rrj-ac' ); ?></button></p>
		<p class="file-name description"></p>
		<p class="file-notice"></p>
	</div>
	<br />
	<input type="hidden" class="file-id" value="" />
	<input type="hidden" class="file-desc" value="" />
	<div class="form-group">
		<div class="wpb_element_label"><?php _e( 'Data set orientation', 'rrj-ac' ); ?></div>
		<select class="set-orientation">
			<option value="rows"><?php _e( 'Rows as data sets', 'rrj-ac' ); ?></option>
			<option value="cols"><?php _e( 'Columns as data sets', 'rrj-ac' ); ?></option>
		</select>
	</div>
	<br />
	<div class="form-group">
		<div class="wpb_element_label"><?php _e( 'Headers', 'rrj-ac' ); ?></div>
		<select class="set-header">
			<option value="1st"><?php _e( 'First row as labels (first column for set in columns)', 'rrj-ac' ); ?></option>
			<option value="skip"><?php _e( 'Skip the firt row (first column for set in columns)', 'rrj-ac' ); ?></option>
			<option value="none"><?php _e( 'No header', 'rrj-ac' ); ?></option>
		</select>
	</div>
	<br />
	<div class="form-group">
		<p><button class="button-primary import-btn" disabled><?php _e( 'Import data', 'rrj-ac' ); ?></button></p>
	</div>
	<div class="form-group imported-data-group" style="display:none;">
		<hr />
		<h3><?php _e( 'Imported data', 'rrj-ac' ); ?></h3>
		<p class="import-warning">
			<i class="dashicons dashicons-warning"></i>
			<?php _e( 'imported dataset count does not match the dataset count in the "General" tab', 'rrj-ac' ); ?>
		</p>
		<div class="editor">
			<div class="wpb_element_label"><?php _e( 'Labels', 'rrj-ac' ); ?></div>
			<div class="labels-wrap"></div>
			<div class="wpb_element_label"><?php _e( 'Data sets', 'rrj-ac' ); ?></div>
			<div class="sets-wrap"></div>
		</div>
		<p class="clear-data" style="display:none;"><button class="button-secondary"><?php _e( 'Clear data', 'rrj-ac' ); ?></button></p>
	</div>
<script type="text/template" class="text-input-template">
<div class="imported-data-field" data-type="%type%">
	<div class="head">
		<i class="vc-composer-icon vc-c-icon-dragndrop"></i>
		<i class="vc-composer-icon vc-c-icon-content_copy"></i>
		<i class="vc-composer-icon vc-c-icon-delete_empty"></i>
	</div>
	<div class="body">
		<input type="text" class="textfield" value="" />
	</div>
</div>
</script>
</div>
<script type="text/javascript">
new window.rrjDataImporter( '<?php echo $_param_id; ?>' );
</script>