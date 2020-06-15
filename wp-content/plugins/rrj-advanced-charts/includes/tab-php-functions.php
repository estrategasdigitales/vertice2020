<?php
$functions = get_option( self::php_functions, array() );
?>
<script type="text/javascript">
	<?php if ( empty( $functions ) ) : ?>
	var rrjPhpFunctions = {};
	<?php else : ?>
	var rrjPhpFunctions = <?php echo wp_json_encode( $functions ) ?>;
	<?php endif; ?>
</script>
<div class="form-wrap">
	<form name="php-functions" id="php-functions">
		<h4 class="section-head"><?php _e( 'New function', 'rrj-ac' ); ?></h4>
		<div class="form-field">
			<input type="text" id="new-function-name" style="width:30em;margin:auto 1em;" value="" />
			<button class="button-secondary" id="new-function"><?php _e( 'create function', 'rrj-ac' ); ?></button>
			<p class="description"><?php _e( 'The name used to refer to this function from JS Data, (<b>Not necessarily a valid PHP function name</b>)', 'rrj-ac' ); ?></p>
		</div>
		
		<h4 class="section-head"><?php _e( 'Edit function', 'rrj-ac' ); ?></h4>
		
		<div class="form-field" style="border:none;">
			<label for="function-selector"><span><?php _e( 'Select a function', 'rrj-ac' ) ?><span></label>
			<select id="function-selector" style="margin-bottom:1em;">
			<?php if ( empty( $functions ) ) : ?>
			<option value=""><?php _e( 'no function found', 'rrj-ac' ) ?></option>
			<?php else : ?>
				<option value=""><?php _e( ' --Choose a function-- ', 'rrj-ac' ) ?></option>
				<?php foreach ( $functions as $key => $value ) : ?>
				<option value="<?php echo esc_attr( $key ) ?>"><?php echo $key ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
			</select>
		</div>
		
		<div class="form-field" id="function-editor" >
		
			<label for="php-code-editor"><span><?php _e( 'PHP code', 'rrj-ac' ) ?><span></label>
			<textarea id="php-code-editor" rows="20" name="function-code"></textarea>
			<p class="description"><i class="dashicons dashicons-info"></i>&nbsp;<?php _e( 'PHP code to execute. It will be passed to <code>eval()</code>, <code>try/catch</code> blocks will not work', 'rrj-ac' ) ?></p>
			
			<input type="hidden" name="function-name" value="" />
			
			<label for="storage"><span><?php _e( 'Results caching', 'rrj-ac' ) ?><span></label>
			<select id="storage" name="function-storage">
				<option value="disabled"><?php _e( 'evaluate every time', 'rrj-ac' ) ?></option>
				<option value="5min"><?php _e( '5 minutes', 'rrj-ac' ) ?></option>
				<option value="15min"><?php _e( '15 minutes', 'rrj-ac' ) ?></option>
				<option value="30min"><?php _e( '30 minutes', 'rrj-ac' ) ?></option>
				<option value="1h"><?php _e( 'one hour', 'rrj-ac' ) ?></option>
				<option value="2h"><?php _e( '2 hours', 'rrj-ac' ) ?></option>
				<option value="3h"><?php _e( '3 hours', 'rrj-ac' ) ?></option>
				<option value="6h"><?php _e( '6 hours', 'rrj-ac' ) ?></option>
				<option value="12h"><?php _e( '12 hours', 'rrj-ac' ) ?></option>
				<option value="24h"><?php _e( '24 hours', 'rrj-ac' ) ?></option>
				<option value="2d"><?php _e( '2 days', 'rrj-ac' ) ?></option>
			</select>
			<p class="description"><?php _e( 'how much time the stored result will be served to charts before re-evaluating the PHP code', 'rrj-ac' ) ?></p>
			
			<div class="submit" style="float:left;">
				<a class="button-secondary" id="execute-test"><?php _e( 'Test the code', 'rrj-ac' ) ?></a>
				<a class="button-secondary" id="show-conditionals"><?php _e( 'Conditionals', 'rrj-ac' ) ?></a>
				<p><i class="dashicons dashicons-info"></i>&nbsp;<?php _e( 'testing a code does no involve caching, the code will always be evaluated.', 'rrj-ac' ) ?></p>
			</div>
			<div class="submit" style="float:right">
				<button class="button-secondary" id="delete-function"><?php _e( 'Delete function', 'rrj-ac' ); ?></button>
				<button class="button-primary" id="save-function"><?php _e( 'Save function', 'rrj-ac' ); ?></button>
			</div>
			
			<br style="clear:both;"/>
			
			<div id="conditionals" style="display:none">
				<label><span><?php _e( 'Conditionals', 'rrj-ac' ) ?></span></label>
				<label class="condlabel"><input type="checkbox" class="conditional" data-fn="is_front_page" /><code>is_front_page()</code></label>
				<label class="condlabel"><input type="checkbox" class="conditional" data-fn="is_home" /><code>is_home()</code></label>
				<label class="condlabel"><input type="checkbox" class="conditional" data-fn="is_singular" /><code>is_singular()</code></label>
				<label class="condlabel"><input type="checkbox" class="conditional" data-fn="is_page" /><code>is_page()</code></label>
				<label class="condlabel"><input type="checkbox" class="conditional" data-fn="is_user_logged_in" /><code>is_user_logged_in()</code></label>
			</div>
			
			<div id="response-div" style="display:none">
				<label><span><?php _e( 'Server response', 'rrj-ac' ) ?></span></label>
				<div></div>
			</div>
			
		</div>
		
	</form>
</div>
<script type="text/javascript">
var rrjAcI18n = {
	'unknownResponse': '<?php _e( 'Unknown response received from the server (can not be converted to JSON). Original response : <p><strong>%s</strong></p>', 'rrj-ac' ) ?>',
};
</script>