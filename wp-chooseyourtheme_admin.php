<?php
/**
 * Admin (back-end)
 */
class WPCHOOSEYOURTHEME_ADMIN extends WPCHOOSEYOURTHEME_CLASS {
	
	function WPCHOOSEYOURTHEME_ADMIN() {
		$this->WPCHOOSEYOURTHEME_CLASS();							// super
		$this->initDefaultOption();
	}
	
	/**
	 * Init the default plugin options and re-load from WP
	 * 
	 * @return 
	 */
	function initDefaultOption() {
		$this->options 						= array('hidden_themes'	=> array() );
		add_option( $this->options_key, $this->options, $this->options_title );
		
		parent::getOptions();
		
		add_action('admin_menu', 	array( $this, 'add_menus') );
		
	}

	function register_plugin_settings( $pluginfile ) {
		add_action( 'plugin_action_links_'.basename( dirname( $pluginfile ) ) . '/' . basename( $pluginfile ), array( &$this, 'plugin_settings' ), 10, 4 );
	}
	
	function plugin_settings( $links ) {
		$settings_link = '<a href="admin.php?page=wp-chooseyourtheme-settings">' . __('Settings') . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
	
	
	function add_menus() {
		$menus = array();
		/*
		if (function_exists('add_object_page'))
			$menus['main'] = add_object_page('WP Choose Your Theme', 'WP Choose Your Theme', 8, $this->directory.'-settings', array( &$this, 'set_options_subpanel') );
		else
			$menus['main'] = add_menu_page('WP Choose Your Theme', 'WP Choose Your Theme', 8, $this->directory.'-settings', array(&$this,'set_options_subpanel') );
		*/
		$menus['settings'] = add_submenu_page('themes.php', 'WP Choose Your Theme', 'WP Choose Your Theme', 8, $this->directory.'-settings', array(&$this,'set_options_subpanel') );
		
		if (function_exists('add_contextual_help')) {
			add_contextual_help($menus['settings'],'<p><strong>'.__('Use').':</strong></p>' .
			'<pre>wp_chooseyourtheme();</pre> or<br/>' .
			'<pre>wp_chooseyourtheme( \'mode=roll\' );</pre><br/>' .
			'<pre>
* menu    Show like combo menu
* list    Show like list (ul/li)
* roll    Show like link (button) and cycle for all selected themes
</pre>' 			
			);
		}
	}	
	
	
	/**
	 * Draw Options Panel
	 */
	function set_options_subpanel() {
		global $wpp_options, $wpdb, $_POST;
		
		$any_error 	= "";										// any error flag
		$info 		= "";
		
		if( isset( $_POST['command_action'] ) ) {				// have to save options	
			$any_error = __('Your settings have been saved.');
	
			switch( $_POST['command_action'] ) {
				case "mysql_update":
					if( is_array($_POST['hidden_themes']) ) {
						$this->options['hidden_themes'] = $_POST['hidden_themes'];
					} else {
						$this->options['hidden_themes'] = array();
						$info = __('WARNING: all theme will be visible!');
					}
					update_option( $this->options_key, $this->options);
					break;		
			}
		}
		
		/**
		 * Show error or OK
		 */
		if( $any_error != '' )	echo '<div id="message" class="updated fade"><p>' . $any_error . '</p></div>';
		if( $info != '' )		echo '<div id="message" class="updated fade"><p>' . $info . '</p></div>';
		
		/**
		 * INSERT OPTION
		 *
		 * You can include a separate file: include ('options.php');
		 *
		 */
		?>
		
		<div class="wrap">
			<div class="icon32" id="icon-options-general"><br/></div>
		    <h2><?=$this->options_title?> ver. <?=$this->version?></h2>
		
			<h2><?php echo __('Select the Themes you want to make hidden')?></h2>
			<form class="form_box" name="select_theme" method="post" action="">
				<input type="hidden" name="command_action" id="command_action" value="mysql_update" />
				
				<table class="form-table">
					<tr>
						<td><?php echo $this->get_check_theme(); ?></td>
					</tr>
				</table>
				
				<div class="submit"><input class="button-primary" type="submit" value="<?php echo __('Update')?>" /></div>
			</form>
					
			<p style="text-align:center;font-family:Tahoma;font-size:10px">Developed by <a target="_blank" href="http://www.saidmade.com"><img align="absmiddle" src="http://labs.saidmade.com/images/sm-a-80x15.png" border="0" /></a>
				<br/>
				more Wordpress plugins on <a target="_blank" href="http://labs.saidmade.com">labs.saidmade.com</a> and <a target="_blank" href="http://www.undolog.com">Undolog.com</a>
				<br/>
				<form style="text-align:center;width:300px;margin:0 auto" action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="3499468">
					<input type="image" src="https://www.paypal.com/it_IT/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - Il sistema di pagamento online pi� facile e sicuro!">
					<img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
				</form>
			</p>	
	
		</div>
		
		<?php
	}
	
	/**
	 * Show all theme like input check for admin
	 * 
	 * @return 
	 */
	function get_check_theme() {
		$themes = get_themes();

		$default_theme = get_current_theme();
		
		if (count($themes) > 1) {
			$theme_names = array_keys($themes);
			natcasesort($theme_names);
		
			$o = '';
	 		foreach ($theme_names as $theme_name) {
				// Skip unpublished themes.
				if (isset($themes[$theme_name]['Status']) && $themes[$theme_name]['Status'] != 'publish') continue;

				$checked = ( in_array($theme_name, $this->options['hidden_themes']) ) ? 'checked="checked"' : "";

				$o .= '<input ' . $checked . ' name="hidden_themes[]" type="checkbox" value="' . $theme_name . '"/> <label>' . $theme_name . '</label><br/>';
			}
			return $o;
		}
	}	

	
	
} // end of class

?>