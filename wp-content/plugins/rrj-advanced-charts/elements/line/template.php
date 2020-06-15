<?php

$colors = rrj_colors::instance();
$importer = json_decode( base64_decode( $importer ), true );

$_set_color = '#999';
if ( empty( $axes_color ) ) $axes_color = 'rgba(100,100,100,0.8)';

$plugin = rrj_charts::instance();
$options = $plugin->get_option();

if ( $options['force-axes-color'] ) {
	$axes_color = $options['axes-color'];
}

$_thickness = array(
	'thin' => array(
		'borderWidth' => 1,
		'pointRadius' => 3,
		'pointHitRadius' => 3,
		'pointBorderWidth' =>  1,
		'pointHoverRadius' =>  5,
		'pointHoverBorderWidth' => 1,
	),
	'normal' => array(
		'borderWidth' => 2,
		'pointRadius' => 4,
		'pointHitRadius' => 3,
		'pointBorderWidth' =>  1,
		'pointHoverRadius' =>  5,
		'pointHoverBorderWidth' => 1,
	),
	'thick' => array(
		'borderWidth' => 3,
		'pointRadius' => 5,
		'pointHitRadius' => 3,
		'pointBorderWidth' =>  1,
		'pointHoverRadius' =>  6,
		'pointHoverBorderWidth' => 1,
	),
	'thicker' => array(
		'borderWidth' => 4,
		'pointRadius' => 6,
		'pointHitRadius' => 3,
		'pointBorderWidth' =>  1,
		'pointHoverRadius' =>  6,
		'pointHoverBorderWidth' => 1,
	),
);

$_borderDash = array(
	'solid' => array(),
	'dashed' => array( 16, 8 ),
	'dotted' => array( 3, 3 ),
);

$sets = array();
$tooltips_formats = array();
foreach ( $datasets as $index => $set ) {
	$basecolor = isset( $set['color'] )? $set['color'] : $_set_color;
	$shadecolor = $colors->shade( $basecolor, 10, 'rgba' );
	$fillcolor = ( 'plain' != $set['fill'] )? $colors->dilute( $basecolor, 0.2 ) : $basecolor;
	
	if ( isset( $importer['sets'] ) && isset( $importer['sets'][$index] ) ) {
		$_values = rrj_values_from_string( $importer['sets'][$index] );
	} else {
		$_values = rrj_values_from_string( $set['values'] );
	}
	
	$_set = array(
		'label' => $set['title'],
		'fill' => ( 'none' != $set['fill'] )? true : false,
		'backgroundColor' => $fillcolor,
		'lineTension' => ( 100 - absint( $set['linetension'] ) ) * 0.37 / 100,
		'borderColor' => $basecolor,
		'borderCapStyle' => 'butt',
		'borderDash' => $_borderDash[$set['line_style']],
		'borderDashOffset' => 0.0,
		'borderJoinStyle' => 'miter',
		'pointBorderColor' => $basecolor,
		'pointBackgroundColor' => $shadecolor,
		'pointHoverBackgroundColor' => $basecolor,
		'pointHoverBorderColor' => $shadecolor, 
		'data' => $_values,
		'spanGaps' =>  false,
		'showLine' => ( 'none' != $set['line_type'] )? true : false,
		'steppedLine' => ( 'step' == $set['line_type'] )? true : false,
		'pointStyle' => ( 'none' != $set['point_style'] )? $set['point_style'] : 'circle',
		'hidden' => isset( $set['hidden'] ) && 'yes' == $set['hidden'],
	);
	$format = $set['title'] . ': {y}';
	if ( !empty( $set['tooltips_format'] ) ) {
		$format = str_ireplace( '{d}', $set['title'], $set['tooltips_format'] );
	}
	$tooltips_formats[] = $format;
	$_set += $_thickness[$set['thickness']];
	if ( 'none' == $set['point_style'] ) {
		$_set = array_merge( $_set, array(
				'borderWidth' => 0,
				'pointRadius' => 1,
				'pointHitRadius' => 0,
				'pointBorderWidth' =>  1,
				'pointHoverRadius' =>  1,
				'pointHoverBorderWidth' => 0,
			)
		);
	}
	$sets[] = $_set;
}
if ( !empty( $importer['labels'] ) ) {
	$labels = rrj_values_from_string( $importer['labels'], true );
} else {
	$labels = rrj_values_from_string( $labels, true );
}
$options = array(
	'animation' => array( 'duration' => 2000 ),
	'maintainAspectRatio' => true,
	'scales' => array(
		'yAxes' => array(
			array(
				// 'display' => false,
				'ticks' => array(
					'fontColor' => !empty( $yaxis_labels )? $axes_color : 'rgba(0,0,0,0)',
					'beginAtZero' => !empty( $axis_zero )? true : false,
				),
				'gridLines' => array(
					'color' => $colors->dilute( $axes_color, 0.2 ),
					'zeroLineColor' => $colors->dilute( $axes_color, 0.6 ),
				),
				'stacked' => !empty( $stacked )? true : false,
			),
		),
		'xAxes' => array(
			array(
				'ticks' => array(
					'fontColor' => !empty( $xaxis_labels )? $axes_color : 'rgba(0,0,0,0)',
				),
				'gridLines' => array(
					'color' => $colors->dilute( $axes_color, 0.2 ),
					'zeroLineColor' => $colors->dilute( $axes_color, 0.6 ),
				),
			),
		)
	),
	'legend' => array(
		'display' => !empty( $legend )? true : false,
		'position' => $legend_position,
		'labels' => array(
			'usePointStyle' => ( 'point' == $legend_style )? true : false,
			'padding' => 20,
			'boxWidth' => 12,
			'fontSize' => max( absint( $options['legend-font-size'] ), 8 ),
			'fontColor' => $options['legend-font-color'],
		),
	),
	'tooltips' => array(
		'enabled' => !empty( $tooltip )? true : false,
		'mode' => $tooltip_mode,
		'intersect' => false,
		'bodySpacing' => 8,
		'titleSpacing' => 6,
		'cornerRadius' => 8,
		'xPadding' => 10,
	),
);
if ( empty( $legend_onclick ) ) {
	$options['legend']['onClick'] = NULL;
}

if ( !empty( $axis_prefix ) ) {
	$options['yAxisFormat']['prefix'] = $axis_prefix;
}

if ( !empty( $axis_suffix ) ) {
	$options['yAxisFormat']['suffix'] = $axis_suffix;
}

$data = array(
	'labels' => $labels,
	'datasets' => $sets,
);
$options['noTsep'] = (bool)$ignore_tsep;
$chart_data = array(
	'type' => 'line',
	'data' => $data,
	'options' => $options,
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), self::code, $atts_array );
$AR = rrj_charts::process_ar( $ar, $car );
$chart_id = wp_generate_password( 8, false );

$jsoptions = base64_decode( $jsoptions );
$jsoptions = str_replace( array( "\n","\r" ), '', $jsoptions );
$jsoptions = preg_replace( '#\s+#', ' ', $jsoptions );

$jsdata = base64_decode( $jsdata );
$jsdata = str_replace( array( "\n","\r" ), '', $jsdata );
$jsdata = preg_replace( '#\s+#', ' ', $jsdata );

?><div class="rrj-chart rrj-line-chart">
	<div class="<?php echo esc_attr( $css_class ); ?>">
		<?php if ( !empty( $title ) && 'top' == $title_pos ) :?>
		<<?php echo $title_tag; ?> class="chart-title" <?php if ( 'auto' != $title_align ) echo 'style="text-align:' . $title_align . '"'; ?>><?php echo $title; ?></<?php echo $title_tag; ?>>
		<?php endif; ?>
		<div class="chart-data" data-id="<?php echo $chart_id; ?>" style="display:none;"><?php echo json_encode( $chart_data ); ?></div>
		<div class="tooltips-data" style="display:none;"><?php echo json_encode( $tooltips_formats ); ?></div>
		<?php if ( '{}' != trim( $jsoptions ) && !empty( $jsoptions ) ) : ?>
			<script type="text/javascript">
			if ( 'undefined' === typeof rrjChartOptions ) {
				var rrjChartOptions = {};
			}
			<?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
				rrjChartOptions['<?php echo $chart_id; ?>'] = <?php echo $jsoptions; ?>;
			<?php else: ?>
				try {
					rrjChartOptions['<?php echo $chart_id; ?>'] = <?php echo $jsoptions; ?>;
				} catch ( Ex ) {
					console.log( 'Advanced Charts >> <?php printf( __( 'Error in custom chart options. Chart ID: "%s"', 'rrj-ac' ), $chart_id ); ?>' );
				}
			<?php endif; ?>
			</script>
		<?php  endif; ?>
		<?php if ( !empty( $jsdata ) ) : ?>
			<script type="text/javascript">
			if ( 'undefined' === typeof rrjChartData ) {
				var rrjChartData = {};
			}
			<?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
				rrjChartData['<?php echo $chart_id; ?>'] = function($){<?php echo $jsdata; ?>};
			<?php else : ?>
				try {
					rrjChartData['<?php echo $chart_id; ?>'] = function($){<?php echo $jsdata; ?>};
				} catch ( Ex ) {
					console.log( 'Advanced Charts >> <?php printf( __( 'Error in custom chart data. Chart ID: "%s"', 'rrj-ac' ), $chart_id ); ?>' );
				}
			<?php  endif; ?>
			</script>
		<?php endif; ?>
		<canvas style="width:<?php echo $AR[0]; ?>px;height:<?php echo $AR[1]; ?>px;"></canvas>
		<?php rrj_preloader( $AR, $preloaderimage ); ?>
		<?php if ( !empty( $title ) && 'bottom' == $title_pos ) :?>
		<<?php echo $title_tag; ?> class="chart-title" <?php if ( 'auto' != $title_align ) echo 'style="text-align:' . $title_align . '"'; ?>><?php echo $title; ?></<?php echo $title_tag; ?>>
		<?php endif; ?>
	</div>
</div>