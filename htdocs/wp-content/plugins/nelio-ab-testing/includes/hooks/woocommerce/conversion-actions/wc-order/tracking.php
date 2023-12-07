<?php

namespace Nelio_AB_Testing\WooCommerce\Conversion_Action_Library\Order_Completed;

defined( 'ABSPATH' ) || exit;

use WC_Order;

use function add_action;
use function nab_track_conversion;
use function wc_get_order;

use function Nelio_AB_Testing\WooCommerce\Helpers\Product_Selection\do_products_match;

function add_hooks_for_tracking( $action, $experiment_id, $goal_index, $goal ) {

	$action = modernize( $action );

	add_action(
		'woocommerce_checkout_order_processed',
		function( $order_id ) {
			$experiments = nab_get_experiments_with_page_view_from_request();
			if ( empty( $experiments ) ) {
				return;
			}//end if
			update_post_meta( $order_id, '_nab_experiments_with_page_view', $experiments );

			$unique_ids = nab_get_unique_views_from_request();
			if ( ! empty( $unique_ids ) ) {
				update_post_meta( $order_id, '_nab_unique_ids', $unique_ids );
			}//end if
		}
	);

	add_action(
		'woocommerce_order_status_changed',
		function( $order_id, $old_status, $new_status ) use ( $action, $experiment_id, $goal_index, $goal ) {
			// If it's a revision or an autosave, do nothing.
			if ( wp_is_post_revision( $order_id ) || wp_is_post_autosave( $order_id ) ) {
				return;
			}//end if

			if ( $old_status === $new_status ) {
				return;
			}//end if

			$synched_goals = get_post_meta( $order_id, '_nab_synched_goals', true );
			$synched_goals = ! empty( $synched_goals ) ? $synched_goals : array();
			if ( in_array( "{$experiment_id}:{$goal_index}", $synched_goals, true ) ) {
				return;
			}//end if

			$expected_statuses = get_expected_statuses( $goal );
			if ( ! in_array( $new_status, $expected_statuses, true ) ) {
				return;
			}//end if

			$experiments = get_post_meta( $order_id, '_nab_experiments_with_page_view', true );
			if ( empty( $experiments ) || ! isset( $experiments[ $experiment_id ] ) ) {
				return;
			}//end if

			if ( function_exists( 'wc_get_order' ) ) {
				$order = wc_get_order( $order_id );
			} elseif ( class_exists( 'WC_Order' ) ) {
				$order = new WC_Order( $order_id );
			} else {
				return;
			}//end if

			$product_ids = get_product_ids( $order );
			if ( ! do_products_match( $action['value'], $product_ids ) ) {
				return;
			}//end if

			$value       = get_conversion_value( $order, $goal );
			$alternative = $experiments[ $experiment_id ];
			$options     = array( 'value' => $value );

			$unique_ids = get_post_meta( $order_id, '_nab_unique_ids', true );
			if ( isset( $unique_ids[ $experiment_id ] ) ) {
				$options['unique_id'] = $unique_ids[ $experiment_id ];
			}//end if

			nab_track_conversion( $experiment_id, $goal_index, $alternative, $options );
			array_push( $synched_goals, "{$experiment_id}:{$goal_index}" );
			update_post_meta( $order_id, '_nab_synched_goals', $synched_goals );
		},
		10,
		3
	);

}//end add_hooks_for_tracking()
add_action( 'nab_nab/wc-order_add_hooks_for_tracking', __NAMESPACE__ . '\add_hooks_for_tracking', 10, 4 );

function modernize( $action ) {
	if ( isset( $action['type'] ) && 'product-selection' === $action['type'] && ! isset( $action['productId'] ) ) {
		return $action;
	}//end if

	$any = ! empty( $action['anyProduct'] );
	if ( $any ) {
		return array(
			'type'  => 'product-selection',
			'value' => array( 'type' => 'all-products' ),
		);
	}//end if

	$pid = isset( $action['productId'] ) ? $action['productId'] : 0;
	return array(
		'type'  => 'product-selection',
		'value' => array(
			'type'  => 'some-products',
			'value' => array(
				'type'       => 'product-ids',
				'mode'       => 'and',
				'productIds' => ! empty( $pid ) ? array( $pid ) : array(),
			),
		),
	);
}//end modernize()

function get_conversion_value( $order, $goal ) {
	$attrs = isset( $goal['attributes'] ) ? $goal['attributes'] : array();
	if ( empty( $attrs['useOrderRevenue'] ) ) {
		return 0;
	}//end if

	/**
	 * Filters which products in an order contribute to the conversion revenue.
	 *
	 * In WooCommerce order conversion actions, when there’s a new order
	 * containing tracked produts, this filter specifies whether it should
	 * track the order total or only the value of the tracked products.
	 *
	 * @param boolean $track_order_total Default: `false`.
	 *
	 * @since 5.4.0
	 */
	if ( apply_filters( 'nab_track_order_total', false ) ) {
		return 0 + $order->get_total();
	}//end if

	$actions         = get_wc_order_actions( $goal );
	$is_tracked_item = function( $item ) use ( &$actions ) {
		$product_id = absint( $item->get_product_id() );
		return nab_some(
			function( $action ) use ( $product_id ) {
				return do_products_match( $action['value'], $product_id );
			},
			$actions
		);
	};

	$items = array_filter( $order->get_items(), $is_tracked_item );
	$items = array_values( $items );

	return array_reduce(
		$items,
		function( $carry, $item ) {
			return $carry + $item->get_total();
		},
		0
	);
}//end get_conversion_value()

function get_product_ids( $order ) {
	$product_ids = array_map(
		function( $item ) {
			return absint( $item->get_product_id() );
		},
		$order->get_items()
	);
	return array_values( array_unique( array_filter( $product_ids ) ) );
}//end get_product_ids()

function get_wc_order_actions( $goal ) {

	$is_wc_order = function( $action ) {
		return 'nab/wc-order' === $action['type'];
	};

	$add_attributes = function( $action ) {
		$action['attributes'] = isset( $action['attributes'] )
			? $action['attributes']
			: array();
		return $action;
	};

	$actions = isset( $goal['conversionActions'] ) ? $goal['conversionActions'] : array();
	$actions = array_filter( $actions, $is_wc_order );
	$actions = array_map( $add_attributes, $actions );
	$actions = wp_list_pluck( $actions, 'attributes' );
	$actions = array_values( array_filter( $actions ) );
	$actions = array_map( __NAMESPACE__ . '\modernize', $actions );
	return array_values( array_filter( $actions ) );
}//end get_wc_order_actions()

function get_expected_statuses( $goal ) {
	$attrs  = isset( $goal['attributes'] ) ? $goal['attributes'] : array();
	$status = isset( $attrs['orderStatusForConversion'] ) ? $attrs['orderStatusForConversion'] : 'wc-completed';
	$status = str_replace( 'wc-', '', $status );

	/**
	 * Returns the statuses that might trigger a conversion when there’s a WooCommerce order.
	 * Don’t include the `wc-` prefix in status names.
	 *
	 * @param array|string $statuses the status (or statuses) that might trigger a conversion.
	 *
	 * @since 5.0.0
	 */
	$expected_statuses = apply_filters( 'nab_order_status_for_conversions', $status );
	if ( ! is_array( $expected_statuses ) ) {
		$expected_statuses = array( $expected_statuses );
	}//end if

	return $expected_statuses;
}//end get_expected_statuses()
