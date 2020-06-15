<?php
class rrj_charts
{
	// unique instance of the class
	private static $instance = null;
	
	const options = 'rrj-charts-settings';
	
	const php_functions = 'rrj-php-func';
	
	private static $default_conditionals = array(
		'is_front_page' => false,
		'is_home' => false,
		'is_singular' => false,
		'is_page' => false,
		'is_user_logged_in' => false,
	);
	
	private $page_hook;
	
	private static $default_options;
	
	private function __construct() {
		if ( defined( 'WPB_VC_VERSION' ) ) {
			add_action( 'init', array( $this, 'init' ) );
			
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
			
			// load all chart elements
			require_once RRJ_AC_PATH . 'elements/line/line-chart.php';
			require_once RRJ_AC_PATH . 'elements/bar/bar-chart.php';
			require_once RRJ_AC_PATH . 'elements/bubble/bubble-chart.php';
			require_once RRJ_AC_PATH . 'elements/pie/pie-chart.php';
			require_once RRJ_AC_PATH . 'elements/radar/radar-chart.php';
			require_once RRJ_AC_PATH . 'elements/polar/polar-chart.php';
			
			// page inline scripts
			add_action( 'wp_head', array( $this, 'wp_head' ) );
			
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			
			// front end scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			
			// back end scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			
			// back end inline scripts
			add_action( 'admin_footer', array( $this, 'admin_footer' ) );
			
			add_action( 'wp_ajax_rrj_csv_importer', array( $this, 'ajax_csv_import' ) );
			add_action( 'wp_ajax_rrj_save_settings', array( $this, 'ajax_save_settings' ) );
			add_action( 'wp_ajax_rrj_save_function', array( $this, 'ajax_save_function' ) );
			add_action( 'wp_ajax_rrj_delete_function', array( $this, 'ajax_delete_function' ) );
			add_action( 'wp_ajax_rrj_reset_settings', array( $this, 'ajax_reset_settings' ) );
			add_action( 'wp_ajax_rrj_new_fn', array( $this, 'ajax_create_function' ) );
			add_action( 'wp_ajax_rrj_test_fn', array( $this, 'ajax_test_function' ) );
			
			add_action( 'wp_ajax_rrj_run_fn', array( $this, 'ajax_run_function' ) );
			add_action( 'wp_ajax_nopriv_rrj_run_fn', array( $this, 'ajax_run_function' ) );
			
			// meta box
			add_action( 'add_meta_boxes', array( $this, 'meta_box' ), 10, 2 );
			add_action( 'save_post', array( $this, 'save_post' ), 10 );
		} else {
			add_action( 'admin_notices', array( $this, 'missing_vc' ) );
		}
	}
	
	/**
	 * Update post meta from meta box 
	 */
	public function save_post( $post_id ) {
		if ( !empty( $_POST['rrjac']['enabled'] ) ) {
			
			$value = max( 0, min( 100, absint( $_POST['rrjac']['value'] ) ) );
			update_post_meta( $post_id, RRJ_AC_METAINIT, array( 'enabled' => true, 'value' => $value ) );
			
		} else {
			delete_post_meta( $post_id, RRJ_AC_METAINIT );
		}
	}
	
	/**
	 *  Add chart initialization meta box
	 */
	public function meta_box( $post_type, $post ){
		$post_types = get_post_types( array( 'show_ui' => true ) );
		add_meta_box(
			'rrj-ac-init',
			__( 'Chart Initialization', 'rrj-ac' ),
			array( $this, 'print_meta_box' ),
			$post_types,
			'side',
			'default'
		);
	}
	
	/**
	 *  Print out meta box markup
	 */
	public function print_meta_box( $post, $args ) {
		require_once RRJ_AC_PATH . 'includes/metabox.php';
	}
	
	/**
	 *  format imported datasets
	 */
	private function format_sets( $type, $_sets, &$sets ){
		if ( 'bubble' == $type ) {
			$__sets = array();
			foreach( $_sets as $i => $set ) {
				$__sets[$i] = array();
				$point = array();
				foreach( $set as $cell ) {
					$point[] = $cell;
					if ( 3 == count( $point ) ) {
						$__sets[$i][] = '[' . implode( ';', $point ) . ']';
						$point = array();
					}
				}
				if ( !empty( $point ) ) {
					$__sets[$i][] = '[' . implode( ';', $point ) . ']';
				}
				$sets[] = implode( ' ', $__sets[$i] );
			}
		} else {
			foreach( $_sets as $set ) {
				$sets[] = implode( ';', $set );
			}
		}
		return $sets;
	}
	
	/**
	 *  format imported content 
	 */
	private function format_content( $content, $type, $orientation, $header ) {
		$labels = '';
		$sets = array();
		
		if ( 'rows' == $orientation ) {
			$_sets = array();
			foreach( $content as $i => $row ) {
				if ( 0 == $i ) {
					if ( 'skip' == $header ) continue;
					if ( '1st' == $header ) {
						$labels = str_replace( ',', ';', trim( $row ) );
						continue;
					}
				}
				$_sets[] = explode( ',', $row );
			}
			$this->format_sets( $type, $_sets, $sets );
		} else {
			$_labels = array();
			$_sets = array();
			foreach( $content as $i => $row ) {
				$cells = explode( ',', $row );
				foreach ( $cells as $j => $cell ) {
					$_j = $j;
					if ( 0 == $j ) {
						if ( 'skip' == $header ) continue;
						if ( '1st' == $header ) {
							$_labels[] = $cell;
							continue;
						}
					}
					if ( 'none' != $header ) {
						$_j = $j - 1;
					}
					if ( !isset( $_sets[$_j] ) ) {
						$_sets[$_j] = array();
					}
					$_sets[$_j][] = $cell;
				}
			}
			$labels = implode( ';', $_labels );
			$this->format_sets( $type, $_sets, $sets );
		}
		
		return array(
			'labels' => $labels,
			'sets' => $sets,
		);
	}
	
	private function _eval( $code, $conditionals = array(), $stored_value = '' ) {
		$functions = get_option( self::php_functions, array() );
		if ( empty( $conditionals ) ) {
			$conditionals = self::$default_conditionals;
		}
		$code = trim( $code );
		if ( 0 === strpos( $code, '<?php' ) ) {
			$code = substr( $code, 5 );
		} elseif( 0 === strpos( $code, '<?' ) ) {
			$code = substr( $code, 2 );
		}
		$results = eval( $code );
		return $results;
	}
	
	public function ajax_run_function() {
		$fn = isset( $_POST['fn'] ) ? stripslashes( $_POST['fn'] ) : false;
		if ( $fn ) {
			$functions = get_option( self::php_functions, array() );
			if ( isset( $functions[$fn] ) ) {
				
				$conditionals = self::$default_conditionals;
				if ( isset( $_POST['conditionals'] ) ) {
					try {
						$conditionals = json_decode( wp_unslash( $_POST['conditionals'] ), true );
					} catch ( Exception $e ) {}
				}
				
				$interval = array(
					'5min' => 300,
					'15min' => 900,
					'30min' => 1800,
					'1h' => 3600,
					'2h' => 7200,
					'3h' => 10800,
					'6h' => 21600,
					'12h' => 43200,
					'24h' => 86400,
					'2d' => 172800,
				);
				
				if ( 'disabled' != $functions[$fn]['storage'] ) {
					if ( '' !== $functions[$fn]['lastRes'] && time() < $functions[$fn]['lastExec'] + 90 ) {
						
						header( 'Content-Type: text/html' );
						echo wp_json_encode( $functions[$fn]['lastRes'] );
						
					} else {
						
						$results = $this->_eval( $functions[$fn]['code'], $conditionals, $functions[$fn]['lastRes'] );
						$functions[$fn]['lastRes'] = $results;
						$functions[$fn]['lastExec'] = time();
						
						update_option( self::php_functions, $functions );
						header( 'Content-Type: text/html' );
						echo wp_json_encode( $results );
						
					}
				} else {
					
					$results = $this->_eval( $functions[$fn]['code'], $conditionals, $functions[$fn]['lastRes'] );
					header( 'Content-Type: text/html' );
					echo wp_json_encode( $results );
					
				}
				
			}
		}
		die;
	}
	
	public function ajax_test_function() {
		$nonce = isset( $_POST['nonce'] )? $_POST['nonce'] : '';
		if ( false !== wp_verify_nonce( $nonce, 'rrj-settings' ) ) {
			$conditionals = array();
			try {
				$conditionals = json_decode( wp_unslash( $_POST['conditionals'] ), true );
			} catch ( Exception $e ) {}
			$results = $this->_eval( wp_unslash( $_POST['code'] ), $conditionals );
			header( 'Content-Type: text/html' );
			echo wp_json_encode( $results );
		}
		die;
	}
	
	public function ajax_delete_function() {
		
		$nonce = isset( $_POST['nonce'] )? $_POST['nonce'] : '';
		if ( false !== wp_verify_nonce( $nonce, 'rrj-settings' ) ) {
			$fn = stripslashes( $_POST['fn'] );
			$functions = get_option( self::php_functions, array() );
			if ( isset( $functions[$fn] ) ) {
				unset( $functions[$fn] );
			}
			update_option( self::php_functions, $functions );
		}
		die;
		
	}
	
	public function ajax_save_function() {
		
		$nonce = isset( $_POST['nonce'] )? $_POST['nonce'] : '';
		if ( false !== wp_verify_nonce( $nonce, 'rrj-settings' ) ) {
			$code = stripslashes( $_POST['code'] );
			$fn = stripslashes( $_POST['fn'] );
			$storage = stripslashes( $_POST['storage'] );
			$functions = get_option( self::php_functions, array() );
			$old_func = $functions[$fn];
			$functions[$fn] = array(
				'code' => $code,
				'storage' => $storage,
			) + $old_func;
			update_option( self::php_functions, $functions );
		}
		die;
		
	}
	
	/**
	 * Add a new PHP function to the list 
	 */
	public function ajax_create_function() {
		$nonce = isset( $_POST['nonce'] )? $_POST['nonce'] : '';
		if ( false !== wp_verify_nonce( $nonce, 'rrj-settings' ) ) {
			$fn = stripslashes( $_POST['fn'] );
			
			if ( $fn ) {
				$functions = get_option( self::php_functions, array() );
				$functions[$fn] = array(
					'code' => "<?php\n",
					'storage' => '3h',
					'lastExec' => 0,
					'lastRes' => '',
				);
				update_option( self::php_functions, $functions, false );
				$result = array( 'status' => true, 'functions' =>  $functions );
			} else {
				$result = array( 'status' => false );
			}
			
			header( 'Content-Type: application/json' );
			echo wp_json_encode( $result );
		}
		die;
	}
	
	/**
	 *  reset plugin settings
	 */
	public function ajax_reset_settings() {
		$nonce = isset( $_POST['nonce'] )? $_POST['nonce'] : '';
		if ( false !== wp_verify_nonce( $nonce, 'rrj-settings' ) ) {
			
			update_option( self::options, self::$default_options );
			
			$result = array( 'status' => true );
			
			header( 'Content-Type: aplication/json' );
			echo wp_json_encode( $result );
		}
		die;
	}
	
	/**
	 *  save plugin settings
	 */
	public function ajax_save_settings() {
		$nonce = isset( $_POST['nonce'] )? $_POST['nonce'] : '';
		if ( false !== wp_verify_nonce( $nonce, 'rrj-settings' ) ) {
			parse_str( wp_unslash( $_POST['args'] ), $args );
			$args = wp_unslash( $args );
			$force_axes_color = isset( $args['force-axes-color'] );
			$axes_color = sanitize_hex_color( $args['axes-color'] ) ? sanitize_hex_color( $args['axes-color'] ) : '#646464';
			$legend_font_color = sanitize_hex_color( $args['legend-font-color'] ) ? sanitize_hex_color( $args['legend-font-color'] ) : '#646464';
			
			$options = 	array(
				'force-axes-color' => $force_axes_color,
				'axes-color' => $axes_color,
				'legend-font-color' => $legend_font_color,
			) +
			$args +
			self::$default_options;
			
			update_option( self::options, $options );
			
			$result = array( 'status' => true );
			
			header( 'Content-Type: aplication/json' );
			echo wp_json_encode( $result );
		}
		die;
	}
	
	/**
	 *  ajax callback for data import
	 */
	public function ajax_csv_import() {
		$nonce = isset( $_POST['nonce'] )? $_POST['nonce'] : '';
		if ( false !== wp_verify_nonce( $nonce, 'rrj-importer' ) ) {
			$id = absint( $_POST['id'] );
			$type = $_POST['type'];
			$orientation = $_POST['orientation'];
			$header = $_POST['header'];
			$file = get_attached_file( $id );
			$result = $this->parse_CSV( $file, array(
				'type' => $type,
				'orientation' => $orientation,
				'header' => $header,
			) );
			header( 'Content-Type: aplication/json' );
			echo wp_json_encode( array(
				'status' => true,
				'data' => $result
			) );
		}
		die;
	}
	
	/**
	 *  fill short rows with empty values
	 */
	private function normalize_rows( $rows = array(), $max = 0 ) {
		$repeat = false;
		foreach ( $rows as $i => $row ) {
			$count = substr_count( $row, ',' );
			if ( $count > $max ) {
				$max = $count;
				$repeat = true;
				break;
			} elseif ( $count < $max ) {
				$rows[$i] .= str_repeat( ',', $max - $count );
			}
		}
		if ( $repeat ) {
			return $this->normalize_rows( $rows, $max );
		} else {
			return $rows;
		}
	}
	
	/**
	 *  parse CSV files
	 */
	public function parse_CSV( $file, $options = array() ) {
		$default_options = array(
			'type' => 'line',
			'orientation' => 'rows',
			'header' => 'skip',
		);
		$options += $default_options;
		if ( !function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		WP_Filesystem();
		global $wp_filesystem;
		$file = str_replace( ABSPATH, $wp_filesystem->abspath(), $file );
		$content = $wp_filesystem->get_contents( $file );
		$content = explode( "\n", $content );
		$content = $this->normalize_rows( $content );
		$content = $this->format_content( $content, $options['type'], $options['orientation'], $options['header'] );
		return $content;
	}
	
	/**
	 *  admin inline scripts
	 */
	public function admin_footer() {
		$scr = get_current_screen();
		$vc_screens = array( 'post', 'edit', 'widgets' );
		if ( in_array( $scr->base, $vc_screens ) ) {
			?>
			<style type="text/css">
			#rrj-load-overlay {
				position: fixed;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				background-color: rgba(255,255,255,.6);
				z-index: 190000;
				text-align: center;
				padding-top: 50vh;
			}
			
			#rrj-load-overlay img {
				display: inline-block;
				margin-top: -26px;
			}
			.rrj-csv-importer-wrap p.file-name {
				font-weight: bold;
			}
			.rrj-csv-importer-wrap .file-notice {
				font-weight: bold;
				color: red;
			}
			.rrj-csv-importer-wrap .imported-data-field {
				padding: 6px 10px;
				background-color: #fafafa;
				border: 1px solid #e8e8e8;
				margin-bottom: 6px;
			}
			.rrj-csv-importer-wrap .imported-data-field .vc-composer-icon {
				cursor: pointer;
				font-size: 18px;
				margin: 3px;
				padding: 3px;
				float: right;
				background-color: #fff;
				border: 1px solid #d2d2d2;
			}
			.rrj-csv-importer-wrap .imported-data-field .vc-composer-icon:hover {
				color: blue;
			}
			.rrj-csv-importer-wrap .imported-data-field .vc-c-icon-delete_empty:hover {
				color: red;
			}
			.rrj-csv-importer-wrap .sortable-import-placeholder {
				background-image: url('<?php echo RRJ_AC_URL . 'assets/images/bg.png' ?>');
				background-repeat: repeat;
				margin-bottom: 6px;
			}
			.rrj-csv-importer-wrap .imported-data-field .vc-c-icon-dragndrop {
				cursor: move;
				float: left;
			}
			.rrj-csv-importer-wrap .import-warning {
				color: #f90;
				display: none;
			}
			.rrj-csv-importer-wrap .editor .labels-wrap,
			.rrj-csv-importer-wrap .editor .sets-wrap {
				margin-bottom: 10px;
			}
			</style>
			<div style="display:none;" id="rrj-load-overlay">
				<img alt="" src="<?php echo RRJ_AC_URL . 'assets/images/loading.gif'; ?>" />
			</div><?php
		}
	}
	
	/**
	 *  wp_head
	 */
	public function wp_head() {
		$options = $this->get_option();
		
		/**
		 * Overwrite init option 
		 */
		if ( is_singular() ) {
			global $post;
			if ( $post ) {
				$meta = get_post_meta( $post->ID, RRJ_AC_METAINIT, true );
				if ( is_array( $meta ) && $meta['enabled'] ) {
					$options['init'] = $meta['value'];
				}
			}
		}
		
		$conditionals = array(
			'is_front_page' => is_front_page(),
			'is_home' => is_home(),
			'is_singular' => is_singular(),
			'is_page' => is_page(),
			'is_user_logged_in' => is_user_logged_in(),
			'post_id' => get_the_id(),
		);
		
		?><script type="text/javascript">
		
		(function ($) {
			window.rrjDrawChart = function (id, data) {
				$('body').trigger('rrjDelayedChart', [id, data])
			}
			window.rrjGetData = function( __fname, __success, __error, __thisArg, __extraData ) {
				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					data: {
						action: 'rrj_run_fn',
						fn: __fname,
						conditionals: '<?php echo wp_json_encode( $conditionals ) ?>',
					},
					success: function( textResponse, status, xhr ){
						if ( 'function' == typeof __success ) {
							__success.call( __thisArg, textResponse, __extraData );
						}
					},
					error: function( req, status, err ){
						if ( 'function' == typeof __error ) {
							__error.call( __thisArg, req, __extraData );
						}
					},
				});
			}
		})(window.jQuery);
		
		var rrjChartPluginOptions = <?php echo wp_json_encode( $options ); ?>;
		</script><?php
	}
	
	/**
	 *  add chart settings page
	 */
	public function admin_menu() {
		$this->page_hook = add_submenu_page(
			'vc-general',
			__( 'Charts settings', 'rrj-ac' ),
			__( 'Charts settings', 'rrj-ac' ),
			'manage_options',
			'rrj_charts',
			array( $this, 'settings_page' )
		);
	}
	
	/**
	 *  settings page callback function
	 */
	public function settings_page() {
		require_once RRJ_AC_PATH . 'includes/settings-page.php';
	}
	
	/**
	 *  enqueue back end scripts
	 */
	public function admin_scripts() {
		$scr = get_current_screen();
		$vc_screens = array( 'post', 'edit', 'widgets' );
		if ( in_array( $scr->base, $vc_screens ) ) {
			wp_enqueue_script( 'rrj-codemirror', RRJ_AC_URL . 'assets/libs/CodeMirror/codemirror.js', array( 'jquery' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-jsmode', RRJ_AC_URL . 'assets/libs/CodeMirror/javascript.js', array( 'rrj-codemirror' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-jseditor', RRJ_AC_URL . 'assets/js/param-jseditor.js', array( 'rrj-codemirror' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-mediaframe', RRJ_AC_URL . 'assets/js/media-frame.js', array( 'jquery' ), RRJ_AC_VERSION );
			
			$media_locale = array(
				'selectMedias' => __( 'Select files', 'rrj-ac' ),
				'selectMedia' => __( 'Select a file', 'rrj-ac' ),
				'button' => __( 'select', 'rrj-ac' ),
				'invalidFileType' => __( 'invalid file type', 'rrj-ac' ),
			);
			wp_register_script( 'rrj-importer', RRJ_AC_URL . 'assets/js/param-importer.js', array( 'rrj-mediaframe' ), RRJ_AC_VERSION );
			wp_localize_script( 'rrj-importer', 'rrjMediaFrameLocale', $media_locale );
			wp_enqueue_script( 'rrj-importer' );
			wp_enqueue_style( 'rrj-codemirror', RRJ_AC_URL . 'assets/libs/CodeMirror/codemirror.css', array(), RRJ_AC_VERSION );
		}
		
		if ( $scr->id == $this->page_hook ) {
			wp_enqueue_style( 'rrj-settings', RRJ_AC_URL . 'assets/css/admin-settings.css', array(), RRJ_AC_VERSION );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'rrj-codemirror', RRJ_AC_URL . 'assets/libs/CodeMirror/codemirror.css', array(), RRJ_AC_VERSION );
			
			wp_enqueue_script( 'rrj-codemirror', RRJ_AC_URL . 'assets/libs/CodeMirror/codemirror.js', array( 'jquery' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-jsmode', RRJ_AC_URL . 'assets/libs/CodeMirror/javascript.js', array( 'rrj-codemirror' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-phpmode', RRJ_AC_URL . 'assets/libs/CodeMirror/php.js', array( 'rrj-codemirror' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-xmlmode', RRJ_AC_URL . 'assets/libs/CodeMirror/xml.js', array( 'rrj-codemirror' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-cssmode', RRJ_AC_URL . 'assets/libs/CodeMirror/css.js', array( 'rrj-codemirror' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-clikemode', RRJ_AC_URL . 'assets/libs/CodeMirror/clike.js', array( 'rrj-codemirror' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-htmlmixedmode', RRJ_AC_URL . 'assets/libs/CodeMirror/htmlmixed.js', array( 'rrj-codemirror' ), RRJ_AC_VERSION );
			wp_enqueue_script( 'rrj-settings', RRJ_AC_URL . 'assets/js/admin-settings.js', array( 'jquery', 'wp-color-picker', 'rrj-codemirror' ), RRJ_AC_VERSION );
		}
	}
	
	/**
	 *  load text domain for translations
	 */
	public function plugins_loaded() {
		load_plugin_textdomain( 'rrj-ac', false, RRJ_AC_PATH . 'languages' );
	}
	
	/**
	 *  tasks to run during init action
	 */
	public function init() {
		// add rrj_uislider param type
		vc_add_shortcode_param( 'rrj_uislider', array( $this, 'uislider' ) );
		// add rrj_jseditor param type
		vc_add_shortcode_param( 'rrj_jseditor', array( $this, 'jseditor' ) );
		// add rrj_importer param type
		vc_add_shortcode_param( 'rrj_importer', array( $this, 'importer' ) );
		
		self::$default_options = array(
			'force-axes-color' => false,
			'axes-color' => '#3a3a3a',
			'legend-font-color' => '#3a3a3a',
			'legend-font-size' => '12',
			'font-family' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
			't-separator' => '',
			'init' => '33',
		);
	}
	
	/**
	 *  jseditor param markup
	 */
	public function jseditor( $settings, $value ) {
		ob_start();
		include plugin_dir_path( __FILE__ ) . '/jseditor.php';
		return ob_get_clean();
	}
	
	/**
	 *  rrj_importer param markup
	 */
	public function importer( $settings, $value ) {
		ob_start();
		include plugin_dir_path( __FILE__ ) . '/importer.php';
		return ob_get_clean();
	}
	
	/**
	 *  uislider param markup
	 */
	public function uislider( $settings, $value ) {
		ob_start();
		include plugin_dir_path( __FILE__ ) . '/uislider.php';
		return ob_get_clean();
	}
	
	/**
	 *  enqueue scripts in front end
	 */
	public function enqueue_scripts() {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			wp_enqueue_script( 'rrj-charts', RRJ_AC_URL . 'assets/js/chart-controller.js', array( 'jquery' ), RRJ_AC_VERSION );
		} else {
			wp_enqueue_script( 'rrj-charts', RRJ_AC_URL . 'assets/js/chart-controller.min.js', array( 'jquery' ), RRJ_AC_VERSION );
		}
	}
	
	/**
	 *  add admin notice about missing Visual Composer
	 */
	public function missing_vc() {
		$msg = sprintf(
			__( '%s needs %s to be installed and activated to function', 'rrj-ac' ),
			'<strong>Advanced Charts</strong>',
			'<strong>Visual Composer</strong>'
		);
		echo '<div class="updated"><p>' . $msg . '</p></div>';
	}
	
	/**
	 *  return the aspect ratio param mapping
	 */
	public static function AR(){
		return array(
			'1:1' => '1:1',
			'21:9' => '21:9',
			'16:9' => '16:9',
			'16:9' => '16:9',
			'4:3' => '4:3',
			'3:4' => '3:4',
			'9:16' => '9:16',
			'9:21' => '9:21',
		);
	}
	
	/**
	 * process aspect ratio fields 
	 */
	public static function process_ar( $ar = '4:3', $car = '' ) {
		$AR = explode( ':', $ar );
		$car = str_replace( ' ', '', $car );
		if ( !empty( $car ) ) {
			$CAR = explode( ':', $car );
			if ( 2 == count( $CAR ) ) {
				if ( !is_nan( floatval( $CAR[0] ) ) && !empty( $CAR[0] ) && !is_nan( floatval( $CAR[1] ) ) && !empty( $CAR[1] ) ) {
					$AR = array( floatval( $CAR[0] ), floatval( $CAR[1] ) );
				}
			}
		}
		return $AR;
	}
	
	/**
	 *  get plugin's options
	 */
	public function get_option() {
		$options = get_option( self::options, array() );
		$options += self::$default_options;
		return $options;
	}
	
	// return or create the unique instance
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
}
rrj_charts::instance();