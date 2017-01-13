<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/public
 * @author     Antoine Ferrier
 */


include_once(plugin_dir_path( __FILE__ ) . '../class-ad-back.php');
class Ad_Back_Public extends Ad_Back_Generic  {

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
		 * defined in Ad_Back_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ad_Back_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ab-public.css', array(), $this->version, 'all' );

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
		 * defined in Ad_Back_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ad_Back_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$me = $this->getMyInfo();
		$this->getMessages();
		$mess = $this->getCacheMessages();

		if(is_array($me)) {
			if(!empty($me['scripts'])) {
				echo "<script>".$me['scripts'][0]."</script>";
			}

			if(!empty($me['custom_scripts'])) {
				if($mess->display) {
					echo "<script>".$me['custom_scripts'][0]."</script>";
				}
			}
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ab-public.js', array( 'jquery' ), $this->version, false );
	}

}
