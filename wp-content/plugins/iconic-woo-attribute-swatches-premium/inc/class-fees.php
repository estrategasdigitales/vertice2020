<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Fees
 *
 * This class is for attribute fees.
 *
 * @class          Iconic_WAS_Fees
 * @version        1.0.0
 * @category       Class
 * @author         Iconic
 */
class Iconic_WAS_Fees {
	/**
	 * DB version.
	 *
	 * @var string
	 */
	protected static $db_version = '1.0.0';

	/**
	 * DB name.
	 *
	 * @var string
	 */
	public static $db_name = 'iconic_was_fees';

	/**
	 * Install/update the DB table.
	 */
	public static function install() {
		if ( version_compare( get_site_option( 'iconic_was_db_version' ), self::$db_version, '>=' ) ) {
			return;
		}

		$table_name = self::get_table_name();

		$sql = "CREATE TABLE $table_name (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`product_id` bigint(20) DEFAULT NULL,
		`attribute` varchar(200) DEFAULT NULL,
		`fees` longtext,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		update_option( "iconic_was_db_version", self::$db_version );
	}

	/**
	 * Run actions/filters for this class.
	 */
	public static function run() {
		add_action( 'woocommerce_after_product_attribute_settings', array( __CLASS__, 'add_fees_meta_row' ), 10, 2 );
		add_action( 'woocommerce_update_product', array( __CLASS__, 'on_update_product' ), 10 );
		add_action( 'woocommerce_before_calculate_totals', array( __CLASS__, 'calculate_totals' ), 10 );
		add_action( 'woocommerce_before_variations_form', array( __CLASS__, 'output_fees_in_form' ), 10 );
		add_filter( 'woocommerce_variation_option_name', array( __CLASS__, 'variation_option_name' ), 10, 4 );
		add_filter( 'woocommerce_variable_price_html', array( __CLASS__, 'variable_price_html' ), 10, 2 );
		add_filter( 'woocommerce_show_variation_price', array( __CLASS__, 'show_variation_price' ), 10, 3 );
	}

	/**
	 * Add fees meta row.
	 *
	 * @param WC_Product_Attribute $attribute
	 * @param int                  $i
	 */
	public static function add_fees_meta_row( $attribute, $i ) {
		$attribute_data = self::get_attribute_data( $attribute );

		if ( ! $attribute->get_variation() ) {
			return;
		}
		?>
		<tr class="iconic-was-fees">
			<td colspan="4">
				<h4><?php _e( 'Fees', 'iconic-was' ); ?></h4>
				<table class="iconic-was-table widefat fixed striped">
					<thead>
					<th><?php _e( 'Value', 'iconic-was' ); ?></th>
					<th><?php _e( 'Fee', 'iconic-was' ); ?> (<?php echo get_woocommerce_currency_symbol(); ?>)</th>
					</thead>
					<tbody>
					<?php foreach ( $attribute_data['values'] as $slug => $value ) { ?>
						<tr>
							<td><?php echo $value['label']; ?></td>
							<td>
								<input name="iconic-was-fees[<?php echo esc_attr( $attribute_data['slug'] ); ?>][<?php echo esc_attr( $slug ); ?>]" class="short wc_input_price" type="number" min="0" onkeypress="return event.charCode >= 48" value="<?php echo esc_attr( $value['value'] ); ?>">
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</td>
		</tr>
		<?php
		return;
	}

	/**
	 * Get attribute data.
	 *
	 * @param WC_Product_Attribute $attribute
	 * @param int                  $product_id
	 *
	 * @return array
	 */
	public static function get_attribute_data( $attribute, $product_id = null ) {
		if ( ! $product_id ) {
			if ( isset( $_GET['post'] ) ) {
				$product_id = absint( $_GET['post'] );
			} elseif ( isset( $_POST['post_id'] ) ) {
				$product_id = absint( $_POST['post_id'] );
			}
		}

		$return = array(
			'slug'   => sanitize_title( $attribute->get_name() ),
			'values' => array(),
		);

		if ( ! $product_id ) {
			return $return;
		}

		$return['slugs']   = $attribute->get_slugs();
		$return['options'] = $attribute->get_options();

		foreach ( $return['options'] as $index => $option ) {
			$label                = $option;
			$attribute_value_slug = $return['slugs'][ $index ];

			if ( $attribute->get_taxonomy() ) {
				$term  = get_term_by( 'id', $option, $attribute->get_taxonomy() );
				$label = $term->name;
			}

			$fee = self::get_fees( $product_id, $return['slug'], $attribute_value_slug );

			$return['values'][ $attribute_value_slug ] = array(
				'label' => $label,
				'value' => $fee !== floatval( 0 ) ? $fee : '',
			);
		}

		return $return;
	}

	/**
	 * Update product.
	 *
	 * @param $product_id
	 */
	public static function on_update_product( $product_id ) {
		$posted_fees = filter_input( INPUT_POST, 'iconic-was-fees', FILTER_DEFAULT, FILTER_FORCE_ARRAY );

		if ( is_null( $posted_fees ) ) {
			$posted_data = filter_input( INPUT_POST, 'data' );

			if ( ! $posted_data ) {
				return;
			}

			parse_str( $posted_data, $data );

			$posted_fees = isset( $data['iconic-was-fees'] ) ? $data['iconic-was-fees'] : null;
		}

		if ( is_null( $posted_fees ) ) {
			return;
		}

		foreach ( $posted_fees as $attribute => $fees ) {
			self::set_fees( $product_id, $attribute, $fees );
		}
	}

	/**
	 * Set fees.
	 *
	 * @param int    $product_id
	 * @param string $attribute
	 * @param array  $fees
	 */
	public static function set_fees( $product_id, $attribute, $fees ) {
		global $wpdb;

		$fees       = array_filter( $fees );
		$table_name = self::get_table_name();

		$data = array(
			'product_id' => absint( $product_id ),
			'attribute'  => $attribute,
		);

		if ( empty( $fees ) ) {
			$wpdb->delete( $table_name, array(
				'product_id' => $data['product_id'],
				'attribute'  => $data['attribute'],
			) );

			return;
		}

		$data['fees'] = $fees;

		$format = array(
			'%d',
			'%s',
			'%s',
		);

		$current_fees = self::get_fees( $product_id, $attribute );

		if ( $current_fees ) {
			$data['id'] = $current_fees['id'];
			$format[]   = '%d';
		}

		$data['fees'] = serialize( $data['fees'] );

		$wpdb->replace(
			$table_name,
			$data,
			$format
		);
	}

	/**
	 * Get fees.
	 *
	 * Static response to reduce DB queries.
	 *
	 * @param int    $product_id
	 * @param string $attribute The attribute name.
	 * @param bool   $value     Return the fee for a specific attribute value.
	 *
	 * @return array|bool
	 */
	public static function get_fees( $product_id, $attribute, $value = false ) {
		if ( ! $product_id || ! $attribute ) {
			return false;
		}

		global $wpdb;

		static $fees = array();

		$attribute = str_replace( 'attribute_', '', $attribute );

		if ( ! isset( $fees[ $product_id ][ $attribute ] ) || ( isset( $_POST['action'] ) && $_POST['action'] === 'woocommerce_save_attributes' ) ) {
			$fees[ $product_id ] = empty( $fees[ $product_id ] ) ? array() : $fees[ $product_id ];
			$table_name          = self::get_table_name();

			$fees[ $product_id ][ $attribute ] = $wpdb->get_row( $wpdb->prepare(
				"SELECT * FROM $table_name WHERE product_id = %d AND attribute ='%s'",
				$product_id,
				$attribute
			), ARRAY_A );

			if ( ! $fees[ $product_id ][ $attribute ] ) {
				$fees[ $product_id ][ $attribute ] = false;

				return false;
			}

			$fees[ $product_id ][ $attribute ]['fees'] = maybe_unserialize( $fees[ $product_id ][ $attribute ]['fees'] );

			if ( is_array( $fees[ $product_id ][ $attribute ]['fees'] ) ) {
				$fees[ $product_id ][ $attribute ]['fees'] = array_map( 'floatval', $fees[ $product_id ][ $attribute ]['fees'] );
			}
		}

		if ( $value ) {
			return isset( $fees[ $product_id ][ $attribute ]['fees'][ $value ] ) ? $fees[ $product_id ][ $attribute ]['fees'][ $value ] : false;
		}

		return $fees[ $product_id ][ $attribute ];
	}

	/**
	 * Get table name.
	 *
	 * @return string
	 */
	public static function get_table_name() {
		global $wpdb;

		return $wpdb->prefix . self::$db_name;
	}

	/**
	 * Modify cart item prices.
	 *
	 * @param WC_Cart $cart
	 */
	public static function calculate_totals( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		// Avoiding hook repetition (when using price calculations for example)
		if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) {
			return;
		}

		foreach ( $cart->get_cart() as $key => $cart_item ) {
			if ( empty( $cart_item['variation'] ) || ! empty( $cart_item['iconic_was_fee'] ) ) {
				continue;
			}

			$base_price = floatval( $cart_item['data']->get_price() );

			foreach ( $cart_item['variation'] as $attribute => $attribute_value ) {
				if ( empty( $attribute_value ) ) {
					continue;
				}

				$attribute  = str_replace( 'attribute_', '', $attribute );
				$base_price += self::get_fees( $cart_item['product_id'], $attribute, $attribute_value );
			}

			$cart_item['data']->set_price( $base_price );
			$cart_item['iconic_was_fee'] = true;
		}
	}

	/**
	 * Add fee to product terms (variation dropdowns).
	 *
	 * @param array  $terms
	 * @param int    $product_id
	 * @param string $taxonomy
	 * @param array  $args
	 *
	 * @return array
	 */
	public static function get_product_terms( $terms, $product_id, $taxonomy, $args ) {
		if ( is_admin() || strpos( $taxonomy, 'pa_' ) === false ) {
			return $terms;
		}

		if ( empty( $terms ) ) {
			return $terms;
		}

		foreach ( $terms as $index => $term ) {
			$fee = self::get_fees( $product_id, $taxonomy, $term->slug );

			if ( ! $fee ) {
				continue;
			}

			$terms[ $index ]->name = self::add_fee_to_label( $term->name, $fee );
		}

		return $terms;
	}

	/**
	 * Add fee to swatch label (taxonomy).
	 *
	 * @param string       $term_name
	 * @param WP_Term|null $term
	 * @param string       $attribute_slug
	 * @param WC_Product   $product
	 *
	 * @return string
	 */
	public static function variation_option_name( $term_name, $term = null, $attribute_slug = null, $product = null ) {
		if ( empty( $product ) ) {
			global $product;
		}

		// Backwards compatibility check (as term, attribute_slug and product are all optional).
		if ( ( ! $product instanceof WC_Product ) ||
		     ( ! empty( $_POST['action'] ) && in_array( $_POST['action'], array(
				     'woocommerce_load_variations',
				     'woocommerce_add_variation'
			     ) ) ) ||
		     ( is_admin() && ! wp_doing_ajax() )
		) {
			return $term_name;
		}

		$product_id = $product->get_id();
		$term_slug  = is_a( $term, 'WP_Term' ) ? $term->slug : $term_name;
		$fee        = self::get_fees( $product_id, $attribute_slug, $term_slug );

		if ( ! $fee ) {
			return $term_name;
		}

		return self::add_fee_to_label( $term_name, $fee );
	}

	/**
	 * Add fee to label.
	 *
	 * @param string $label
	 * @param float  $fee
	 *
	 * @return string
	 */
	public static function add_fee_to_label( $label, $fee ) {
		$prefix = $fee > 0 ? '+' : '';

		return strip_tags( sprintf( '%s (%s%s)', $label, $prefix, wc_price( $fee ) ) );
	}

	/**
	 * Modify variable price.
	 *
	 * @param string              $price
	 * @param WC_Product_Variable $product
	 *
	 * @return string
	 */
	public static function variable_price_html( $price, $product ) {
		if ( ! self::has_fees( $product->get_id() ) ) {
			return $price;
		}

		$min_price = Iconic_WAS_Helpers::get_min_price( $product );

		if ( ! $min_price ) {
			return $price;
		}

		return apply_filters( 'iconic_was_price_from', sprintf( '%s: %s', __( 'From', 'iconic-was' ), wc_price( $min_price ) ), $product );
	}

	/**
	 * Does this product have fees associated to it?
	 *
	 * @param int $product_id
	 *
	 * @return bool
	 */
	public static function has_fees( $product_id ) {
		static $fees = array();

		if ( isset( $fees[ $product_id ] ) ) {
			return $fees[ $product_id ];
		}

		global $wpdb;

		$table_name = self::get_table_name();

		$results = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM $table_name WHERE product_id = %d",
			$product_id
		), ARRAY_A );

		if ( empty( $results ) || is_wp_error( $results ) ) {
			$fees[ $product_id ] = false;

			return $fees[ $product_id ];
		}

		foreach ( $results as $result ) {
			$result_fees = array_map( 'floatval', maybe_unserialize( $result['fees'] ) );
			$result_fees = array_filter( $result_fees );

			if ( empty( $result_fees ) ) {
				continue;
			}

			$fees[ $product_id ][ $result['attribute'] ] = $result_fees;
		}

		if ( ! isset( $fees[ $product_id ] ) ) {
			$fees[ $product_id ] = false;

			return $fees[ $product_id ];
		}

		return $fees[ $product_id ];
	}

	/**
	 * Output fees in form.
	 */
	public static function output_fees_in_form() {
		global $product;

		if ( ! $product || ! $product->is_type( 'variable' ) ) {
			return;
		}

		$fees = self::has_fees( $product->get_id() );

		if ( ! $fees ) {
			return;
		} ?>
		<script class="iconic-was-fees" type="application/json"><?php echo json_encode( $fees ); ?></script>
		<?php
	}

	/**
	 * Show variation price on product page.
	 *
	 * @param bool                 $show
	 * @param WC_Product_Variable  $product
	 * @param WC_Product_Variation $variation
	 *
	 * @return bool
	 */
	public static function show_variation_price( $show, $product, $variation ) {
		if ( ! self::has_fees( $product->get_id() ) ) {
			return $show;
		}

		return true;
	}
}