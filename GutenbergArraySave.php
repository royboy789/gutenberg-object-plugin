<?php
/*
 * @wordpress-plugin
 * Plugin Name:       Gutenberg Array Save
 * Description:       Save Gutenberg Data as a clean array in wp_gutenberg
 * Version:           0.0.1
 * Author:            Roy Sivan
 * Author URI:        https://roysivan.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Textdomain:        gutes-array
 */

namespace GutenbergArray;

require_once 'vendor/autoload.php';

define( 'GutesArraySaveUrl', plugin_dir_url( __FILE__ ) );
define( 'GutesArrayPluginFile', __FILE__ );

use GutenbergArray\Scripts;
use GutenbergArray\Database;
use GutenbergArray\API;

class GutenbergArraySave {

	use Singleton;

	public function __construct() {
		Scripts::init();
		Database::init();
		API::init();
	}
}

$GutesArraySave = GutenbergArraySave::init();