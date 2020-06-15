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

if ( !empty( $importer['labels'] ) ) {
	$labels = rrj_values_from_string( $importer['labels'], true );
} else {
	$labels = rrj_values_from_string( $labels, true );
}
$_datasets = array();

$tooltips_formats = array();
foreach ( $datasets as $index => $_set ) {
	$set = array();
	
	if ( isset( $importer['sets'] ) && isset( $importer['sets'][$index] ) ) {
		$_values = rrj_values_from_string( $importer['sets'][$index] );
	} else {
		$_values = rrj_values_from_string( $_set['values'] );
	}
	
	$set['label'] = $_set['title'];
	$basecolor = !empty( $_set['color'])? $_set['color'] : $_set_color;
	$diluted2 = $colors->dilute( $basecolor, 0.2 );
	$diluted8 = $colors->dilute( $basecolor, 0.8 );
	$set['backgroundColor'] = $diluted2;
	$set['borderColor'] = $diluted8;
	$set['pointBackgroundColor'] = $diluted8;
	$set['pointBorderColor'] = $diluted8;
	$set['pointHoverBackgroundColor'] = $basecolor;
	$set['pointHoverBorderColor'] = $basecolor;
	$set['hidden'] = isset( $_set['hidden'] ) && 'yes' == $_set['hidden'];
	$set['data'] = $_values;
	$format = $_set['title'] . ': {y}';
	if ( !empty( $_set['tooltips_format'] ) ) {
		$format = str_ireplace( '{d}', $_set['title'], $_set['tooltips_format'] );
	}
	$tooltips_formats[] = $format;
	$_datasets[] = $set;
}

$options = array(
	'animation' => array( 'duration' => 2000 ),
	'maintainAspectRatio' => true,
	'scale' => array(
		'gridLines' => array(
			'color' => $colors->dilute( $axes_color, 0.2 ),
		),
		'angleLines' => array(
			'color' => $colors->dilute( $axes_color, 0.2 ),
		),
		'pointLabels' => array(
			'fontColor' => $colors->dilute( $axes_color, 0.8 ),
		),
		'ticks' => array(
			'fontColor' => $colors->dilute( $axes_color, 0.8 ),
			'display' => !empty( $yaxis_labels )? true : false,
			'backdropColor' => $yaxis_labels_bg,
			'beginAtZero' => !empty( $axis_zero )? true : false,
		),
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
		'intersect' => true,
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
	$options['axisFormat']['prefix'] = $axis_prefix;
}

if ( !empty( $axis_suffix ) ) {
	$options['axisFormat']['suffix'] = $axis_suffix;
}

$data = array(
	'labels' => $labels,
	'datasets' => $_datasets,
);
$options['noTsep'] = (bool)$ignore_tsep;
$chart_data = array(
	'type' => 'radar',
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

?><div class="rrj-chart rrj-radar-chart">
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