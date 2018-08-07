<?php

namespace GutenbergArray;


class Scripts {

	use Singleton;

	public function __construct() {
		add_action( 'enqueue_block_editor_assets', [ $this, 'gutenbger_array_save_scripts' ] );
	}

	public function gutenbger_array_save_scripts() {
		wp_enqueue_script( 'gutes-array-save', GutesArraySaveUrl . 'build/js/gutenberg-db.build.js', [ 'wp-blocks', 'wp-element' ], true );
		wp_localize_script( 'gutes-array-save', 'gutesObjectPluginSettings', [
			'nonce' => wp_create_nonce( 'wp_rest'),
		]);
	}

}