<?php

namespace GutenbergArray;

use GutenbergArray\API;

class Hooks {

	use Singleton;

	private $API;

	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'gutes_array_fields' ] );
	}

	public function gutes_array_fields() {
		register_rest_field( 'post', 'editor_blocks', [
			'get_callback' => [ $this, 'get_block_data' ],
		]);

		if ( defined( 'GUTENBERG_OBJECT_PLUGIN_CPTS' ) ) {
			$cpts = GUTENBERG_OBJECT_PLUGIN_CPTS;
			$cpts = explode( ',', $cpts );

			foreach( $cpts as $cpt ) {
				register_rest_field( $cpt, 'editor_blocks', [
					'get_callback' => [ $this, 'get_block_data' ],
				]);
			}
		}
	}

	public function get_block_data( $post ) {
		if ( ! $this->API ) {
			$this->API = API::init();
		}
		$gutes_data = $this->API->get_editor_db( $post['id'] );
		if ( ! is_object( $gutes_data ) ) {
			return 'Error Getting Editor DB ' . $post['id'];
		}
		return json_decode( $gutes_data->gutes_array );
	}



}