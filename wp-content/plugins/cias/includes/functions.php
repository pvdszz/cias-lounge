<?php
defined('ABSPATH') || exit;

function cias_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'cias_add_woocommerce_support' );

add_action('admin_head', 'cias_admin_style');

add_action('admin_head', 'cias_admin_style');

function cias_admin_style() {
  echo '<style>
    .order_data_column {
      width:100% !important;
    } 
  </style>';
}
// set menu logged
function cias_nav_menu_args($args = ''){
	if (is_user_logged_in()) {
		$args['menu'] = 'logged-in'; // logged menu
	} else {
		$args['menu'] = 'Main-menu'; // normal menu
	}
	return $args;
}
add_filter('wp_nav_menu_args', 'cias_nav_menu_args');


// Remove added to cart notice


// add widgets
function cias_widgets(){
	register_sidebar(
		array(
			'name' => __('Top header', 'theretailer-child'),
			'id' => 'top_header',
			'description' => __('Top header', 'theretailer-child'),
			'before_widget' => '<div cl>',
			'after_widget' => "</div>",
		)
	);
	register_sidebar(
		array(
			'name' => __('Sencond footer', 'theretailer-child'),
			'id' => 'second-footer',
			'description' => __('footer', 'theretailer-child'),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer 1', 'theretailer-child'),
			'id' => 'footer1',
			'description' => __(' footer', 'theretailer-child'),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer 2', 'theretailer-child'),
			'id' => 'footer2',
			'description' => __('footer', 'theretailer-child'),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer 3', 'theretailer-child'),
			'id' => 'footer3',
			'description' => __('footer', 'theretailer-child'),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer 4', 'theretailer-child'),
			'id' => 'footer4',
			'description' => __('footer', 'theretailer-child'),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer 5', 'theretailer-child'),
			'id' => 'footer5',
			'description' => __('footer', 'theretailer-child'),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __('advertisement', 'theretailer-child'),
			'id' => 'advertisement',
			'description' => __('advertisement', 'theretailer-child'),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
}
add_action('widgets_init', 'cias_widgets');

// Remove product existed on cart

add_filter('woocommerce_add_to_cart_validation', 'cias_remove_cart_item_before_add_to_cart', 20, 3);
function cias_remove_cart_item_before_add_to_cart($passed, $product_id, $quantity){
	if (!WC()->cart->is_empty())
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			if ($cart_item['product_id'] == $product_id) {
				WC()->cart->remove_cart_item($cart_item_key);
			}
		}
	return $passed;
}
// booking tab
/**
 * Add a custom product tab.
 */
function cias_custom_product_tabs($tabs){
	$tabs['booking'] = array(
		'label'		=> __('Booking', 'woocommerce'),
		'target'	=> 'booking_options',
		'class'		=> array('booking'),
	);
	return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'cias_custom_product_tabs'); // WC 2.5 and below\
/**
 * Contents of the gift card options product tab.
 */
function cias_booking_options_product_tab_content(){
	global $post;?>
	<div id='booking_options' class='panel woocommerce_options_panel'>
		<div class='options_group'>
			<?php
				woocommerce_wp_text_input(array(
					'id'				=> 'price_for_adult',
					'label'				=> __('Giá cho một người lớn:', 'woocommerce'),
					'desc_tip'			=> 'true',
					'type' 				=> 'number',
					'custom_attributes'	=> array(
						'min'	=> '1',
						'step'	=> '1',
					),
				));
				woocommerce_wp_text_input(array(
					'id'				=> 'price_for_child',
					'label'				=> __('Giá cho một trẻ em:', 'woocommerce'),
					'desc_tip'			=> 'true',
					'type' 				=> 'number',
					'custom_attributes'	=> array(
						'min'	=> '1',
						'step'	=> '1',
					),
				));
			?>
		</div>

	</div><?php
}
add_filter('woocommerce_product_data_panels', 'cias_booking_options_product_tab_content'); // WC 2.6 and up
/**
 * Save the custom fields.
 */
function save_booking_options_fields($post_id){
	$allow_personal_message = isset($_POST['_allow_personal_message']) ? 'yes' : 'no';
	update_post_meta($post_id, '_allow_personal_message', $allow_personal_message);

	if (isset($_POST['price_for_adult'])) :
		update_post_meta($post_id, 'price_for_adult', absint($_POST['price_for_adult']));
	endif;
	if (isset($_POST['price_for_child'])) :
		update_post_meta($post_id, 'price_for_child', absint($_POST['price_for_child']));
	endif;
}
add_action('woocommerce_process_product_meta_simple', 'save_booking_options_fields');
add_action('woocommerce_process_product_meta_variable', 'save_booking_options_fields');




/**
 * Adds custom field for Product
 * @return [type] [description]
 */
add_action('woocommerce_before_add_to_cart_button', 'cias_add_custom_fields');
function cias_add_custom_fields(){
	global $product, $post;
	ob_start();?>
	<div class="cias-custom-fields">
		<li>
			<?php $adult_price = get_post_meta($post->ID, 'price_for_adult', true); ?>
			<label for="cias_adult">Người lớn: <br>
				<?php echo number_format($adult_price, 0, '', ','); ?> VNĐ
			</label>
			<div class="wrap-quantity-num">
				<input id="quantity-num-adult" class="quantity-num-adult poiter-events" type="number" name="cias_adult" min=1 value="1">
			</div>
		</li>
		<li>
			<?php $kids_price = get_post_meta($post->ID, 'price_for_child', true); ?>
			<label for="cias_kids">Trẻ em: <br>
				<?php echo number_format($kids_price, 0, '', ','); ?> VNĐ
			</label>
			<div class="wrap-quantity-num">
				<input id="quantity-num-kids" class="quantity-num-kids poiter-events" type="number" name="cias_kids" min=0
					value="0">
			</div>
		</li>
		<li>
			<input id="coupon" class="coupon" type="hidden" name="cias_coupon" min=0
				value="Code will be sent to you when your order completed.Thank you so much!">
		</li>
	</div>
	<div class="clear"></div><?php

	$content = ob_get_contents();
	ob_end_flush();
	return $content;
}

add_filter('woocommerce_add_cart_item_data', 'cias_add_item_data', 10, 3);
/**
 * Add custom data to Cart
 */
function cias_add_item_data($cart_item_data, $product_id, $variation_id){
	if (isset($_REQUEST['cias_adult'])) {
		$cart_item_data['cias_adult'] = sanitize_text_field($_REQUEST['cias_adult']);
	}

	if (isset($_REQUEST['cias_kids'])) {
		$cart_item_data['cias_kids'] = sanitize_text_field($_REQUEST['cias_kids']);
	}
	if (isset($_REQUEST['cias_coupon'])) {
		$cart_item_data['cias_coupon'] = sanitize_text_field($_REQUEST['cias_coupon']);
	}
	return $cart_item_data;
}
add_filter('woocommerce_get_item_data', 'cias_add_item_meta', 10, 2);

/**
 * Display information as Meta on Cart page
 * @param  [type] $item_data [description]
 * @param  [type] $cart_item [description]
 * @return [type]            [description]
 */

function cias_add_item_meta($item_data, $cart_item){
	global $custom_details;
	if (array_key_exists('cias_adult', $cart_item)) {
		$custom_details = $cart_item['cias_adult'];

		$item_data[] = array(
			'key'   => 'Người lớn',
			'value' => $custom_details
		);
	}
	if (array_key_exists('cias_kids', $cart_item)) {
		$custom_details = $cart_item['cias_kids'];

		$item_data[] = array(
			'key'   => 'Trẻ em',
			'value' => $custom_details
		);
	}
	if (array_key_exists('cias_coupon', $cart_item)) {
		$custom_details = $cart_item['cias_coupon'];
		$item_data[] = array(
			'key'   => 'code',
			'value' => $custom_details,
		);
	}

	return $item_data;
}

add_action('woocommerce_checkout_create_order_line_item', 'cias_add_custom_order_line_item_meta', 10, 4);
// add quantity adult and child to order line
function cias_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order){

	if (array_key_exists('cias_adult', $values)) {
		$item->add_meta_data('Người lớn', $values['cias_adult']);
	}
	if (array_key_exists('cias_kids', $values)) {
		$item->add_meta_data('Trẻ em', $values['cias_kids']);
	}
}

add_action('woocommerce_before_calculate_totals', 'cias_price', 20, 1);
function cias_price($cart){
	// This is necessary for WC 3.0+
	if (is_admin() && !defined('DOING_AJAX'))
		return;
	// Avoiding hook repetition (when using price calculations for example)
	if (did_action('woocommerce_before_calculate_totals') >= 2)
		return;
	// Loop through cart items
	foreach ($cart->get_cart() as $item) {
		$adult = $item['cias_adult'];
		$adult = get_post_meta($item['product_id'], 'price_for_adult', true) * $item['cias_adult'];
		$child = get_post_meta($item['product_id'], 'price_for_child', true) * $item['cias_kids'];
		$price = $adult + $child;
		$item['data']->set_price($price);
	}
}

		// Remove old product

		/**
		 * @snippet       Remove Cart Item Programmatically - WooCommerce
		 * @how-to        Get CustomizeWoo.com FREE
		 * @author        Rodolfo Melogli
		 * @compatible    WooCommerce 3.8
		 * @donate $9     https://businessbloomer.com/bloomer-armada/
		 */

add_action('template_redirect', 'cias_remove_product_from_cart_programmatically');

function cias_remove_product_from_cart_programmatically(){
	$product_id = 20;
	$product_cart_id = WC()->cart->generate_cart_id($product_id);
	$cart_item_key = WC()->cart->find_product_in_cart($product_cart_id);
	if ($cart_item_key) WC()->cart->remove_cart_item($cart_item_key);
}

// Remove Product Prices



// Check order status and generate code
function cias_order_completed($order_id){
	global $wpdb;
	$table = $wpdb->prefix . 'orderExtra';
	$results = $wpdb->get_results("SELECT * FROM $table");
	$order = wc_get_order($order_id);
	// Get and Loop Over Order Items
	foreach ($order->get_items() as $item_id => $item) {
		$allmeta = $item->get_meta_data();
		$adultCount = $allmeta[0]->__get('value');
		$childCount = $allmeta[1]->__get('value');
		$product_id = $item->get_product_id();
			
		if (!empty($results)) {
			foreach ($results as $row) {
				$id = $row->orderExID;
			}
		}
		if ($id == $order_id) {
			global $wpdb;
			$table = $wpdb->prefix . 'orderExtra';
			$data = array(
				'deleted' => "1",
			);
			$where = ['orderExId' => $order_id];
			$wpdb->update($table, $data, $where, $format = NULL);
		} else {

			$anum_code = 1;
			while ($anum_code <= $adultCount) {
				if($product_id == 20){
					$acoupon_code = 'AA' . $order_id . '-';
				}else if($product_id == 46){
					$acoupon_code = 'AB' . $order_id . '-';
				}else{
					$acoupon_code = 'AC' . $order_id . '-';
				}
				
				$length        = 6;
				$charset       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$count         = strlen($charset);

				while ($length--) {
					$acoupon_code .= $charset[mt_rand(0, $count - 1)];
				}
				$date = date('Y-m-d', strtotime("+30 days"));
				$data = array(
					'orderExID' => $order_id,
					'code' 		=> $acoupon_code,
					'expiredDate' => $date,
					'deleted' => "1",
					'object'  => "0",
					'product_id' =>$product_id,
				);
				$wpdb->insert($table, $data, $format = NULL);
				$anum_code++;
			}
			$bnum_code = 1;
			while ($bnum_code <= $childCount) {
				
				if($product_id == 20){
					$bcoupon_code = 'BA' . $order_id . '-';
				}else if($product_id == 46){
					$bcoupon_code = 'BB' . $order_id . '-';
				}else{
					$bcoupon_code = 'BC' . $order_id . '-';
				}
				$length        = 6;
				$charset       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$count         = strlen($charset);

				while ($length--) {
					$bcoupon_code .= $charset[mt_rand(0, $count - 1)];
				}
				$date = date('Y-m-d', strtotime("+30 days"));
				$data = array(
					'orderExID' => $order_id,
					'code' 		=> $bcoupon_code,
					'expiredDate' => $date,
					'deleted' => "1",
					'object'  => "1",
					'product_id' =>$product_id,
				);
				$wpdb->insert($table, $data, $format = NULL);
				$bnum_code++;
			}
		}
	}
}
add_action('woocommerce_admin_order_data_after_billing_address', 'cias_checkout_field_display_admin_order_meta', 10, 1);

function cias_checkout_field_display_admin_order_meta($order){
	if (current_user_can('administrator')) {
		global $wpdb, $product;
		$order_id = $order->get_id();
		$table = $wpdb->prefix . 'orderExtra';
		$orderbycol = 'ID';
		$results = $wpdb->get_results("SELECT * FROM $table  order by $orderbycol");
		if (!empty($results)) {?>
			<h3 style="margin-bottom: 20px"> Chi tiết mã Voucher </h3>
			<table id="code-detail" style="width:100%; margin-bottom: 20px;">
				<style>
				#code-detail {
					border-spacing: 0;
				}
				#code-detail th {
					border: 1px solid #ddd;
				}
				#code-detail td {
					border: 1px solid #ddd;
				}
				</style>
				<thead>
					<tr>
						<th align="center">Mã</th>
						<th align="center">Ngày hết hạn</th>
						<th align="center">Trạng thái</th>
						<th align="center">Đối tượng</th>
						<th align="center">Loại sản phẩm</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($results as $row) {
						$id = $row->orderExID;
						$code = $row->code;
						$used = $row->used;
						$deleted = $row->deleted;
						$expired_date = $row->expiredDate;
						$product_id = $row->product_id;
						$product = wc_get_product( $product_id );// Get the WC_Product Object
						$product_name = $product->get_name();
						$object = $row->object;
					
						if ($id == $order_id && $used == 0 && $deleted == 1) {?>
							<tr>
								<td align="center">
									<p><?php echo $code; ?></p>
								</td>
								<td align="center">
									<p><?php echo $expired_date; ?></p>
								</td>
								<td align="center">
									<p>Khả dụng</p>
								</td>
								<td align="center">
									<p>
									<?php 
										if($object == 0){
											echo "Người lớn";
										} else if($object == 1){
											echo "Trẻ em";
										}
									?></p>
								</td>
								<td align="center">
									<?php
										echo $product_name;								
									?>
								</td>
							</tr><?php
						}
						if ($id == $order_id && $used == 1 && $deleted == 1) {?>
							<tr>
								<td align="center">
									<p><?php echo $code; ?></p>
								</td>
								<td align="center">
									<p><?php echo $expired_date; ?></p>
								</td>
								<td align="center">
									<p>Đã sử dụng</p>
								</td>
								<td align="center">
									<p>
									<?php 
										if($object == 0){
											echo "Người lớn";
										} else if($object == 1){
											echo "Trẻ em";
										}
									?></p>
								</td>
								<td align="center">
									<?php
										
										echo $product_name;								
									?>
								</td>
							</tr><?php
						}
						if ($id == $order_id && $deleted == 0) {
							echo "";
						}				
					}?>
				</tbody>
			</table><?php
		};
	}
}

function cias_order_pending($order_id){
	error_log("$order_id set to PENDING");
	global $wpdb;
	$table = $wpdb->prefix . 'orderExtra';
	$data = array(
		'deleted' => "0",
	);
	$where = ['orderExId' => $order_id];
	$wpdb->update($table, $data, $where, $format = NULL);
}
function cias_order_failed($order_id){
	error_log("$order_id set to FAILED");
	global $wpdb;
	$table = $wpdb->prefix . 'orderExtra';
	$data = array(
		'deleted' => "0",
	);
	$where = ['orderExId' => $order_id];
	$wpdb->update($table, $data, $where, $format = NULL);
}
function cias_order_hold($order_id){
	error_log("$order_id set to ON HOLD");
	global $wpdb;
	$table = $wpdb->prefix . 'orderExtra';
	$data = array(
		'deleted' => "0",
	);
	$where = ['orderExId' => $order_id];
	$wpdb->update($table, $data, $where, $format = NULL);
}
function cias_order_processing($order_id){
	global $wpdb;
	$table = $wpdb->prefix . 'orderExtra';
	$data = array(
		'deleted' => "0",
	);
	$where = ['orderExId' => $order_id];
	$wpdb->update($table, $data, $where, $format = NULL);
}

function cias_order_refunded($order_id){
	error_log("$order_id set to REFUNDED");
	global $wpdb;
	$table = $wpdb->prefix . 'orderExtra';
	$data = array(
		'deleted' => "0",
	);
	$where = ['orderExId' => $order_id];
	$wpdb->update($table, $data, $where, $format = NULL);
}
function cias_order_cancelled($order_id){
	global $wpdb;
	$table = $wpdb->prefix . 'orderExtra';
	$data = array(
		'deleted' => "0",
	);
	$where = ['orderExId' => $order_id];
	$wpdb->update($table, $data, $where, $format = NULL);
}

add_action('woocommerce_order_status_completed', 'cias_order_completed');
add_action('woocommerce_order_status_pending', 'cias_order_pending', 10, 1);
add_action('woocommerce_order_status_failed', 'cias_order_failed', 10, 1);
add_action('woocommerce_order_status_on-hold', 'cias_order_hold', 10, 1);
add_action('woocommerce_order_status_processing', 'cias_order_processing', 10, 1);
add_action('woocommerce_order_status_completed', 'cias_order_completed', 10, 1);
add_action('woocommerce_order_status_refunded', 'cias_order_refunded', 10, 1);
add_action('woocommerce_order_status_cancelled', 'cias_order_cancelled', 10, 1);


add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields){
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_address_1']);
	unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_postcode']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_state']);
	unset($fields['order']['order_comments']);
	unset($fields['account']['account_username']);
	unset($fields['account']['account_password']);
	unset($fields['account']['account_password-2']);
	return $fields;
}

// account

/**
 * Add a custom product data tab
 */
add_filter('woocommerce_product_tabs', 'cias_woo_new_product_tab');
function cias_woo_new_product_tab($tabs){
	// Adds the new tab
	$tabs['test_tab'] = array(
		'title' 	=> __('Tiện ích', 'woocommerce'),
		'priority' 	=> 1,
		'callback' 	=> 'cias_woo_new_product_tab_content'
	);
	return $tabs;
}

add_filter('woocommerce_product_tabs', 'cias_woo_rename_tabs', 98);
function cias_woo_rename_tabs($tabs){

	$tabs['description']['title'] = __('Thông tin dịch vụ');		// Rename the description tab

	return $tabs;
}
function cias_woo_new_product_tab_content(){
	// The new tab content
	if (have_rows('cac_tien_ich')) : ?>
		<ul class="cac_tien_ich">
			<?php while (have_rows('cac_tien_ich')) : the_row();?>
			<li>
				<img src="<? echo get_sub_field('img');?>" alt="">
				<p><?php echo get_sub_field('label'); ?></p>
			</li>
			<?php endwhile; ?>
		</ul>
	<?php endif;
}
add_filter('woocommerce_account_menu_items', 'custom_remove_downloads_my_account', 999);

function custom_remove_downloads_my_account($items){
	unset($items['downloads']);
	unset($items['dashboard']);
	return $items;
}





