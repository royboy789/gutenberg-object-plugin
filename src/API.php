<?php

namespace GutesObjectPlugin;

use WP_REST_Posts_Controller;
use GutesObjectPlugin\BlockAPI;

/**
 * Class API - this is where custom API routes are defined.
 * For the filter adding in editor_blocks to POST response see src/Hooks.php
 *
 * @package GutesObjectPlugin
 */
class API {

	private $namespace = 'gutes-db/v1';

	private $blockAPI;

	/**
	 * API constructor.
	 * Init API
	 *
	 */
	public function __construct() {
		$this->blockAPI = new BlockAPI();
		add_action( 'rest_api_init', [ $this, 'gutes_db_api_init' ], 10 );
	}

	/**
	 * API init
	 */
	public function gutes_db_api_init() {
		// Register Block API
		$this->blockAPI->init();

		// GET Gutes Data.
		register_rest_route( $this->namespace, '/(?P<id>\d+)', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_editor_data' ],
			'args' => [
				'id' => [
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					}
				],
			]
		]);

		// Get Gutes Revision.
		register_rest_route( $this->namespace, '/(?P<id>\d+)/revisions', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_revision_data' ],
			'args' => [
				'id' => [
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					}
				],
			]
		]);

		register_rest_route( $this->namespace, '/(?P<id>\d+)', [
			'methods' => 'POST',
			'callback' => [ $this, 'save_editor_data' ],
			'args' => [
				'id' => [
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					}
				],
				'is_in_preview' => [
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return $param;
					}
				],
				'gutes_data' => [
					'required' => true,
				],
			]
		]);
	}

	/**
	 * Save Gutes Data.
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function save_editor_data( \WP_REST_Request $request ) {
		if ( ! function_exists( 'has_blocks' ) ) {
			return new \WP_Error( 'No Gutes', __( 'Missing Gutenberg', 'gutes-array' ) );
		}

		$data = $request->get_params();
		$post_id = (int) $data['id'];
		$is_gutes = $this->is_gutes( $post_id );
		$data['gutes_data'] = json_decode( $data['gutes_data'] );

		if ( ! $is_gutes ) {
			return new \WP_Error( 'Not Gutes', __( 'Not Created Using Gutenberg', 'gutes-array' ), [ 'post_id' => $post_id ] );
		}

		$return = [
			'post_id' => $post_id,
			'save' => $this->save_editor_db( $post_id, $data['gutes_data'], $data['is_in_preview'] ),
		];

		return new \WP_REST_Response( $return );

	}

	/**
	 * GET Callback
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_editor_data( \WP_REST_Request $request ) {

		if ( ! function_exists( 'has_blocks' ) ) {
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
			'data' => ( $gutes_row = $this->get_editor_db( $post_id ) ) ? json_decode( $gutes_row->gutes_array ) : false,
		];

		if ( isset( $data['_embed'] ) ) {
			$return['_embedded'] = [
				'post' => $this->get_embedded_post( $post_id ),
			];
		}

		return new \WP_REST_Response( $return );

	}

	/**
	 * Is post using Gutes?
	 *
	 * @param $post_id
	 *
	 * @return bool
	 */
	private function is_gutes( $post_id ) {
		$post = get_post( $post_id );
		// If new post, new content will exist.
		if ( empty( $post->post_content ) ) {
			return true;
		}
		return has_blocks( $post->post_content );
	}

	/**
	 * Get Embedded post
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	private function get_embedded_post( $post_id ) {
		$request = new \WP_REST_Request( 'GET', '/wp/v2/posts' );
		$request->set_query_params( [ 'per_page' => 12 ] );
		$response = rest_do_request( $request );
		$server = rest_get_server();
		return $server->response_to_data( $response, false );
	}

	/**
	 * Get table name
	 *
	 * @param $is_in_preview
	 *
	 * @return string
	 */
	private function get_table_name( $is_in_preview = false ) {
		if ( $is_in_preview == "true" ) {
			return "gutes_arrays_preview";
		}

		return "gutes_arrays";
	}

	/**
	 * Check if row exists
	 *
	 * @param $existing_row
	 *
	 * @return boolean
	 */
	function row_exists( $existing_row ) {
		return is_object( $existing_row ) || $existing_row->id;
	}


	/**
	 * Get Gutes Data from DB.
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function get_editor_db( $post_id, $is_in_preview = false, $force_preview = true ) {
		global $wpdb;

		$table_name = $wpdb->prefix . $this->get_table_name( $is_in_preview );
		$table_name_preview = $wpdb->prefix . $this->get_table_name( true );
		$existing_preview_row = $wpdb->get_row( "SELECT * FROM $table_name_preview WHERE post_id = $post_id" );

		if ( $this->row_exists( $existing_preview_row && $is_in_preview == "false" ) ) {
			return $existing_preview_row;
		}

		// check if preview table exists, if not it should go back to basic
		// this behavior is not wanted if the preview data should get set
		if ( ! $this->row_exists( $existing_preview_row ) && $is_in_preview == "true" && ! $force_preview ) {
			$table_name = $wpdb->prefix . $this->get_table_name();
		}

		$post_id = (int) $post_id;
		return $wpdb->get_row( "SELECT * FROM $table_name WHERE post_id = $post_id" );
	}

	/**
	 * Save Gutes Data to DB.
	 *
	 * @param $post_id
	 * @param $gutes_data
	 * @param $is_in_preview
	 *
	 * @return mixed
	 */
	private function save_editor_db( $post_id, $gutes_data, $is_in_preview ) {
		global $wpdb;

		$table_name = $wpdb->prefix . $this->get_table_name( $is_in_preview );
		$gutes_data_string = wp_json_encode( $gutes_data );
		$existing_row = $this->get_editor_db( $post_id, $is_in_preview );

		// should delete preview row if this post is saving
		if ( $is_in_preview == "false" ) {
			$table_name_preview = $wpdb->prefix . $this->get_table_name( true );
			$delete =  $wpdb->query( $wpdb->prepare(
					"DELETE FROM $table_name_preview WHERE post_id = %d",
					[
						$post_id
					]
			));

			if ( ! $delete ) {
				$wpdb->print_error();
			}
		}

		if ( ! $this->row_exists( $existing_row ) ) {
			$insert =  $wpdb->query( $wpdb->prepare(
					"INSERT INTO $table_name SET post_id = %d, gutes_array = '%s'",
					[
						$post_id,
						$gutes_data_string
					]
			));
			if ( false === $insert ) {
				$wpdb->print_error();
			}
			return $insert;
		}
		$existing_row->id = (int) $existing_row->id;
		$update = $wpdb->query( $wpdb->prepare(
			"UPDATE $table_name SET gutes_array = '%s' WHERE id = %d",
			[
				$gutes_data_string,
				$existing_row->id
			]
		));
		if ( false === $update ) {
			$wpdb->print_error();
		}
		return $update;
	}

	/**
	 * Get Gutes data from revision.
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_REST_Request
	 */
	public function get_revision_data( \WP_REST_Request $request ) {

		if ( ! function_exists( 'parse_blocks' ) ) {
			return new \WP_Error( 'no gutes', __( 'No Gutes do_blocks' ) );
		}

		$data = $request->get_params();
		$post_id = $data['id'];

		$data['revisions'] = wp_get_post_revisions( $post_id );

		foreach( $data['revisions'] as $key => $value ) {
			$data['revisions'][$key]->editor_blocks = parse_blocks( $value->post_content );
		}


		return new \WP_REST_Response( $data );
	}

}
