<?php
class rrj_bubble_chart
{
	// the shortcode
	const code = 'rrj_bubble_chart';
	
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
			'name' => __( 'Bubble Chart', 'rrj-abs' ),
			'description' => __( 'Draw a bubble chart', 'rrj-ac' ),
			'base' => self::code,
			'class' => '',
			'icon' => RRJ_AC_URL . 'elements/bubble/bubble.png',
			'category' => 'Advanced Charts',
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
				'value' => __( 'Bubble Chart', 'rrj-ac' ),
				'admin_label' => true,
			),
			array(
				'type' => 'param_group',
				'param_name' => 'datasets',
				'heading' => __( 'Datasets', 'rrj-ac' ),
				'value' => urlencode( json_encode( array(
					array(
						'title' => __( 'One', 'rrj-ac' ),
						'tooltips_format' => 'y: {y} {n}x: {x} {n}r: {r}',
						'values' => '[-20;18;13] [18;-15;23] [22;16;18] [-12;7;11] [4;13;6]',
						'color' => '#0085ba',
						'fill' => 'transparent',
						'hidden' => '',
					),
					array(
						'title' => __( 'Two', 'rrj-ac' ),
						'tooltips_format' => 'y: {y} {n}x: {x} {n}r: {r}',
						'values' => '[-17;-16;12] [-14;-8;18] [-2;1;20] [4;8;11] [8;17;6]',
						'color' => '#dd3333',
						'fill' => 'transparent',
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
						'description' => __( 'text format for the tooltip (available placeholders: {d} dataset title, {x} X value, {y} Y value, {r} R value, {n} line break)', 'rrj-ac' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Values', 'rrj-ac' ),
						'param_name' => 'values',
						'description' => sprintf( __( 'values in the format %s', 'rrj-ac' ), '<code>[x1;y1;r1] ... [xn;yn;rn]</code>' ),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __( 'Dataset color', 'rrj-ac' ),
						'param_name' => 'color',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'fill',
						'heading' => __( 'Bubble color', 'rrj-ac' ),
						'description' => __( 'how to fill bubbles', 'rrj-ac' ),
						'value' => array(
							__( 'partially transparent', 'rrj-ac' ) => 'transparent', 
							__( 'plain color', 'rrj-ac' ) => 'plain',
						),
						'std' => 'transparent',
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
		);// end $params
		
		/**
		 *  LEGEND AND TOOLTIP
		 */
		$tooltip_options = rrj_ac_tooltip_options( array( 'tooltip_mode' => false ) );
		
		/**
		 *  CHART OPTIONS
		 */
		$chart_options = rrj_ac_chart_options();
		
		$axis_prefix = rrj_ac_axes_prefix( 'all' );
		$axis_suffix = rrj_ac_axes_suffix( 'all' );
		
		$params = array_merge( $params, $tooltip_options, $chart_options, $axis_prefix, $axis_suffix );
		
		$params = array_merge( $params, array( array(
			'type' => 'checkbox',
			'param_name' => 'xaxis_zero',
			'heading' => __( 'X axis starts at zero', 'rrj-ac' ),
			'description' => __( 'Force X axis to start at zero', 'rrj-ac' ),
			'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
			'group' => __( 'Chart options', 'rrj-ac' ),
		) ) );
		
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
			'set_type' => 'bubble',
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
rrj_bubble_chart::instance();