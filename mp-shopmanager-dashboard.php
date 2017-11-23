<?php
/**
 * Plugin Name: MP Shop Manager Dashboard
 * Description: Shop manager user dashboard customization
 * Plugin URI: https://www.plugdigital.net
 * Author: Manuel Padilla
 * Author URI: https://www.plugdigital.net/manuel-padilla
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mp_smd
 * Domain Path: /languages/
 */

/*
MP Shop Manager Dashboard is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
MP Shop Manager Dashboard is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with MP Shop Manager Dashboard. If not, see {URI to Plugin License}.
*/

defined( 'ABSPATH' ) or exit;

define( 'MPSMD__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define( 'MPSMD__PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

require_once( MPSMD__PLUGIN_DIR . 'class.mp-shopmanager-dashboard.php' );

add_action( 'init', array( 'mpsmd', 'init' ) );