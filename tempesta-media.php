<?php

/**
 * The plugin bootstrap file
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 * @link              https://tempestamedia.com
 * @since             1.0.0
 * @package           TempestaMedia
 * @wordpress-plugin
 * Plugin Name:       Tempesta Media Publishing
 * Plugin URI:        https://wordpress.org/plugins/tempesta-media/
 * Description:       Publish approved Tempesta Media content as a draft within the "Posts" area of your website
 * Version:           1.0.1
 * Author:            Tempesta Media, LLC
 * Author URI:        https://tempestamedia.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       tempesta-media
 * Domain Path:       /language
 */

namespace TempestaMedia;

use TempestaMedia\Model\Activator;
use TempestaMedia\Model\Core;
use TempestaMedia\Model\Deactivator;

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('TMD_VERSION', '1.0.1');

/**
 * The code that runs during plugin activation.
 * This action is documented in model/activator.php
 */
register_activation_hook(__FILE__, function () {
	require_once realpath(plugin_dir_path(__FILE__) . 'model/activator.php');
	Activator::activate();
});

/**
 * The code that runs during plugin deactivation.
 * This action is documented in model/deactivator.php
 */
register_deactivation_hook(__FILE__, function () {
	require_once realpath(plugin_dir_path(__FILE__) . 'model/deactivator.php');
	Deactivator::deactivate();
});

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require realpath(plugin_dir_path(__FILE__) . 'model/core.php');

/**
 * Begins execution of the plugin.
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 * @since    1.0.0
 */
function execute_tempesta_media() {

	$plugin = new Core();
	$plugin->run();
}

execute_tempesta_media();
