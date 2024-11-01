<?php
/*
Plugin Name: WP-CHOOSE YOUR THEME
Plugin URI: http://wordpress.org/extend/plugins/wp-chooseyourtheme/
Description: WP-CHOOSE YOUR THEME let to select an avaiable theme to your visitors. For more info and plugins visit <a href="http://labs.saidmade.com">Labs Saidmade</a>.
Version: 0.6
Author: Giovambattista Fazioli
Author URI: http://www.undolog.com
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 
	Copyright 2009 Saidmade Srl (email : g.fazioli@undolog.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
	
	CHANGE LOG
	
	* 0.6     Rev HTML output for list and roll mode: add slug theme name class
	* 0.5     Add Admin in backend under Appearance. Rev code and avoid Javascript.
	* 0.2     Rev
	* 0.1     First release

*/

require_once( 'wp-chooseyourtheme_class.php');

if( is_admin() ) {
	require_once( 'wp-chooseyourtheme_admin.php' );
	//
	$wp_chooseyourtheme_admin = new WPCHOOSEYOURTHEME_ADMIN();
	$wp_chooseyourtheme_admin->register_plugin_settings( __FILE__ );
} else {
	require_once( 'wp-chooseyourtheme_client.php');
	$wp_chooseyourtheme_client = new WPCHOOSEYOURTHEME_CLIENT();
	require_once( 'wp-chooseyourtheme_functions.php');
}

?>