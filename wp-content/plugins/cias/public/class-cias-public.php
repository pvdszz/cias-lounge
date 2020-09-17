<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://cias.imus.vn
 * @since      1.0.0
 *
 * @package    Cias
 * @subpackage Cias/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cias
 * @subpackage Cias/public
 * @author     PVD <d@gmail.com>
 */
class Cias_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'wp_ajax_check_code', array($this, 'checking_handle'));
		add_action( 'wp_ajax_use_code', array($this, 'use_code_handle'));
	}
	public function use_code_handle(){
		$code = isset($_POST['code'])? $_POST['code']: '';
		$security = isset($_POST['security'])? $_POST['security']: '';
		$error = '';
		$code_info = null;

		global $wpdb, $order;
		$table_name = $wpdb->prefix . "orderExtra";
		if(wp_verify_nonce($security, 'security')){
			$table = $wpdb->prefix . 'orderExtra';
			$data = array(
				'used' => "1",
			);
			$where = ['code' => $code];
			$wpdb->update($table, $data, $where, $format = NULL);
			$result = $wpdb->get_results("SELECT * FROM cias_orderExtra WHERE code = '$code' LIMIT 1");
			$code_info = $result? $result[0]: null;
			
			$error = false;
		}else{
			$error = "aaaa";
		}

		wp_send_json([
			'status' => 'success',
			'code_info' => $code_info,
			'error' => $error
		]);
	}
	public function checking_handle(){
		$code = isset($_POST['code'])? $_POST['code']: '';
		$security = isset($_POST['security'])? $_POST['security']: '';
		$error = '';
		$code_info = null;

		global $wpdb;

		if(wp_verify_nonce($security, 'security')){
			$result = $wpdb->get_results("SELECT * FROM cias_orderExtra WHERE code = '$code' LIMIT 1");
			foreach ($result as $key => $row){
				$product_id = $row->product_id;
			}
			$product = wc_get_product( $product_id );
			$product_name = $product->get_name();
			$code_info = $result? $result[0]: null;

			$error = false;
		}else{
			$error = true;
		}

		wp_send_json([
			'status' => 'success',
			'code_info' => $code_info,
			'product_name' => $product_name,
			'error' => $error
		]);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cias_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cias_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cias-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cias_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cias_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cias-public.js', array( 'jquery' ), $this->version, false );

	}

}
