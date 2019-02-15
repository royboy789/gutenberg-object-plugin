<?php

namespace GutesObjectPlugin;


class BlockAPI {

	public function init() {
		// All blocks for a post
		register_rest_route( 'wp/v2', 'posts/(?P<id>\d+)/blocks', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_all_blocks' ],
			'args' => [
				'id' => [
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					}
				],
			]
		]);

		// Individual block
		register_rest_route( 'wp/v2', 'posts/(?P<id>\d+)/blocks/(?P<bid>\S+)', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_single_block' ],
			'args' => [
				'id' => [
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					}
				],
				'bid' => [
					'required' => true
				],
			]
		]);

		// All blocks for a page
		register_rest_route( 'wp/v2', 'pages/(?P<id>\d+)/blocks', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_all_blocks' ],
			'args' => [
				'id' => [
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					}
				],
			]
		]);

		// Individual block
		register_rest_route( 'wp/v2', 'pages/(?P<id>\d+)/blocks/(?P<bid>\S+)', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_single_block' ],
			'args' => [
				'id' => [
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					}
				],
				'bid' => [
					'required' => true
				],
			]
		]);
	}

	/**
	 * Get all blocks for a post
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_all_blocks( \WP_REST_Request $request ) {
		$data = $request->get_params();

		$post_id = $data['id'];

		$gutes_data = [];

		if ( function_exists( 'get_editor_blocks' ) ) {
			$gutes_data = get_editor_blocks( $post_id );
		} else {
			return new \WP_Error( 'no gutes obj plugin', 'You need the Gutenberg Object Plugin' );
		}

		return new \WP_REST_Response( $gutes_data );
	}


	public function get_single_block( \WP_REST_Request $request ) {
		$data = $request->get_params();
		$post_id = $data['id'];
		$bid = $data['bid'];

		$block = false;

		if ( function_exists( 'get_editor_blocks' ) ) {
			$blocks = get_editor_blocks( $post_id );
		} else {
			return new \WP_Error( 'no gutes obj plugin', 'You need the Gutenberg Object Plugin' );
		}

		foreach( $blocks as $value ) {
			if ( $value->data->bid && $bid === $value->data->bid ) {
				$block = $value;
			}
		}

		if ( ! $block ) {
			return new \WP_Error( 'no block found', 'Cannot find that block', array( 'status' => 404 ) );
		}

		return new \WP_REST_Response( $block );
	}
}