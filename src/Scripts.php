<?php

namespace GutenbergArray;


class Scripts {

	public function __construct() {
		add_action( 'enqueue_block_editor_assets', [ $this, 'gutenbger_array_save_scripts' ] );
	}

	public function gutenbger_array_save_scripts() {
		wp_enqueue_script( 'gutes-array-save', GutesArraySaveUrl . 'build/js/gutenberg-db.build.js', [ 'wp-blocks', 'wp-element' ], true );
	}

}