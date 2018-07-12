<?php
/*
 * @wordpress-plugin
 * Plugin Name:       Gutenberg Object Plugin
 * Description:       Saves Gutenberg data as array into DB & adds API to access it
 * Version:           1.1.0
 * Author:            Roy Sivan
 * Author URI:        https://roysivan.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Textdomain:        gutes-array
 */

namespace GutenbergArray;


if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once 'vendor/autoload.php';
}

require_once 'src/Helpers.php';

define( 'GutesArraySaveUrl', plugin_dir_url( __FILE__ ) );
define( 'GutesArrayPluginFile', __FILE__ );

use GutenbergArray\Scripts;
use GutenbergArray\Database;
use GutenbergArray\API;
use GutenbergArray\Hooks;

class GutenbergObjectPlugin {

	use Singleton;

	public function __construct() {
		Scripts::init();
		Database::init();
		API::init();
		Hooks::init();
	}
}

$GutesArraySave = GutenbergObjectPlugin::init();



