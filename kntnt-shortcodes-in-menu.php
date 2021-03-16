<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Shortcodes in Menu
 * Plugin URI:        https://github.com/Kntnt/kntnt-shortcodes-in-menu
 * Description:       Replaces menu items that has shortcode as a label with the output of the shortcode.
 * Version:           1.0.1
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Kntnt\Shortcodes_In_Menu;

defined( 'ABSPATH' ) && new Plugin;

class Plugin {
	
	private static $shortcode_regex;

	public function __construct() {
		$this->shortcode_regex = get_shortcode_regex();
		add_filter( 'walker_nav_menu_start_el', [ $this, 'menu_item' ], 20, 4 );
	}

	public function menu_item( $item_output, $item, $depth, $args ) {
		if ( $item->title && $item->title[0] === '[' && $this->has_shortcode( $item->title ) ) {
			$item_output = do_shortcode( $item->title );
		}
		return $item_output;
	}

	private function has_shortcode( $shortcode ) {
		return preg_match( "/^{$this->shortcode_regex}/$", $shortcode );
	}

}
