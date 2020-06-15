<?php
$colors = rrj_colors::instance();

$_set_color = '#999';
if ( empty( $axes_color ) ) $axes_color = 'rgba(100,100,100,0.8)';

$plugin = rrj_charts::instance();
$options = $plugin->get_option();

if ( $options['force-axes-color'] ) {
	$axes_color = $options['axes-color'];
}

$dataset = array(
	'backgroundColor' => array(),
	'hoverBackgroundColor' => array(),
	'data' => array(),
	'borderWidth' => ( 'yes' === $segment_borders )? 0 : 1.5,
);

$labels = array();
if ( empty( $tooltips_format ) ) {
	$tooltips_format = '{d}: {y}';
}

$_tooltips_formats = array();
foreach( $datasets as $set ) {
	$basecolor = ( !empty( $set['color'] ) )? $set['color'] : $_set_color;
	if ( 'plain' == $disc_bg ) {
		$dataset['hoverBackgroundColor'][] = $basecolor;
		$dataset['backgroundColor'][] = $colors->dilute( $basecolor, 0.9 );
	} else {
		$dataset['borderColor'][] = $colors->dilute( $basecolor, 0.9 );
		$dataset['hoverBorderColor'][] = $basecolor;
		$dataset['backgroundColor'][] = $colors->dilute( $basecolor, 0.3 );
		$dataset['hoverBackgroundColor'][] = $colors->dilute( $basecolor, 0.5 );
	}
	$dataset['data'][] = floatval( $set['value'] );
	$labels[] = $set['title'];
	$format = str_ireplace( '{d}', $set['title'], $tooltips_format );
	$_tooltips_formats[] = $format;
}

$options = array(
	'animation' => array( 'duration' => 2000 ),
	'maintainAspectRatio' => true,
	'cutoutPercentage' => absint( $cut ),
	'circumference' => pi() * 2 * ( absint( $circumference ) / 100 ),
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
		'bodySpacing' => 8,
		'titleSpacing' => 6,
		'cornerRadius' => 8,
		'xPadding' => 10,
	),
);

if ( empty( $legend_onclick ) ) {
	$options['legend']['onClick'] = NULL;
}

if ( '0' != $rotation ) {
	$options['rotation'] = ( 2 * pi() / 360 ) * absint( $rotation - 90 );
}

$options['noTsep'] = (bool)$ignore_tsep;
$chart_data = array(
	'type' => 'pie',
	'data' => array(
		'labels' => $labels,
		'datasets' => array( $dataset ),
	),
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

?><div class="rrj-chart rrj-pie-chart">
	<div class="<?php echo esc_attr( $css_class ); ?>">
		<?php if ( !empty( $title ) && 'top' == $title_pos ) :?>
		<<?php echo $title_tag; ?> class="chart-title" <?php if ( 'auto' != $title_align ) echo 'style="text-align:' . $title_align . '"'; ?>><?php echo $title; ?></<?php echo $title_tag; ?>>
		<?php endif; ?>
		<div class="chart-data" data-id="<?php echo $chart_id; ?>" style="display:none;"><?php echo json_encode( $chart_data ); ?></div>
		<div class="tooltips-data" style="display:none;"><?php echo json_encode( $_tooltips_formats ); ?></div>
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