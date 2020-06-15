<?php
class rrj_polar_chart
{
	// the shortcode
	const code = 'rrj_polar_chart';
	
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
			'name' => __( 'Polar Area Chart', 'rrj-ac' ),
			'description' => __( 'Draw a polar area chart', 'rrj-ac' ),
			'base' => self::code,
			'class' => '',
			'icon' => RRJ_AC_URL . 'elements/polar/polar.png',
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
				'value' => __( 'Polar Area Chart', 'rrj-ac' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield', 
				'param_name' => 'tooltips_format',
				'heading' => __( 'Tooltips text format', 'rrj-ac' ),
				'value' => '{d}: {y}',
				'description' => __( 'text format for the tooltip (available placeholders: {d} the segment title, {y} the segment value)', 'rrj-ac' ),
			),
			array(
				'type' => 'param_group',
				'heading' => __( 'Data', 'rrj-ac' ),
				'param_name' => 'datasets',
				'value' => urlencode( json_encode( array(
					array(
						'title' => 'One',
						'color' => '#1e73be',
						'value' => '26',
					),
					array(
						'title' => 'Two',
						'color' => '#ec3bef',
						'value' => '24',
					),
					array(
						'title' => 'Three',
						'color' => '#f29b37',
						'value' => '16',
					),
					array(
						'title' => 'Four',
						'color' => '#9fe045',
						'value' => '28',
					),
					array(
						'title' => 'Five',
						'color' => '#eeee22',
						'value' => '14',
					),
				) ) ),
				'params' => array(
					array(
						'type' => 'textfield',
						'param_name' => 'title',
						'heading' => __( 'Title', 'rrj-ac' ),
						'desciption' => __( 'the title used for tooltips and legends', 'rrj-ac' ),
						'admin_label' => true,
					),
					array(
						'type' => 'colorpicker',
						'param_name' => 'color',
						'heading' => __( 'Color', 'rrj-ac' ),
					),
					array(
						'type' => 'textfield',
						'param_name' => 'value',
						'heading' => __( 'Value', 'rrj-ac' ),
						'admin_label' => true,
					),
				),
			),
			array(
				'type' => 'checkbox',
				'param_name' => 'segment_borders',
				'heading' => __( 'Remove segments borders', 'rrj-ac' ),
				'description' => __( 'will remove borders around segments', 'rrj-ac' ),
				'group' => __( 'Disc settings', 'rrj-ac' ),
				'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
				'std' => 'yes',
			),
		);
		/**
		 *  LEGEND AND TOOLTIP
		 */
		$tooltip_options = rrj_ac_tooltip_options( array( 'tooltip_mode' => false ) );
		
		/**
		 *  CHART OPTIONS
		 */
		$chart_options = rrj_ac_chart_options(
			array(
				'ar' => true,
				'axis_zero' => true,
				'axes_color' => true,
				'yaxis_labels' => true,
			)
		);
		
		$chart_options = array_merge( $chart_options, 
			array( array(
				'type' => 'dropdown',
				'param_name' => 'disc_bg',
				'heading' => __( 'Segments background', 'rrj-ac' ),
				'value' => array(
					__( 'partially transparent', 'rrj-ac' ) => 'transparent',
					__( 'plain color', 'rrj-ac' ) => 'plain',
				),
				'std' => 'plain',
				'group' => __( 'Chart options', 'rrj-ac' ),
				'description' => __( 'how to fill chart segments', 'rrj-ac' ),
			) )
		);
		
		$axis_prefix = rrj_ac_axes_prefix();
		$axis_suffix = rrj_ac_axes_suffix();
		
		$params = array_merge( $params, $tooltip_options, $chart_options, $axis_prefix, $axis_suffix );
		
		/**
		 *  y axis label background color
		 */
		$params[] = array(
			'type' => 'colorpicker',
			'heading' => __( 'Y axis labels background', 'rrj-ac' ),
			'param_name' => 'yaxis_labels_bg',
			'value' => 'rgba(0,0,0,0)',
			'group' => __( 'Chart options', 'rrj-ac' ),
		);
		
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
rrj_polar_chart::instance();