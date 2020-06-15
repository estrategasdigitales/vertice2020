<?php
class rrj_bar_chart
{
	// the shortcode
	const code = 'rrj_bar_chart';
	
	// unique instance of the class
	private static $instance = null;
	
	private function __construct() {
		
		add_shortcode( self::code, array( $this, 'shortcode' ) );
		
		add_action( 'wp_enqueue_scripts', 'rrj_enqueue_chartjs' );
		
		add_action( 'init', array( $this, 'init' ) );
	}
	
	/**
	 * map shortcode 
	 */
	public function init() {
		if ( function_exists( 'vc_map' ) ) {
			$settings = $this->map();
			vc_map( $settings );
		}
	}
	
	/**
	 *  returns mapping arguments
	 */
	public function map() {
		return array(
			'name' => __( 'Advanced Bar Chart', 'rrj-ac' ),
			'description' => __( 'Draw a bar chart', 'rrj-ac' ),
			'base' => self::code,
			'class' => '',
			'icon' => RRJ_AC_URL . 'elements/bar/bar.png',
			'category' => 'Advanced Charts',
			'admin_enqueue_js' => array(
				includes_url( 'js/jquery/ui/core.min.js' ),
				includes_url( 'js/jquery/ui/widget.min.js' ),
				includes_url( 'js/jquery/ui/mouse.min.js' ),
				RRJ_AC_URL . 'assets/js/param-uislider.js',
			),
			'admin_enqueue_css' => array(
				RRJ_AC_URL . 'assets/css/param-uislider.css',
			),
			'params' => $this->params(),
		);
	}
	
	/**
	 *  the shortcode function
	 */
	public function shortcode( $atts, $content = null ) {
		$atts = vc_map_get_attributes( self::code, $atts );
		$atts_array = $atts;
		extract( $atts );
		ob_start();
		$datasets = (array) vc_param_group_parse_atts( $atts['datasets'] );
		
		include plugin_dir_path( __FILE__ ) . 'template.php';
		
		return ob_get_clean();
	}
	
	/**
	 *  return the params field for vc_map()
	 */
	public function params() {
		$params = array(
			/**
			 * GENERAL 
			 */
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'rrj-ac' ),
				'param_name' => 'title',
				'value' => __( 'Advanced Bar Chart', 'rrj-ac' ),
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'orientation',
				'heading' => __( 'Bars Orientation', 'rrj-ac' ),
				'value' => array(
					__( 'horizontal', 'rrj-ac' ) => 'horz',
					__( 'vertical', 'rrj-ac' ) => 'vert',
				),
				'std' => 'vert',
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'param_name' => 'labels',
				'heading' => __( 'X axis labels', 'rrj-ac' ),
				'description' => sprintf( __( 'list of X axis labels, Y-axis for horizontal bars (separate labels with "%s").', 'rrj-ac' ), '<code>;</code>' ),
				'value' => 'Feb; Mar; Apr; May; Jun; Jul; Aug; Sep',
			),
			array(
				'type' => 'checkbox',
				'param_name' => 'stacked',
				'heading' => __( 'Stacked bars', 'rrj-ac' ),
				'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
				'std' => '',
				'description' => __( 'stack bars at the same X value (Y for horizontal bars)', 'rrj-ac' ),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'stack_mode',
				'heading' => __( 'Stacked bars mode', 'rrj-ac' ),
				'value' => array(
					__( 'stack bars on the X or Y axis', 'rrj-ac' ) => 'axis',
					__( 'stack bars on each other', 'rrj-ac' ) => 'bars',
				),
				'std' => 'axis',
			),
			array(
				'type' => 'param_group',
				'param_name' => 'datasets',
				'heading' => __( 'Datasets', 'rrj-ac' ),
				'value' => urlencode( json_encode( array(
					array(
						'title' => __( 'One', 'rrj-ac' ),
						'values' => '18; 14; 21; 25; 27; 24; 23; 19',
						'color' => '#0085ba',
						'tooltips_format' => '{d}: {y}',
						'bar_bg' => 'transparent',
						'hidden' => '',
						'group' => '',
					),
				) ) ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __( 'Title', 'rrj-ac' ),
						'param_name' => 'title',
						'description' => __( 'dataset title used in tooltips and legends.', 'rrj-ac' ),
						'admin_label' => true,
					),
					array(
						'type' => 'textfield', 
						'param_name' => 'tooltips_format',
						'heading' => __( 'Tooltips text format', 'rrj-ac' ),
						'value' => '{d}: {y}',
						'description' => __( 'text format for the tooltip (available placeholders: {d} dataset title, {x} X axis label, {y} Y axis value)', 'rrj-ac' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Values', 'rrj-ac' ),
						'param_name' => 'values',
						'value' => '27; 24; 23; 19; 18; 14; 21; 25',
						'description' => sprintf( __( 'enter values (separate values with "%s").', 'rrj-ac' ), '<code>;</code>' ),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __( 'Dataset color', 'rrj-ac' ),
						'param_name' => 'color',
						'value' => '#dd3333',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'bar_bg',
						'heading' => __( 'Bar background', 'rrj-ac' ),
						'value' => array(
							__( 'partially transparent', 'rrj-ac' ) => 'transparent',
							__( 'plain color', 'rrj-ac' ) => 'plain',
						),
						'std' => 'transparent',
						'admin_label' => true,
					),
					array(
						'type' => 'checkbox',
						'param_name' => 'hidden',
						'heading' => __( 'Hidden on load', 'rrj-ac' ),
						'description' => __( 'this dataset will be hidden on load until the corresponding legend is clicked on', 'rrj-ac' ),
						'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
						'std' => '',
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Group ID', 'rrj-ac' ),
						'param_name' => 'group',
						'value' => '',
						'description' => sprintf( __( 'bars corresponding to each group will be stacked together', 'rrj-ac' ), '<code>;</code>' ),
					),
				),
			),
			/**
			 *  CATEGORY & BAR PERCENTAGE
			 */
			array(
				'type' => 'rrj_uislider',
				'param_name' => 'cat_per',
				'heading' => __( 'X axis label width percentage (Y axis for horizontal bars)', 'rrj-ac' ),
				'group' => __( 'Bars settings', 'rrj-ac' ),'value' => '10',
				'min' => '0',
				'max' => '100',
				'step' => '1',
				'value' => '80',
				'description' => __( 'Amount of available width taken by each label', 'rrj-ac' ),
			),
			array(
				'type' => 'rrj_uislider',
				'param_name' => 'bar_per',
				'heading' => __( 'Bar width percentage', 'rrj-ac' ),
				'group' => __( 'Bars settings', 'rrj-ac' ),'value' => '10',
				'min' => '0',
				'max' => '100',
				'step' => '1',
				'value' => '90',
				'description' => __( 'Amount of available width taken by bars (within each X or Y axis label)', 'rrj-ac' ),
			),
		);
		/**
		 *  LEGEND AND TOOLTIP
		 */
		$tooltip_options = rrj_ac_tooltip_options();
		
		/**
		 *  CHART OPTIONS
		 */
		$chart_options = rrj_ac_chart_options( array(
			'ar' => false,
			'axes_color' => true,
			'axis_zero' => array(
				'description' => __( 'Force Y axis (X axis for horizontal bars) to start at zero', 'rrj-ac', 'rrj-ac' ),
			),
			'yaxis_labels' => true,
			'xaxis_labels' => true,
		) );
		
		$axis_prefix = rrj_ac_axes_prefix();
		$axis_suffix = rrj_ac_axes_suffix();
		
		$params = array_merge( $params, $tooltip_options, $chart_options, $axis_prefix, $axis_suffix );
		
		/**
		 *  DESIGN OPTIONS
		 */
		$params = array_merge( $params, array( array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'rrj-ac' ),
			'param_name' => 'css',
			'group' => __( 'Design options', 'rrj-ac' ),
		) ) );
		
		/**
		 *  Custom JS options
		 */
		$params = array_merge( $params, array( rrj_js_options() ) );
		
		/**
		 *  Custom JS data
		 */
		$params = array_merge( $params, rrj_js_data() );
		
		/**
		 * CSV import 
		 */
		$params[] = array(
			'type' => 'rrj_importer',
			'group' => __( 'Import data', 'rrj-ac' ),
			'param_name' => 'importer',
			'heading' => __( 'Import data from a CSV file', 'rrj-ac' ),
			'set_type' => 'bar',
		);
		
		return $params;
	}
	
	// return or create the unique instance
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}
rrj_bar_chart::instance();