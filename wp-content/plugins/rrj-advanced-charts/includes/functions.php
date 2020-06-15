<?php
/**
 *  enqueue chartjs with same arguments for all elements
 */
function rrj_enqueue_chartjs() {
	wp_enqueue_script( 'rrj-chartjs', RRJ_AC_URL . 'assets/libs/ChartJs/Chart.min.js', array(), '2.7.2' );
	$plugin = rrj_charts::instance();
	$options = $plugin->get_option();
	$ff = str_replace( '"', "'", $options['font-family'] );
	ob_start();
	?>;rrjChart.defaults.global.defaultFontFamily = "<?php echo $ff; ?>";<?php
	$script = ob_get_clean();
	wp_add_inline_script( 'rrj-chartjs', $script );
}

/**
 *  axes label prefix
 */
function rrj_ac_axes_prefix( $type = 'single', $head = '', $desc = '' ) {
	if ( empty( $head ) ) {
		$head = __( 'axis prefix', 'rrj-ac' );
	}
	if ( empty( $desc ) ) {
		$desc = __( 'String to prepend to axis labels. Useful for adding monetary signs ($, €, £) or any other units', 'rrj-ac' );
	}
	switch ( $type ) {
		case 'all':
			$result = array(
				array(
					'type' => 'textfield',
					'param_name' => 'xaxis_prefix',
					'heading' => __( 'X axis prefix', 'rrj-ac' ),
					'description' => __( 'X axis labels prefix. Useful for adding monetary signs ($, €, £) or any other units', 'rrj-ac' ),
					'value' => '',
					'group' => __( 'Chart options', 'rrj-ac' ),
				),
				array(
					'type' => 'textfield',
					'param_name' => 'yaxis_prefix',
					'heading' => __( 'Y axis prefix', 'rrj-ac' ),
					'description' => __( 'Y axis labels prefix. Useful for adding monetary signs ($, €, £) or any other units', 'rrj-ac' ),
					'value' => '',
					'group' => __( 'Chart options', 'rrj-ac' ),
				),
			);
			break;
		default: // single
			$result = array(
				array(
					'type' => 'textfield',
					'param_name' => 'axis_prefix',
					'heading' => $head,
					'description' => $desc,
					'value' => '',
					'group' => __( 'Chart options', 'rrj-ac' ),
				)
			);
	}
	return $result;
}

/**
 *  axes label suffix
 */
function rrj_ac_axes_suffix( $type = 'single', $head = '', $desc = '' ) {
	if ( empty( $head ) ) {
		$head = __( 'axis suffix', 'rrj-ac' );
	}
	if ( empty( $desc ) ) {
		$desc = __( 'String to append to axis labels. Useful for adding monetary signs ($, €, £) or any other units', 'rrj-ac' );
	}
	switch ( $type ) {
		case 'all':
			$result = array(
				array(
					'type' => 'textfield',
					'param_name' => 'xaxis_suffix',
					'heading' => __( 'X axis suffix', 'rrj-ac' ),
					'description' => __( 'X axis labels suffix. Useful for adding monetary signs ($, €, £) or any other units', 'rrj-ac' ),
					'value' => '',
					'group' => __( 'Chart options', 'rrj-ac' ),
				),
				array(
					'type' => 'textfield',
					'param_name' => 'yaxis_suffix',
					'heading' => __( 'Y axis suffix', 'rrj-ac' ),
					'description' => __( 'Y axis labels suffix. Useful for adding monetary signs ($, €, £) or any other units', 'rrj-ac' ),
					'value' => '',
					'group' => __( 'Chart options', 'rrj-ac' ),
				),
			);
			break;
		default: // single
			$result = array(
				array(
					'type' => 'textfield',
					'param_name' => 'axis_suffix',
					'heading' => $head,
					'description' => $desc,
					'value' => '',
					'group' => __( 'Chart options', 'rrj-ac' ),
				)
			);
	}
	return $result;
}

/**
 *  chart options
 */
function rrj_ac_chart_options( $fields = array( 'ar' => true, 'axes_color' => true, 'axis_zero' => true, 'yaxis_labels' => true, 'xaxis_labels' => true ) ) {
	/**
	 *  common chart options
	 */
	$result = array(
		array(
			'type' => 'dropdown',
			'param_name' => 'title_pos',
			'heading' => __( 'Widget title position', 'rrj-ac' ),
			'value' => array(
				__( 'top', 'rrj-ac' ) => 'top',
				__( 'bottom', 'rrj-ac' ) => 'bottom',
			),
			'std' => 'top',
			'group' => __( 'Chart options', 'rrj-ac' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'title_align',
			'heading' => __( 'Title alignment', 'rrj-ac' ),
			'value' => array(
				__( 'left', 'rrj-ac' ) => 'left',
				__( 'center', 'rrj-ac' ) => 'center',
				__( 'right', 'rrj-ac' ) => 'right',
				__( 'auto', 'rrj-ac' ) => 'auto',
			),
			'std' => 'auto',
			'group' => __( 'Chart options', 'rrj-ac' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'title_tag',
			'heading' => __( 'HTML tag used for the widget title the title', 'rrj-ac' ),
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
			),
			'std' => 'h3',
			'group' => __( 'Chart options', 'rrj-ac' ),
		),
	);
	
	/**
	 *  Aspect Ratio
	 */
	if ( array_key_exists( 'ar', $fields ) ) {
		$result[] = array(
			'type' => 'dropdown',
			'param_name' => 'ar',
			'heading' => __( 'Aspect Ratio', 'rrj-ac' ),
			'value' => rrj_charts::AR(),
			'std' => '4:3',
			'group' => __( 'Chart options', 'rrj-ac' ),
		);
		$result[] = array(
			'type' => 'textfield',
			'heading' => __( 'Custom aspect ratio', 'rrj-ac' ),
			'param_name' => 'car',
			'value' => '',
			'description' => sprintf( __( 'If set, the value of the dropdown above will be ignored. (%s width : height %s)', 'rrj-ac' ), '<code>', '</code>' ),
			'group' => __( 'Chart options', 'rrj-ac' ),
		);
	}
	
	/**
	 *  axes and grid lines color
	 */
	if ( array_key_exists( 'axes_color', $fields ) ) {
		$result[] = array(
			'type' => 'colorpicker',
			'heading' => __( 'Grid and axes color', 'rrj-ac' ),
			'param_name' => 'axes_color',
			'value' => 'rgba(100,100,100,0.8)',
			'group' => __( 'Chart options', 'rrj-ac' ),
		);
	}
	
	/**
	 *  ignore thousand separator
	 */
	$result[] = array(
		'type' => 'checkbox',
		'param_name' => 'ignore_tsep',
		'heading' => __( 'No thousand separator', 'rrj-ac' ),
		'description' => __( 'Do not use thousand separator (if any) on this chart', 'rrj-ac' ),
		'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
		'group' => __( 'Chart options', 'rrj-ac' ),
		'std' => '',
	);
	
	/**
	 *  force axis to start from zero
	 */
	if ( array_key_exists( 'axis_zero', $fields ) ) {
		$desc = __( 'Force Y axis to start at zero', 'rrj-ac' );
		$head = __( 'Y axis starts at zero', 'rrj-ac' );
		if ( is_array( $fields['axis_zero'] ) ) {
			if ( isset( $fields['axis_zero']['description'] ) ) {
				$desc = $fields['axis_zero']['description'];
			}
			if ( isset( $fields['axis_zero']['heading'] ) ) {
				$head = $fields['axis_zero']['heading'];
			}
		}
		
		$result[] = array(
			'type' => 'checkbox',
			'param_name' => 'axis_zero',
			'heading' => $head,
			'description' => $desc,
			'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
			'group' => __( 'Chart options', 'rrj-ac' ),
			'std' => 'yes',
		);
	}
	
	/**
	 *  show Y axis labels (thicks)
	 */
	if ( array_key_exists( 'yaxis_labels', $fields ) ) {
		$result[] = array(
			'type' => 'checkbox',
			'param_name' => 'yaxis_labels',
			'heading' => __( 'Y axis labels', 'rrj-ac' ),
			'description' => __( 'Show Y axis labels', 'rrj-ac' ),
			'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
			'group' => __( 'Chart options', 'rrj-ac' ),
			'std' => 'yes',
		);
	}
	
	/**
	 *  show X axis labels (thicks)
	 */
	if ( array_key_exists( 'xaxis_labels', $fields ) ) {
		$result[] = array(
			'type' => 'checkbox',
			'param_name' => 'xaxis_labels',
			'heading' => __( 'X axis labels', 'rrj-ac' ),
			'description' => __( 'Show X axis labels', 'rrj-ac' ),
			'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
			'group' => __( 'Chart options', 'rrj-ac' ),
			'std' => 'yes',
		);
	}
	return $result;
}

/**
 *  tooltip options
 */
function rrj_ac_tooltip_options( $fields = array() ) {
	$defaults = array(
		'legend' => true,
		'legend_position' => true,
		'legend_style' => true,
		'legend_onclick' => true,
		'tooltip' => true,
		'tooltip_mode' => true,
	);
	$args = array_merge( $defaults, $fields );
	$options = array();
	if ( $args['legend'] ) {
		$options = array_merge( $options, array( array(
			'type' => 'checkbox',
			'param_name' => 'legend',
			'heading' => __( 'Enable legends', 'rrj-ac' ),
			'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
			'std' => 'yes',
			'group' => __( 'Tooltips and Legends', 'rrj-ac' ),
		) ) );
	}
	if ( $args['legend_position'] ) {
		$options = array_merge( $options, array( array(
			'type' => 'dropdown',
			'param_name' => 'legend_position',
			'heading' => __( 'Legends position', 'rrj-ac' ),
			'value' => array(
				__( 'top', 'rrj-ac' ) => 'top',
				__( 'right', 'rrj-ac' ) => 'right',
				__( 'bottom', 'rrj-ac' ) => 'bottom',
				__( 'left', 'rrj-ac' ) => 'left',
			),
			'std' => 'bottom',
			'group' => __( 'Tooltips and Legends', 'rrj-ac' ),
		) ) );
	}
	if ( $args['legend_style'] ) {
		$options = array_merge( $options, array( array(
			'type' => 'dropdown',
			'param_name' => 'legend_style',
			'heading' => __( 'Legends style', 'rrj-ac' ),
			'value' => array(
				__( 'normal', 'rrj-ac' ) => 'normal',
				__( 'use point style', 'rrj-ac' ) => 'point',
			),
			'std' => 'normal',
			'group' => __( 'Tooltips and Legends', 'rrj-ac' ),
		) ) );
	}
	if ( $args['legend_onclick'] ) {
		$options = array_merge( $options, array( array(
			'type' => 'checkbox',
			'param_name' => 'legend_onclick',
			'heading' => __( 'Click on legends', 'rrj-ac' ),
			'description' => __( 'Hide dataset on click on legend', 'rrj-ac' ),
			'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
			'std' => 'yes',
			'group' => __( 'Tooltips and Legends', 'rrj-ac' ),
		) ) );
	}
	if ( $args['tooltip'] ) {
		$options = array_merge( $options, array( array(
			'type' => 'checkbox',
			'param_name' => 'tooltip',
			'heading' => __( 'Enable Tooltips', 'rrj-ac' ),
			'value' => array( __( 'yes', 'rrj-ac' ) => 'yes' ),
			'std' => 'yes',
			'group' => __( 'Tooltips and Legends', 'rrj-ac' ),
		) ) );
	}
	if ( $args['tooltip_mode'] ) {
		$options = array_merge( $options, array( array(
			'type' => 'dropdown',
			'param_name' => 'tooltip_mode',
			'heading' => __( 'Tooltips mode', 'rrj-ac' ),
			'value' => array(
				__( 'highlight single element', 'rrj-ac' ) => 'nearest',
				__( 'highlight elements at the same index', 'rrj-ac' ) => 'index',
			),
			'std' => 'index',
			'group' => __( 'Tooltips and Legends', 'rrj-ac' ),
		) ) );
	}
	return $options;
}

/**
 *  custom JS options
 */
function rrj_js_options() {
	return array(
		'type' => 'rrj_jseditor',
		'param_name' => 'jsoptions',
		'heading' => __( 'JavaScript options', 'rrj-ac' ),
		'value' => base64_encode( '{}' ),
		'group' => __( 'JS options', 'rrj-ac' ),
		'description' => __( 'Custom options (will take precedence over the other fields)', 'rrj-ac' ),
	);
}

/**
 *  custom JS data
 */
function rrj_js_data() {
	$fields = array();
	
	$fields[] = array(
		'type' => 'rrj_jseditor',
		'param_name' => 'jsdata',
		'heading' => __( 'JavaScript data', 'rrj-ac' ),
		'value' => '',
		'group' => __( 'JS data', 'rrj-ac' ),
		'description' => __( 'Custom chart data function', 'rrj-ac' ),
	);
	
	$fields[] = array(
		'type' => 'attach_image',
		'param_name' => 'preloaderimage',
		'heading' => __( 'Preloader image', 'rrj-ac' ),
		'group' => __( 'JS data', 'rrj-ac' ),
		'description' => __( 'Alternative preloader image (typically a small animated .gif image)', 'rrj-ac' ),
	);
	
	return $fields;
}

/**
 *  prints the preloader
 */
function rrj_preloader( $AR, $img = '' ) {
	$url = RRJ_AC_URL . 'assets/images/loading.gif';
	$height = 52;
	if ( !empty( $img ) ) {
		$meta = wp_get_attachment_metadata( absint( $img ) );
		$_url = wp_get_attachment_url( absint( $img ) );
		if ( $meta['height'] && $_url ) {
			$url = $_url;
			$height = $meta['height'];
		}
	}
	?><div class="rrj-preload-wrap" style="position:relative;text-align:center;padding-bottom:<?php echo ( 100 * $AR[1] / $AR[0] ); ?>%;width:100%;height:0;">
		<div class="rrj-preloader-inner" style="padding-top:calc( <?php echo ( 50 * $AR[1] / $AR[0] ); ?>% - <?php echo $height; ?>px );"><img alt="" src="<?php echo $url; ?>" /></div>
	</div><?php
}

/**
 *  build values or labels data from string
 */
if ( !function_exists( 'rrj_values_from_string' ) ) {
	function rrj_values_from_string( $str, $labels = false ) {
		$values = explode( ';', trim( $str, '; ' ) );
		$result = array();
		foreach ( $values as $v ) {
			$v = trim( $v );
			if ( $labels ) {
				$result[] = ' ' . $v . ' ';
			} else {
				$result[] = ( empty( $v ) && '0' != $v )? NULL : floatval( $v );
			}
		}
		return $result;
	}
}

/**
 *  build values fo bubble chart
 */
if ( !function_exists( 'rrj_bubble_values' ) ) {
	function rrj_bubble_values( $str ) {
		$str = trim( $str );
		$res = preg_match_all( '#\[([^\]]+)\]#U', $str, $matches );
		if ( !$res ) {
			return array();
		} else {
			$values = $matches[1];
			$data = array();
			foreach ( $values as $val ) {
				$val = trim( $val, '][ ' );
				$val = explode( ';', $val );
				if ( 3 != count( $val ) ) continue;
				$point = new stdClass();
				$point->x = floatval( trim( $val[0] ) );
				$point->y = floatval( trim( $val[1] ) );
				$point->r = floatval( trim( $val[2] ) );
				$data[] = $point;
			}
			return $data;
		}
	}
}
