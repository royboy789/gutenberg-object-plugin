<?php
/*
 * @wordpress-plugin
 * Plugin Name:       Gutenberg Object Plugin
 * Description:       Saves Gutenberg data as array into DB & adds API to access it
 * Version:           1.6.0
 * Author:            Roy Sivan
 * Author URI:        https://roysivan.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Textdomain:        gutes-array
 */

namespace GutesObjectPlugin;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once 'vendor/autoload.php';
}

require_once 'src/Helpers.php';


use GutesObjectPlugin\Scripts;
use GutesObjectPlugin\Database;
use GutesObjectPlugin\API;
use GutesObjectPlugin\Hooks;


class GutesObjectPlugin {

	public static $GutesObjectPluginUrl;
	public static $GutesObjectPluginFile;

	private $database;
	private $api;
	private $hooks;

	public function __construct( Database $database, API $api, Hooks $hooks ) {
		$this->database = $database;
		$this->api = $api;
		$this->hooks = $hooks;
	}

	public function run() {
		self::$GutesObjectPluginFile = __FILE__;
		self::$GutesObjectPluginUrl = plugin_dir_url( __FILE__ );
	}

}

// construction of plugin
$scripts = new Scripts();

$api = new API();
$hooks = new Hooks( $api );
$database = new Database();

$gutenbergObjectPlugin = new GutesObjectPlugin( $database, $api, $hooks );
$gutenbergObjectPlugin->run();
$database->create();