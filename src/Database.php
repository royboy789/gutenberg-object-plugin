<?php

namespace GutesObjectPlugin;

use GutesObjectPlugin\GutesObjectPlugin;


class Database {

	public function create() {
		register_activation_hook( GutesObjectPlugin::$GutesObjectPluginFile, [ $this, 'activate_gutes_array_save' ] );
		register_deactivation_hook( GutesObjectPlugin::$GutesObjectPluginFile, [ $this, 'deactivate_gutes_array_save' ] );
	}

	public function activate_gutes_array_save() {
		global $wpdb;
		$table_name = $wpdb->prefix . "gutes_arrays";
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    post_id mediumint(9) NOT NULL,
                    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `gutes_array` LONGTEXT NOT NULL,
                    PRIMARY KEY  (id)
                ) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	public function deactivate_gutes_array_save() {
		global $wpdb;
		$table_name = $wpdb->prefix . "gutes_arrays";
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "DROP TABLE $table_name";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}