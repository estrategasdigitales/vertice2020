;(function($){
	var charts = {};
	
	function axisThickTSep( t, e, n ) {
		return t.toString().replace( /\B(?=(\d{3})+(?!\d))/g, rrjChartPluginOptions['t-separator'] );
	}
	
	function maybeDrawChart( chartdata ) {
		if ( 'undefined' != typeof chartdata ) {
			
		} else {
			// IE9+
			var Y = window.pageYOffset + window.innerHeight;
			for ( var i in charts ) {
				
				var C = charts[i];
				if ( false === C.s ) {
					// chart not yet created
					if ( false === C.d ) {
						// delayed chart creation (custom JS chart data)
						continue;
					}
					
					var delay = parseInt( rrjChartPluginOptions.init, 10 );
					if ( isNaN( delay ) ) {
						delay = 0;
					}
					// initialize only if the chart container is about to enter the viewport
					if ( Y > C.e.offset().top + ( delay * C.e.height() / 100 ) ) {
						
						/**
						 *  tooltip format
						 */
						if ( C.t ) {
							// tooltip format
							C.d.options.tooltips.callbacks = {};
							C.d.options.tooltipsFormat = C.t;
							
							if ( 'bubble' == C.d.type ) {
								C.d.options.tooltips.callbacks.label = function( item, data ){
									
									var format = data.datasets[0]._meta[Object.keys( data.datasets[0]._meta )[0]].controller.chart.options.tooltipsFormat[item.datasetIndex];
									
									/**
									 *  replace all placeholders
									 */
									format = format.replace( 
										/\{y\}/gi,
										data.datasets[item.datasetIndex]['data'][item.index]['y']
									).replace(
										/\{x\}/gi,
										data.datasets[item.datasetIndex]['data'][item.index]['x']
									).replace(
										/\{r\}/gi,
										data.datasets[item.datasetIndex]['data'][item.index]['r']
									);
									
									/**
									 *  split into array for new lines
									 */
									format = format.split( '{n}' );
									return format;
								}
							} else if ( 'pie' == C.d.type || 'polarArea' == C.d.type ) {
								C.d.options.tooltips.callbacks.label = function( item, data ){
									return data.datasets[0]._meta[Object.keys( data.datasets[0]._meta )[0]].controller.chart.options.tooltipsFormat[item.index].replace( /\{y\}/gi, data.datasets[0].data[item.index] );
								}
							} else {
								C.d.options.tooltips.callbacks.label = function( item, data ){
									if ( 'string' != typeof item.yLabel && isNaN( item.yLabel ) ) {
										return '';
									} else {
										
										/**
										 *  replace all placeholders
										 */
										var format = data.datasets[0]._meta[Object.keys( data.datasets[0]._meta )[0]].controller.chart.options.tooltipsFormat[item.datasetIndex];
										return format.replace( /\{y\}/gi, item.yLabel ).replace( /\{x\}/gi, item.xLabel );
									
									}
								};
							}
						}
						
						
						// merge custom options into the current chart options
						if ( 'undefined' !== typeof rrjChartOptions ) {
							$.extend( true, C.d.options, rrjChartOptions[C.id] );
						}
						
						/**
						 *  axex prefix and suffix
						 */
						if ( C.d.options.yAxisFormat ) {
							
							if ( 'function' == typeof C.d.options.scales.yAxes[0].ticks.callback ) {
								(function( _data ){
									var fn = _data.options.scales.yAxes[0].ticks.callback;
									_data.options.scales.yAxes[0].ticks.callback = function( t, e, n ) {
										var prefix = _data.options.yAxisFormat.prefix ? _data.options.yAxisFormat.prefix : '';
										var suffix = _data.options.yAxisFormat.suffix ? _data.options.yAxisFormat.suffix : '';
										var str = fn( t, e, n );
										return prefix + str + suffix;
									}
								})( C.d );
							} else {
								(function( _data ){
									_data.options.scales.yAxes[0].ticks.callback = function( t, e, n ) {
										var prefix = _data.options.yAxisFormat.prefix ? _data.options.yAxisFormat.prefix : '';
										var suffix = _data.options.yAxisFormat.suffix ? _data.options.yAxisFormat.suffix : '';
										return prefix + t + suffix;
									}
								})( C.d );
							}
						}
						
						if ( C.d.options.xAxisFormat ) {
							
							if ( 'function' == typeof C.d.options.scales.xAxes[0].ticks.callback ) {
								(function( _data ){
									var fn = _data.options.scales.xAxes[0].ticks.callback;
									_data.options.scales.xAxes[0].ticks.callback = function( t, e, n ) {
										var prefix = _data.options.xAxisFormat.prefix ? _data.options.xAxisFormat.prefix : '';
										var suffix = _data.options.xAxisFormat.suffix ? _data.options.xAxisFormat.suffix : '';
										var str = fn( t, e, n );
										return prefix + str + suffix;
									}
								})( C.d );
							} else {
								(function( _data ){
									_data.options.scales.xAxes[0].ticks.callback = function( t, e, n ) {
										var prefix = _data.options.xAxisFormat.prefix ? _data.options.xAxisFormat.prefix : '';
										var suffix = _data.options.xAxisFormat.suffix ? _data.options.xAxisFormat.suffix : '';
										return prefix + t + suffix;
									}
								})( C.d );
							}
						}
						
						if ( C.d.options.axisFormat ) {
							if ( 'function' == typeof C.d.options.scale.ticks.callback ) {
								(function( _data ){
									var fn = _data.options.scale.ticks.callback;
									_data.options.scale.ticks.callback = function( t, e, n ) {
										var prefix = _data.options.axisFormat.prefix ? _data.options.axisFormat.prefix : '';
										var suffix = _data.options.axisFormat.suffix ? _data.options.axisFormat.suffix : '';
										var str = fn( t, e, n );
										return prefix + str + suffix;
									}
								})( C.d );
							} else {
								(function( _data ){
									_data.options.scale.ticks.callback = function( t, e, n ) {
										var prefix = _data.options.axisFormat.prefix ? _data.options.axisFormat.prefix : '';
										var suffix = _data.options.axisFormat.suffix ? _data.options.axisFormat.suffix : '';
										return prefix + t + suffix;
									}
								})( C.d );
							}
						}
						
						/**
						 * thousand separator 
						 */						
						if ( '' != rrjChartPluginOptions['t-separator'] && !C.d.options.noTsep ) {
							var sep = rrjChartPluginOptions['t-separator'];
							
							// tooltips
							if ( 'function' == typeof C.d.options.tooltips.callbacks.label ) {
								(function( _data ){
									var tlFn = _data.options.tooltips.callbacks.label;
									_data.options.tooltips.callbacks.label = function( item, data ) {
										var result = tlFn( item, data );
										if ( 'bubble' == _data.type ) {
											return result.map(function(s){
												return s.replace( /\B(?=(\d{3})+(?!\d))/g, sep );
											});
										} else {
											result = result.replace( /\B(?=(\d{3})+(?!\d))/g, sep );
										}
										return result;
									}
								})( C.d );
							}
							
							if ( 'horizontalBar' == C.d.type ) {
								
								if ( 'function' == typeof C.d.options.scales.xAxes[0].ticks.callback ) {
									var fn = C.d.options.scales.xAxes[0].ticks.callback;
									C.d.options.scales.xAxes[0].ticks.callback = function( t, e, n ) {
										var result = fn( t, e, n );
										return result.toString().replace( /\B(?=(\d{3})+(?!\d))/g, sep );
									}
								} else {
									C.d.options.scales.xAxes[0].ticks.callback = axisThickTSep;
								}
								
							} else if ( 'polarArea' == C.d.type ||  'radar' == C.d.type ) {
								// Single scale
								if ( 'function' == typeof C.d.options.scale.ticks.callback ) {
									var fn = C.d.options.scale.ticks.callback;
									C.d.options.scale.ticks.callback = function( t, e, n ) {
										var result = fn( t, e, n );
										return result.toString().replace( /\B(?=(\d{3})+(?!\d))/g, sep );
									}
								} else {
									C.d.options.scale.ticks.callback = axisThickTSep;
								}
								
							} else if ( 'pie' == C.d.type ) {
								// no axis, nothing to do
								
							} else if ( 'bubble' == C.d.type ) {
								// double axes
								if ( 'function' == typeof C.d.options.scales.xAxes[0].ticks.callback ) {
									var fn = C.d.options.scales.xAxes[0].ticks.callback;
									C.d.options.scales.xAxes[0].ticks.callback = function( t, e, n ) {
										var result = fn( t, e, n );
										return result.toString().replace( /\B(?=(\d{3})+(?!\d))/g, sep );
									}
								} else {
									C.d.options.scales.xAxes[0].ticks.callback = axisThickTSep;
								}
								
								if ( 'function' == typeof C.d.options.scales.yAxes[0].ticks.callback ) {
									var fn = C.d.options.scales.yAxes[0].ticks.callback;
									C.d.options.scales.yAxes[0].ticks.callback = function( t, e, n ) {
										var result = fn( t, e, n );
										return result.toString().replace( /\B(?=(\d{3})+(?!\d))/g, sep );
									}
								} else {
									C.d.options.scales.yAxes[0].ticks.callback = axisThickTSep;
								}
								
							} else if ( 'bar' == C.d.type || 'line' == C.d.type ) {
								// Y axis only to convert
								if ( 'function' == typeof C.d.options.scales.yAxes[0].ticks.callback ) {
									var fn = C.d.options.scales.yAxes[0].ticks.callback;
									C.d.options.scales.yAxes[0].ticks.callback = function( t, e, n ) {
										var result = fn( t, e, n );
										return result.toString().replace( /\B(?=(\d{3})+(?!\d))/g, sep );
									}
								} else {
									C.d.options.scales.yAxes[0].ticks.callback = axisThickTSep;
								}
								
							}
							
						}
						
						// remove the preloader image
						C.c.siblings( '.rrj-preload-wrap' ).css( 'display', 'none' );
						
						// then construct the chart
						new rrjChart( C.c, C.d );
						C.s = true;
					}
				
				}
				
				
				
				
				
			}
		}
	}
	
	$( window ).on( 'scroll', function(){maybeDrawChart()} );
	
	$( document ).on( 'rrjDelayedChart', function(ev, id, data){
		charts[id]['d'] = data;
		maybeDrawChart();
	} )
	
	// on DOM loaded
	$(function(){
		$( '.rrj-chart' ).each(function(){
			var $el = $( this );
			var dataString = $el.find( '.chart-data' ).html();
			var data = false;
			var tooltips = false;
			var hasTooltipsFormats = $el.find( '.tooltips-data' ).length;
			try {
				data = JSON.parse( dataString );
				if ( hasTooltipsFormats ) {
					tooltips = JSON.parse( $el.find( '.tooltips-data' ).html() );
				}
			} catch( ex ) {}
			if ( data ) {
				var id = $el.find( '.chart-data' ).attr( 'data-id' );
				var $canvas = $el.find( 'canvas' );
				if ( 'undefined' != typeof rrjChartData && 'function' == typeof rrjChartData[id] ) {
					data = rrjChartData[id].call({id:id,data:data,$canvas:$canvas},$);
				}
				charts[id] = {
					e: $el,
					d: data,
					c: $canvas,
					t: tooltips,
					s: false,
					id: id,
				};
			}
		});
		maybeDrawChart();
	})
	
})(window.jQuery)