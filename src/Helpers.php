<?php
/**
 * Helper Functions
 */

use GutesObjectPlugin\API;

function get_editor_blocks( $post_id = false ) {
	if ( ! $post_id ) {
		return new WP_Error( 'no post id', __( 'get_editor_blocks requires a post ID', 'gutes-array' ) );
	}

	$API = API::init();
	$blocks = $API->get_editor_db( $post_id );
	return json_decode( $blocks->gutes_array );

}