<?php
/**
 * Core 
 */

class WPCHOOSEYOURTHEME_CLASS {
		
	/**
	 * @internal
	 * @staticvar
	 */
	var $version 							= "0.6";					// plugin version
	var $plugin_name 						= "WP CHOOSE YOUR THEME";	// plugin name
	var $options_key 						= "wp-chooseyourtheme";			// options key to store in database
	var $options_title						= "WP-Choose Your Theme";	// label for "setting" in WP
	
	/**
	 * Usefull vars
	 * @internal 
	 */
	var $content_url						= "";
	var $plugin_url							= "";
	var $ajax_url							= "";
	
	var $path 								= "";
	var $file 								= "";
	var $directory							= "";
	var $uri 								= "";
	var $siteurl 							= "";
	var $wpadminurl 						= "";

	/**
	 * This properties variable are @public
	 * 
	 * @property
	 *  
	 */
	var $options							= array();

	/**
	 * @constructor 
	 */
	function WPCHOOSEYOURTHEME_CLASS() {
		$this->path 						= dirname(__FILE__);
		$this->file 						= basename(__FILE__);
		$this->directory 					= basename($this->path);
		$this->uri 							= WP_PLUGIN_URL . "/" . $this->directory;
		$this->siteurl						= get_bloginfo('url');
		$this->wpadminurl					= admin_url();		
		
		$this->content_url 					= get_option('siteurl') . '/wp-content';
		$this->plugin_url 					= $this->content_url . '/plugins/' . plugin_basename( dirname(__FILE__) ) . '/';
	}
	
	/**
	 * Get option from database
	 * 
	 * @return 
	 */
	function getOptions() {
		$this->options 						= get_option( $this->options_key );
	}	
	
	/**
	 * Check the Wordpress relase for more setting
	 * 
	 * @return 
	 */
	function checkWordpressRelease() {
		global $wp_version;
		if ( strpos($wp_version, '2.7') !== false || strpos($wp_version, '2.8') !== false  ) {}
	}
	
} // end of class

?>