<?php
if ( class_exists( 'rrj_colors', false ) ) return;

class rrj_colors
{
	/**
	 * Instance of this class.
	 */
	private static $instance = null;

	private function __construct() {

	}

	/**
	 *  reduce the opacity
	 */
	public function dilute( $color, $a = 0.5, $array = false ) {
		if ( !is_numeric( $a ) ) {
			throw new Exception( 'invalid alpha channel factor' );
		}
		if ( 0 > $a ) $a = 0;
		if ( 1 < $a ) $a = 1;
		$c = $this->get_rgba( $color );
		$d = array(
			$c[0],
			$c[1],
			$c[2],
			$c[3] * $a,
		);
		return ( $array )? $d : $this->format_rgba( $d );
	}
	
	/**
	 *  get the valid CSS rgba color string
	 */
	public function format_rgba( $color ) {
		$c = $this->get_rgba( $color );
		return 'rgba(' . intval( $c[0] ) . ',' . intval( $c[1] ) . ',' . intval( $c[2] ) . ',' . $c[3] . ')';
	}
	
	/**
	 *  get rgb array from HEX, rgba or rgb array
	 */
	public function get_rgb( $color ) {
		$color = $this->get_rgba( $color );
		return array_slice( $color, 0, 3 );
	}
	
	/**
	 *  get rgba array from HEX, rgba or rgb array
	 */
	public function get_rgba( $color ) {
		if ( is_string( $color ) ) {
			$color = trim( strtolower( $color ) );
			if ( false !== strpos( $color, '#' ) ) {
				// hex color
				return array_merge( $this->hex_to_rgb( $color ), array( 1 ) );
			}
			if ( false !== strpos( $color, 'rgba' ) ) {
				$color = str_replace( array( 'rgba', '(', ')', ' ' ), '', $color );
				$color = explode( ',', $color );
				if ( 4 > count( $color ) ) $color[] = 1;
				return array(
					floatval( $color[0] ),
					floatval( $color[1] ),
					floatval( $color[2] ),
					floatval( $color[3] ),
				);
			}
			if ( false !== strpos( $color, 'rgb' ) ) {
				$color = str_replace( array( 'rgb', '(', ')', ' ' ), '', $color );
				$color = explode( ',', $color );
				if ( 4 > count( $color ) ) $color[] = 1;
				return array(
					floatval( $color[0] ),
					floatval( $color[1] ),
					floatval( $color[2] ),
					floatval( $color[3] ),
				);
			}
			throw new Exception( 'invalid color string' );
		} elseif ( is_array( $color ) ) {
			$rgba = array(
				floatval( $color[0] ),
				floatval( $color[1] ),
				floatval( $color[2] ),
			);
			$rgba[] = isset( $color[3] )? $color[3] : 1;
			return $rgba;
		} else {
			throw new Exception( 'invalid color format' );
		}
	}
	
	/**
	 *  convert HEX colors to rbg array
	 *
	 *  @param [string] $hex, hexadecimal color (3 or 6 characters)
	 *  @return [array] $rbg, r g and b component of the color
	 */
	public function hex_to_rgb( $hex ) {
		$hex = trim( str_replace( '#', '', $hex ) );

		if( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ).substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ).substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ).substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = array( $r, $g, $b );

		return $rgb;
	}

	/**
	 *  Combine HEX color and apha channel (opacity) to get an rgba string
	 */
	public function hex_to_rgba( $hex, $a = 1 ) {
		$rgb = $this->get_rgb( $hex );
		return 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $a . ')';
	}

	/**
	 *  return color in the given format
	 *
	 *  @param [mixed] $color
	 *  @param [string] $format
	 */
	public function format( $color, $format ) {
		switch ( $format ) {
			case 'rgb':
				$color = $this->get_rgb( $color );
				return 'rgb(' . $color[0] . ',' . $color[1] . ',' . $color[2] . ')';
				break;
			case 'hex':
				$color = $this->get_rgb( $color );
				$hex_arr = array(
					( 1 == strlen( dechex( $color[0] ) ) )? '0' . dechex( $color[0] ) : dechex( $color[0] ),
					( 1 == strlen( dechex( $color[1] ) ) )? '0' . dechex( $color[1] ) : dechex( $color[1] ),
					( 1 == strlen( dechex( $color[2] ) ) )? '0' . dechex( $color[2] ) : dechex( $color[2] ),
				);
				return '#' . implode( '', $hex_arr );
				break;
			case 'rgba':
				return $this->format_rgba( $color );
				break;
			default: // array
				return $this->get_rgba( $color );
		}
	}

	/**
	 *  lighten color by a given amount
	 */
	public function lighten( $color, $amount = 15, $format = 'array' ) {
		$rgba = $this->get_rgba( $color );
		$rgb = $this->get_rgb( $rgba );
		$light = array(
			min( 255, ( ( $amount / 100 ) * 255 ) + $rgb[0] ),
			min( 255, ( ( $amount / 100 ) * 255 ) + $rgb[1] ),
			min( 255, ( ( $amount / 100 ) * 255 ) + $rgb[2] ),
		);
		$light = array_merge( $light, array( $rgba[3] ) );
		return $this->format( $light, $format );
	}

	/**
	 *  darken color by a given amount
	 */
	public function darken( $color, $amount = 15, $format = 'array' ) {
		$rgba = $this->get_rgba( $color );
		$rgb = $this->get_rgb( $rgba );
		$dark = array(
			max( 0, ( ( 100 - $amount ) / 100 ) * $rgb[0] ),
			max( 0, ( ( 100 - $amount ) / 100 ) * $rgb[1] ),
			max( 0, ( ( 100 - $amount ) / 100 ) * $rgb[2] ),
		);
		$dark = array_merge( $dark, array( $rgba[3] ) );
		return $this->format( $dark, $format );
	}

	/**
	 *  reverse color
	 */
	public function reverse( $color, $format = 'array' ) {
		$rgba = $this->get_rgba( $color );
		$rgb = $this->get_rgb( $rgba );
		$rev = array(
			255 - $rgb[0],
			255 - $rgb[1],
			255 - $rgb[2],
		);
		$rev = array_merge( $rev, array( $rgba[3] ) );
		return $this->format( $rev, $format );
	}

	/**
	 *  shade color by a given amount (darken for light color, lighten dark color)
	 */
	public function shade( $color, $amount = 15, $format = 'array' ) {
		$rgba = $this->get_rgba( $color );
		$rgb = $this->get_rgb( $rgba );
		$is_dark = $this->is_dark( $rgb );
		if ( $is_dark ) {
			return $this->lighten( $rgba, $amount, $format );
		} else {
			return $this->darken( $rgba, $amount, $format );
		}
	}

	/**
	 *  accentuate color (lighten light color, darken dark)
	 */
	public function accent( $color, $amount = 15, $format = 'array' ) {
		$rgba = $this->get_rgba( $color );
		$rgb = $this->get_rgb( $rgba );
		$is_dark = $this->is_dark( $rgb );
		if ( $is_dark ) {
			return $this->darken( $rgba, $amount, $format );
		} else {
			return $this->lighten( $rgba, $amount, $format );
		}
	}

	/**
	 *  rgb to gray scale
	 */
	public function grayscale( $color, $format = 'array'  ) {
		$rgba = $this->get_rgba( $color );
		$rgb = $this->get_rgb( $rgba );
		$av = ( $rgb[0] * 21 + $rgb[1] * 72 + $rgb[2] * 7 ) / 100;
		return $this->format( array( $av, $av, $av, $rgba[3] ), $format );
	}

	/**
	 *  check if is dark color
	 *
	 *  @return [bool]
	 */
	public function is_dark( $color ) {
		$rgba = $this->get_rgba( $color );
		$rgb = $this->get_rgb( $rgba );
		return ( ( $rgb[0] * 33 + $rgb[1] * 50 + $rgb[2] * 16 ) / 25500 ) < 0.5 ;
	}

	/**
	 * Return the unique instance of this class
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}