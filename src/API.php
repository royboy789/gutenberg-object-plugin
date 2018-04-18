<?php

namespace GutenbergArray;

use WP_REST_Posts_Controller;

class API {

	use Singleton;

	private $version = '1';

	public function __construct() {
		add_action( 'rest_api_init', function () {
			register_rest_route( 'gutes-db/v' . $this->version, '/(?P<id>\d+)', array(
				'methods' => 'GET',
				'callback' => [ $this, 'get_gutes_data' ],
				'args' => [
					'id' => [
						'required' => true,
						'validate_callback' => function( $param, $request, $key ) {
							return is_numeric( $param );
						}
					],
				]
			) );
		} );

		add_action( 'rest_api_init', function () {
			register_rest_route( 'gutes-db/v1', '/(?P<id>\d+)', array(
				'methods' => 'POST',
				'callback' => [ $this, 'save_gutes_data' ],
				'args' => [
					'id' => [
						'required' => true,
						'validate_callback' => function( $param, $request, $key ) {
							return is_numeric( $param );
						}
					],
					'gutes_data' => [
						'required' => true,
					],
				]
			) );
		} );
	}

	public function save_gutes_data( \WP_REST_Request $request ) {
		if ( ! function_exists( 'gutenberg_content_has_blocks' ) ) {
			return new \WP_Error( 'No Gutes', __( 'Missing Gutenberg', 'gutes-array' ) );
		}

		$data = $request->get_params();
		$post_id = (int) $data['id'];
		$is_gutes = $this->is_gutes( $post_id );

		if ( ! $is_gutes ) {
			return new \WP_Error( 'Not Gutes', __( 'Not Created Using Gutenberg', 'gutes-array' ), [ 'post_id' => $post_id ] );
		}

		$return = [
			'post_id' => $post_id,
			'save' => $this->save_gutes_db( $post_id, $data['gutes_data'] )
		];

		return new \WP_REST_Response( $return );

	}

	public function get_gutes_data( \WP_REST_Request $request ) {

		if ( ! function_exists( 'gutenberg_content_has_blocks' ) ) {
			return new \WP_Error( 'No Gutes', __( 'Missing Gutenberg', 'gutes-array' ) );
		}

		$data = $request->get_params();
		$post_id = (int) $data['id'];
		$is_gutes = $this->is_gutes( $post_id );

		if ( ! $is_gutes ) {
			return new \WP_Error( 'Not Gutes', __( 'Not Created Using Gutenberg', 'gutes-array' ), [ 'post_id' => $post_id ] );
		}

		$return = [
			'is_gutes' => $is_gutes,
			'post_id'  => $post_id,
			'data' => ( $gutes_row = $this->get_gutes_db( $post_id ) ) ? $gutes_row->gutes_array : false,
		];

		if ( isset( $data['_embed'] ) ) {
			$return['_embedded'] = [
				'post' => $this->get_embedded_post( $post_id ),
			];
		}

		return new \WP_REST_Response( $return );

	}

	private function is_gutes( $post_id ) {
		$post = get_post( $post_id );
		// If new post, new content will exist.
		if ( empty( $post->post_content ) ) {
			return true;
		}
		return gutenberg_content_has_blocks( $post->post_content );
	}

	private function get_embedded_post( $post_id ) {
		$request = new \WP_REST_Request( 'GET', '/wp/v2/posts' );
		$request->set_query_params( [ 'per_page' => 12 ] );
		$response = rest_do_request( $request );
		$server = rest_get_server();
		return $server->response_to_data( $response, false );
	}

	private function get_gutes_db( $post_id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . "gutes_arrays";
		return $wpdb->get_row( "SELECT * FROM $table_name WHERE post_id = $post_id" );
	}

	private function save_gutes_db( $post_id, $gutes_data ) {
		global $wpdb;

		$table_name = $wpdb->prefix . "gutes_arrays";
		return $wpdb->update(
			$table_name,
			[
				'post_id' => $post_id,
				'gutes_array' => json_encode( $gutes_data ),
			],
			[
				'post_id' => $post_id
			],
			[
				'%d',
				'%s',
			],
			[
				'%d'
			]
		);
	}

}