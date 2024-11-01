<?php
/**
 * Show themes for front-end
 * 
 * @return 
 * @param object $args[optional]
 * 
 * @args		mode=['menu','list','roll','rand']
 * 
 * menu			Show like combo menu
 * list			Show like list (ul/li)
 * roll			Show like link (button) and cycle for all selected themes
 * 
 * @future implement
 * rand			Show like link (button) and select a random theme
 *  
 */
function wp_chooseyourtheme( $args = '' ) {
	global $wp_chooseyourtheme_client;
	
	$default = array( 'mode' => 'menu' );
		
	$new_args = wp_parse_args( $args, $default );	
	
	switch($new_args['mode']) {
		case "menu":
			echo $wp_chooseyourtheme_client->get_combo_theme();
			break;
		case "list":
			echo $wp_chooseyourtheme_client->get_list_theme();
			break;
		case "roll":
			echo $wp_chooseyourtheme_client->get_roll_theme();
			break;
		case "rand":
			break;		
		default:
			echo $wp_chooseyourtheme_client->get_combo_theme();
			break;		
	}
}

?>