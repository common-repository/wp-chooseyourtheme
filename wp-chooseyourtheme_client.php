<?php
/**
 * Client (front-end)
 */
class WPCHOOSEYOURTHEME_CLIENT extends WPCHOOSEYOURTHEME_CLASS {
	
	function WPCHOOSEYOURTHEME_CLIENT() {
		$this->WPCHOOSEYOURTHEME_CLASS();					// super
		
		parent::getOptions();								// retrive options from database
		
		add_filter('template', array( &$this, 'get_template') );
		add_filter('stylesheet', array( &$this, 'get_stylesheet') );		
		add_action('wp_head', array( &$this, 'load_javascript'));
	}
	
	/**
	 * Hook function to load javascript for front-end
	 * @return 
	 */
	function load_javascript() {
		?><script type="text/javascript">function wpcyt_setTheme(a,b,c,e,f,g){var h=new Date();h.setDate(h.getDate()+c);var i=a+"="+escape(b)+((h)?";expires="+h.toGMTString():"")+((e)?";path="+e:"")+((f)?";domain="+f:"")+((g)?";secure":"");d=document;d.cookie=i;d.location=d.location.href}</script><?php
	}
	
	/**
	 * Hook function for Wordpress loading theme
	 * 
	 * @return 
	 * @param object $template
	 */
	function get_template( $template ) {
		$theme = $this->get_selected_theme();
		if ($theme === false) {
			return $template;
		}
		return $theme['Template'];
	}
	
	/**
	 * Hook function for Wordpress loading style
	 * 
	 * @return 
	 * @param object $stylesheet
	 */
	function get_stylesheet( $stylesheet ) {
		$theme = $this->get_selected_theme();
		if ($theme === false) {
			return $stylesheet;
		}		
		return $theme['Stylesheet'];
	}

	/**
	 * Show all themes like combo menu
	 * 
	 * @return 
	 */		
	function get_combo_theme() {
		$themes = get_themes();

		//echo '<pre>'; print_r($themes); echo '</pre>';

		$default_theme = get_current_theme();
		
		if (count($themes) > 1) {
			$theme_names = array_keys($themes);
			natcasesort($theme_names);
		
			$o = '<select class="wpcyt_combo" name="wpcyt_themes" onchange="wpcyt_setTheme(\'wpcyt_name\',this.options[this.selectedIndex].value,30)">';
	 		foreach ($theme_names as $theme_name) {
				// Skip unpublished themes.
				if (isset($themes[$theme_name]['Status']) && $themes[$theme_name]['Status'] != 'publish' || in_array( $theme_name, $this->options['hidden_themes'] ) ) continue;
				$selected = (($this->is_set_cookie() == $theme_name) || (($this->is_set_cookie() == '') && ($theme_name == $default_theme))) ? 'selected="selected"' : '';
				$o .= '<option value="' . $theme_name . '" '. $selected . '>' . htmlspecialchars($theme_name) . '</option>';
			}
			$o .= '</select>';
			return $o;
		}
	}

	/**
	 * Show all theme like list
	 * 
	 * @return 
	 */
	function get_list_theme() {
		$themes = get_themes();

		$default_theme = get_current_theme();
		
		if (count($themes) > 1) {
			$theme_names = array_keys($themes);
			natcasesort($theme_names);
		
			$o = '<ul class="wpcyt_list">';
	 		foreach ($theme_names as $theme_name) {
				// Skip unpublished themes.
				if (isset($themes[$theme_name]['Status']) && $themes[$theme_name]['Status'] != 'publish' || in_array( $theme_name, $this->options['hidden_themes'] )) continue;
				$selected = (($this->is_set_cookie() == $theme_name) || (($this->is_set_cookie() == '') && ($theme_name == $default_theme))) ? ' selected' : '';
				$o .= '<li class="' . $this->slug($theme_name) . $selected . '"><a onclick="wpcyt_setTheme(\'wpcyt_name\',\'' . $theme_name . '\',30);return false" href="#"><span>' . htmlspecialchars($theme_name) . '</span></a></li>';
			}
			$o .= '</li>';
			return $o;
		}
	}
	
	function get_roll_theme() {
		$themes = get_themes();

		$default_theme = get_current_theme();
		
		if (count($themes) > 1) {
			$theme_names = array_keys($themes);
			natcasesort($theme_names);
		
			$get_next 	= false;
			$firt_theme	= $o = '';
	 		foreach ($theme_names as $theme_name) {
				// Skip unpublished themes.
				if (isset($themes[$theme_name]['Status']) && $themes[$theme_name]['Status'] != 'publish' || in_array( $theme_name, $this->options['hidden_themes'] )) continue;
				$firt_theme	= ($firt_theme == '') ? $theme_name: $firt_theme;
				if($get_next) {
					$o = '<div class="wpcyt_roll"><a class="' . $this->slug($theme_name) . '" onclick="wpcyt_setTheme(\'wpcyt_name\',\'' . $theme_name . '\',30);return false" href="#"><span>' . htmlspecialchars($theme_name) . '</span></a></div>';
					break;
				}
				$get_next = (($this->is_set_cookie() == $theme_name) || (($this->is_set_cookie() == '') && ($theme_name == $default_theme)));
			}
			if($get_next && $o == "") {
				$o = '<div class="wpcyt_roll"><a class="' . $this->slug($firt_theme) . '" onclick="wpcyt_setTheme(\'wpcyt_name\',\'' . $firt_theme . '\',30);return false" href="#"><span>' . htmlspecialchars($firt_theme) . '</span></a></div>';
			}
			return $o;
		}
	}
	
	function slug($s) {
		$slug = preg_replace("/[^a-zA-Z0-9 ]/", "", $s);
		return( strtolower( str_replace(" ", "-", $slug) ) );
		
	}
	
	/**
	 * Check cookie on system
	 * 
	 * @return 
	 * @param object $name[optional]
	 * @param object $default[optional]
	 */
	function is_set_cookie($name="wpcyt_name", $default="") {
		return ( isset( $_COOKIE['wpcyt_name'] ) ? $_COOKIE['wpcyt_name'] : $default );
	}
	
	/**
	 * Return the selected theme cookie
	 * 
	 * @return 
	 */
	function get_selected_theme() {
		if(!isset( $_COOKIE['wpcyt_name'] )) {
			$theme_data = get_theme( get_current_theme() );
			return $theme_data;
		}
		
		$theme_data = get_theme( $_COOKIE['wpcyt_name'] );
		
		if (!empty($theme_data)) {
			// Don't let people peek at unpublished themes
			if (isset($theme_data['Status']) && $theme_data['Status'] != 'publish' || in_array( $theme_name, $this->options['hidden_themes'] ) ) {
				return false;
			}
			return $theme_data;
		}
		
		// perhaps they are using the theme directory instead of title
		$themes = get_themes();
		
		foreach ($themes as $theme_data) {
			// use Stylesheet as it's unique to the theme - Template could point to another theme's templates
			if ($theme_data['Stylesheet'] == $theme) {
				// Don't let people peek at unpublished themes
				if (isset($theme_data['Status']) && $theme_data['Status'] != 'publish') {
					return false;
				}
			return $theme_data;
			}
		}
	}	
	
} // end of class

?>