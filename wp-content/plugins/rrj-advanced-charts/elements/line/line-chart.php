<?php
class rrj_line_chart
{
	// the shortcode
	const code = 'rrj_line_chart';
	
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
			'name' => __( 'Advanced Line Chart', 'rrj-ac' ),
			'description' => __( 'Draw a line chart', 'rrj-ac' ),
			'base' => self::code,
			'class' => '',
			'icon' => RRJ_AC_URL . 'elements/line/line.png',
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
				'value' => __( 'Advanced Line Chart', 'rrj-ac' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'X axis labels', 'rrj-ac' ),
				'param_name' => 'labels',
				'description' => sprintf( __( 'list of labels for X axis (separate labels with "%s").', 'rrj-ac' ), '<code>;</code>' ),
				'value' => 'Feb; Mar; Apr; May; Jun; Jul; Aug; Sep',
			),
			array(
				'type' => 'checkbox',
				'param_name' => 'stacked',
				'heading' => __( 'stacked', 'rrj-ac' ),
				'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
				'std' => '',
				'description' => __( 'stack entries at the same X value, useful for stacked area charts', 'rrj-ac' ),
			),
			array(
				'type' => 'param_group',
				'heading' => __( 'Datasets', 'rrj-ac' ),
				'param_name' => 'datasets',
				'value' => urlencode( json_encode( array(
					array(
						'title' => __( 'One', 'rrj-ac' ),
						'values' => '18; 14; 21; 25; 27; 24; 23; 19',
						'color' => '#0085ba',
						'point_style' => 'circle',
						'line_type' => 'normal',
						'line_style' => 'solid',
						'fill' => 'transparent',
						'thickness' => 'normal',
						'linetension' => '10',
						'hidden' => '',
					),
					array(
						'title' => __( 'Two', 'rrj-ac' ),
						'values' => '22; 26; 21; 17; 19; 23; 21; 22',
						'color' => '#dd3333',
						'point_style' => 'circle',
						'line_type' => 'normal',
						'line_style' => 'solid',
						'fill' => 'transparent',
						'thickness' => 'normal',
						'linetension' => '10',
						'hidden' => '',
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
						'value' => '22; 26; 21; 17; 19; 23; 21; 22',
						'description' => sprintf( __( 'enter values for Y axis (separate values with "%s")', 'rrj-ac' ), '<code>;</code>' ),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __( 'Dataset color', 'rrj-ac' ),
						'param_name' => 'color',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'point_style',
						'heading' => __( 'Point Style', 'rrj-ac' ),
						'value' => array(
							__( 'none', 'rrj-ac' ) => 'none',
							__( 'circle', 'rrj-ac' ) => 'circle',
							__( 'triangle', 'rrj-ac' ) => 'triangle',
							__( 'rectangle', 'rrj-ac' ) => 'rect',
							__( 'rotated rectangle', 'rrj-ac' ) => 'rectRot',
							__( 'cross', 'rrj-ac' ) => 'cross',
							__( 'rotated cross', 'rrj-ac' ) => 'crossRot',
							__( 'star', 'rrj-ac' ) => 'star',
						),
						'std' => 'circle',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'line_type',
						'heading' => __( 'Line type', 'rrj-ac' ),
						'value' => array(
							__( 'none', 'rrj-ac' ) => 'none',
							__( 'normal', 'rrj-ac' ) => 'normal',
							__( 'stepped', 'rrj-ac' ) => 'step',
						),
						'std' => 'normal',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'line_style',
						'heading' => __( 'Line style', 'rrj-ac' ),
						'value' => array(
							__( 'solid', 'rrj-ac' ) => 'solid',
							__( 'dashed', 'rrj-ac' ) => 'dashed',
							__( 'dotted', 'rrj-ac' ) => 'dotted',
						),
						'std' => 'solid',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'fill',
						'heading' => __( 'Area filling', 'rrj-ac' ),
						'description' => __( 'how to fill the area below the line', 'rrj-ac' ),
						'value' => array(
							__( 'partially transparent', 'rrj-ac' ) => 'transparent', 
							__( 'plain color', 'rrj-ac' ) => 'plain', 
							__( 'none', 'rrj-ac' ) => 'none', 
						),
						'std' => 'transparent',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'thickness',
						'heading' => __( 'Thickness', 'rrj-ac' ),
						'description' => __( 'line and points thickness', 'rrj-ac' ),
						'value' => array(
							__( 'thin', 'rrj-ac' ) => 'thin',
							__( 'normal', 'rrj-ac' ) => 'normal',
							__( 'thick', 'rrj-ac' ) => 'thick',
							__( 'thicker', 'rrj-ac' ) => 'thicker',
						),
						'std' => 'normal',
					),
					array(
						'type' => 'rrj_uislider',
						'param_name' => 'linetension',
						'heading' => __( 'Line tension', 'rrj-ac' ),
						'value' => '10',
						'min' => '0',
						'max' => '100',
						'step' => '1',
						'description' => sprintf( __( 'tension of the line ( %s100%s for a straight line )', 'rrj-ac' ), '<code>', '</code>' ),
					),
					array(
						'type' => 'checkbox',
						'param_name' => 'hidden',
						'heading' => __( 'Hidden on load', 'rrj-ac' ),
						'description' => __( 'this dataset will be hidden on load until the corresponding legend is clicked on', 'rrj-ac' ),
						'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
						'std' => '',
					),
				),
			),
		);
		/**
		 *  LEGEND AND TOOLTIP
		 */
		$tooltip_options = rrj_ac_tooltip_options();
		/**
		 *  CHART OPTIONS
		 */
		$chart_options = rrj_ac_chart_options();
		
		$axis_prefix = rrj_ac_axes_prefix();
		$axis_suffix = rrj_ac_axes_suffix();
		
		$params = array_merge( $params, $tooltip_options, $chart_options, $axis_prefix, $axis_suffix );
		
		/**
		 *  DESIGN OPTIONS
		 */
		$params = array_merge( $params, array( array(
			'type' => 'css_editor',
			'heading' => __( 'CSS', 'rrj-ac' ),
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
			'set_type' => 'line',
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
rrj_line_chart::instance();