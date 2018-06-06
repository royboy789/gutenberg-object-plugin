<?php

namespace GutenbergArray;

use GutenbergArray\API;

class Hooks {

	use Singleton;

	private $API;

	public function __construct() {
		$this->API = API::init();
		add_action( 'rest_api_init', [ $this, 'gutes_array_fields' ] );
	}

	public function gutes_array_fields() {
		register_rest_field( 'post', 'editor_blocks', [
			'get_callback' => [ $this, 'get_block_data' ],
		]);
	}

	public function get_block_data( $post ) {
		if ( $this->API ) { return; }
		$gutes_data = $this->API->get_editor_db( $post['id'] );
		return json_decode( $gutes_data->gutes_array );
	}



}