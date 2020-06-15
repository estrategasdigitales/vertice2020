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

$sets = array();

$tooltips_formats = array();
foreach ( $datasets as $index => $set ) {
	$basecolor = isset( $set['color'] )? $set['color'] : $_set_color;
	$bordercolor = $colors->dilute( $basecolor, .9 );
	$fillcolor = ( 'transparent' == $set['bar_bg'] )? $colors->dilute( $basecolor, 0.25 ) : $colors->dilute( $basecolor, .95 );
	$hoverfillcolor = ( 'transparent' == $set['bar_bg'] )? $colors->dilute( $basecolor, 0.33 ) : $basecolor;
	
	if ( isset( $importer['sets'] ) && isset( $importer['sets'][$index] ) ) {
		$_values = rrj_values_from_string( $importer['sets'][$index] );
	} else {
		$_values = rrj_values_from_string( $set['values'] );
	}
	
	$_set = array(
		'label' => $set['title'],
		'borderWidth' => 1,
		'borderColor' => $bordercolor,
		'hoverBorderColor' => $basecolor,
		'backgroundColor' => $fillcolor,
		'hoverBackgroundColor' => $hoverfillcolor,
		'data' => $_values,
		'hidden' => isset( $set['hidden'] ) && 'yes' == $set['hidden'],
	);
	if ( isset( $set['group'] ) ) {
		$_set['stack'] = $set['group'];
	}
	$format = $set['title'] . ': {y}';
	if ( !empty( $set['tooltips_format'] ) ) {
		$format = str_ireplace( '{d}', $set['title'], $set['tooltips_format'] );
	}
	$tooltips_formats[] = $format;
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
				'ticks' => array(
					'fontColor' => !empty( $yaxis_labels )? $axes_color : 'rgba(0,0,0,0)',
				),
				'gridLines' => array(
					'color' => $colors->dilute( $axes_color, 0.2 ),
					'zeroLineColor' => $colors->dilute( $axes_color, 0.6 ),
				),
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
		'bodySpacing' => 8,
		'titleSpacing' => 6,
		'cornerRadius' => 8,
		'xPadding' => 10,
	),
);

if ( !empty( $axis_zero ) ) {
	if ( 'horz' == $orientation ) {
		$options['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
	} else {
		$options['scales']['yAxes'][0]['ticks']['beginAtZero'] = true;
	}
}

if ( !empty( $stacked ) ) {
	if ( 'bars' == $stack_mode ) {
		$options['scales']['yAxes'][0]['stacked'] = true;
		$options['scales']['xAxes'][0]['stacked'] = true;
	} else {
		if ( 'horz' == $orientation ) {
			$options['scales']['yAxes'][0]['stacked'] = true;
		} else {
			$options['scales']['xAxes'][0]['stacked'] = true;
		}
	}
}

if ( 'horz' == $orientation ) {
	$options['scales']['yAxes'][0]['categoryPercentage'] = absint( $cat_per ) / 100;
	$options['scales']['yAxes'][0]['barPercentage'] = absint( $bar_per ) / 100;
} else {
	$options['scales']['xAxes'][0]['categoryPercentage'] = absint( $cat_per ) / 100;
	$options['scales']['xAxes'][0]['barPercentage'] = absint( $bar_per ) / 100;
}

if ( empty( $legend_onclick ) ) {
	$options['legend']['onClick'] = NULL;
}

if ( !empty( $axis_prefix ) ) {
	if ( 'horz' == $orientation ) {
		$options['xAxisFormat']['prefix'] = $axis_prefix;
	} else {
		$options['yAxisFormat']['prefix'] = $axis_prefix;
	}
}

if ( !empty( $axis_suffix ) ) {
	if ( 'horz' == $orientation ) {
		$options['xAxisFormat']['suffix'] = $axis_suffix;
	} else {
		$options['yAxisFormat']['suffix'] = $axis_suffix;
	}
}

$data = array(
	'labels' => $labels,
	'datasets' => $sets,
);
$options['noTsep'] = (bool)$ignore_tsep;
$chart_data = array(
	'type' => ( 'horz' == $orientation )? 'horizontalBar' : 'bar',
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

?><div class="rrj-chart rrj-bar-chart">
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