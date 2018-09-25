<?php
/*
Plugin Name: Wordpress DevStudio
Plugin URI: https://dev-studio.com/
Description:
Version: 1.0
Author:
Author URI: http://dev-studio.com/
License: GPLv2 or later
Text Domain: dev-studio
*/

if ( ! defined( 'DEV_STUDIO_VERSION' ) ) {
	define( 'DEV_STUDIO_VERSION', '1.0' );
}

//require_once 'ajax.php';

if ( ! class_exists( 'DevStudio' ) ) {
	class DevStudio {

		public $enabled = true;
		public $dirs = array();
		public $modules = array(); // Array of modules
		public $map;
		public $mode; // Page mode


		/*
			'admin'  => array( 'final' ),
			'public' => array( 'final' )
		);
		*/

		private static $instance;

		/**
		 * Constructor
		 */
		private function __construct() {


			// Register activation hook
			if ( function_exists( 'register_activation_hook' ) ) {
				register_activation_hook( __FILE__, array( $this, 'plugin_activated' ) );
			}

			// Register deactivation hook
			if ( function_exists( 'register_deactivation_hook' ) ) {
				register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivated' ) );
			}

			//
			if ( function_exists( 'add_action' ) ) {
				// Load assets
				add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );

				// Add item to admin bar menu
				add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 100 );

				// AJAX
				add_action( 'wp_ajax_dev_studio', array( $this, 'ajax' ) );
				add_action( 'wp_ajax_nopriv_dev_studio', array( $this, 'ajax' ) );

				add_action( 'shutdown', array( $this, 'shutdown' ), PHP_INT_MAX );
			}

			/*

			// Enqueue scripts & styles
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );
			*/


		}

		public function init() {
			require_once DevStudio()->get_plugin_dir() . '/core/abstract-module.php';
			require_once DevStudio()->get_plugin_dir() . '/core/abstract-component.php';
			require_once DevStudio()->get_plugin_dir() . '/core/abstract-unit.php';
			require_once DevStudio()->get_plugin_dir() . '/core/checkpoint.php';
			require_once DevStudio()->get_plugin_dir() . '/core/template.php';

			require_once DevStudio()->get_plugin_dir() . '/utils/util.php';
			require_once DevStudio()->get_plugin_dir() . '/utils/data.php';

			$this->data = DEV_STUDIO_Util_Data::data();
			$this->mode = ( ! DEV_STUDIO_Util::is_ajax() ? '' : 'ajax_' ) . ( ! DEV_STUDIO_Util::is_admin() ? 'public' : 'admin' );

			$this->load_modules();

			$this->remove_data();

			$this->checkpoint = new DEV_STUDIO_Checkpoint();
			$this->template   = new DEV_STUDIO_Template();

			$this->shutdown();

			//dd( $this->modules() );

			@mkdir( self::get_storage_dir() );

			// Init hook
			do_action( 'dev-studio/init' );
		}

		/**
		 * Get the instance
		 *
		 * @return self
		 */
		public static function instance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * AJAX requests
		 */
		public function ajax() {
			$response = array(
				'result' => 'ok'
			);
			switch ( $_POST['request'] ) {
				case 'UI':
					$response['html'] = $this->UI();
					break;
				case 'data':
					$response['html'] = $this->checkpoint->load_data();
					break;
			}

			wp_send_json( $response );
			wp_die();
		}


		public function load_modules() {

			foreach ( glob( DevStudio()->get_plugin_dir() . '/modules/*', GLOB_ONLYDIR ) as $dir ) {
				$module = basename( $dir );
				foreach ( glob( $dir . '/*.php' ) as $file ) {
					require_once $file;
					$class_name = 'DEV_STUDIO_' . str_replace( '-', '_', basename( $file, ".php" ) );
					if ( class_exists( $class_name ) ) {
						$this->modules[ $module ] = new $class_name();
					}

				}

			}
			//dump( $this->modules );
		}

		public function modules() {
			return $this->modules;
		}

		public function checkpoints() {
			return $this->checkpoint->checkpoints;
		}


		/**
		 * Admin bar
		 */
		public function admin_bar_menu() {
			global $wp_admin_bar;

			/*
			if ( ! is_admin() || ! is_admin_bar_showing() ) {
				return;
			}
			*/

			/* Add to admin bar */
			$wp_admin_bar->add_menu( array(
				'id'    => 'dev-studio',
				'title' => __( 'Dev Studio', 'dev-studio' ),
				'href'  => admin_url( 'admin.php?page=dev_studio_options' )
			) );
		}

		/**
		 * Load assets
		 */
		public function load_assets() {
			wp_enqueue_style( 'dev-studio', $this->get_plugin_url() . '/assets/css/styles.css' );

			wp_enqueue_script( 'dev-studio', $this->get_plugin_url() . '/assets/js/scripts.js', array( 'jquery' ) );
			$data = array(
				'ajax_url' => '/wp-admin/admin-ajax.php',
				'mode'     => $this->mode
			);

			$this->map   = DEV_STUDIO_Util::map();
			$data['map'] = $this->map;

			wp_localize_script( 'dev-studio', 'DSData', $data );
		}


		/**
		 * UI
		 */
		public function UI() {
			return $this->template( 'dev-studio' );
		}

		/**
		 * Load template
		 */
		public function template( $tmpl_name, $data = array() ) {
			return $this->template->load( $tmpl_name, $data );
		}

		/**
		 * Plugin activation
		 */
		public function plugin_activated() {

			// Create plugin storage directory
			@mkdir( self::get_storage_dir() );
		}

		/**
		 * Plugin deactivation
		 */
		public function plugin_deactivated() {
		}

		/** Plugin uninstall */
		public static function plugin_uninstall() {
		}

		/** Plugin uninstall */
		public static function get_storage_dir() {
			if ( function_exists( 'wp_get_upload_dir' ) ) {
				$upload_dir = wp_get_upload_dir();

				return $upload_dir['basedir'] . '/dev-studio';
			} else {
				return ABSPATH . 'wp-content/uploads/dev-studio';
			}
		}

		public function get_plugin_dir() {
			return __DIR__;
		}

		public function get_plugin_url() {
			if ( function_exists( 'plugin_dir_url' ) ) {
				return plugin_dir_url( __FILE__ );
			}
		}

		public function shutdown() {
			if ( empty( $this->checkpoints() ) ) {
				$this->checkpoint->add( 'shutdown' );
			}
		}

		public function remove_data() {
			$storage_dir = DevStudio()->get_storage_dir();

			@mkdir( $storage_dir . '/data', 755 );
			@mkdir( $storage_dir . '/data/' . DevStudio()->mode, 755 );

			DEV_STUDIO_Util::rmdir( $storage_dir . '/data/' . DevStudio()->mode );
		}

		public function me() {
			return isset( $_POST['action'] ) && $_POST['action'] == 'dev_studio';
		}

		/**
		 * Cloning disabled
		 */
		private function __clone() {
		}

		/**
		 * Serialization disabled
		 */
		private function __sleep() {
		}

		/**
		 * De-serialization disabled
		 */
		private function __wakeup() {
		}

	}
}

if ( ! function_exists( 'dev_studio' ) ) {
	function DevStudio() {
		return DevStudio::instance();
	}
}
DevStudio()->init();


/******************************** TEST *************************************/

add_action( '1shutdown', function () {
	global $wp_filter;
	//dd($wp_filter);

	$data = array();
	foreach ( $wp_filter as $filter => $wp_hook ) {
		if ($filter!='woocommerce_purchase_order_item_types') continue;

		$callbacks = array();
		$count     = 0;
		foreach ( $wp_hook->callbacks as $priority => $array ) {

			foreach ( $array as $array2 ) {

				/*
				if (isset( $function['function'][0] ) && is_object($function['function'][0]) ) {
					//dd();
					//dd(get_class($function['function'][0]));
					//dd($function['function']);

					dump($function);
					dump( $function['function'][1] );
					if (is_object($function['function'][0])) dump('11');
					dump(get_class( $function['function'][0] ));
					//dump( $function['function'][0] );
					//dump( $function['function'][1] );
					//exit;

				}
				*/

				dump($filter);
				if ( isset( $array2['function'][0] ) && is_object( $array2['function'][0] ) ) {
					$class = @get_class( $array2['function'][0] );
					$function = $class . '->' . $array2['function'][1];
				} else {
					$function = $array2['function'];
				}
				$callbacks[ $priority ][] = array(
					'function' => $function
				);
			}
			$count ++;
			//if ($count==10) exit;
		}
		$data[ $filter ] = array(
			'callbacks' => $callbacks,
			'count'     => $count
		);
	}

	dd( $data );
} );


?>