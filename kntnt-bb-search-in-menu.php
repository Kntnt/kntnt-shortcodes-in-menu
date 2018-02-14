<?php

/**
 * Plugin main file.
 *
 * @wordpress-plugin
 * Plugin Name:       Kntnt's Shortcodes in Menu
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Replaces menu items with a shortcode as label. To use it, create custom link menu item with empty URL and the shortcode as the label.
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
defined('WPINC') || die;

new Kntnt_Shortcodes_In_Menu();

class Kntnt_Shortcodes_In_Menu {

  // Start here. :-)
  public function __construct() {
    add_filter('walker_nav_menu_start_el', [$this, 'start_el'], 20, 4);
  }
  
  // Filters menu item before output.
  public function start_el($item_output, $item, $depth, $args) {
    if ($item->title && $item->title[0] === '[' && $this->has_shortcode($item->title)) {
      $item_output = do_shortcode($item->title);
    }
    return $item_output;
  }
      
  private function has_shortcode($shortcode) {
    return preg_match('/' . get_shortcode_regex() . '/s', $shortcode);
  }
  
}
