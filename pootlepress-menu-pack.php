<?php
/*
Plugin Name: Canvas Extension - Menu Pack
Plugin URI: http://pootlepress.com/
Description: An extension for WooThemes Canvas that contains a menu design pack. This helps you customise the look and feel of your navigation menu in the Canvas theme by WooThemes.
Version: 1.2.0
Author: PootlePress
Author URI: http://pootlepress.com/
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
/*  Copyright 2012  Pootlepress  (email : jamie@pootlepress.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	require_once( 'pootlepress-menu-pack-functions.php' );
	require_once( 'classes/class-pootlepress-menu-pack.php' );

    $GLOBALS['pootlepress_menu_pack'] = new Pootlepress_Menu_Pack( __FILE__ );
    $GLOBALS['pootlepress_menu_pack']->version = '1.0.0';
	
?>
