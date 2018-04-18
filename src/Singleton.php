<?php

namespace GutenbergArray;


trait Singleton {
	/**
	 * The Object instance
	 *
	 * @var mixed
	 */
	public static $instance;

	/**
	 * Init - create or return object
	 *
	 * @param integer $post the WP post ID.
	 *
	 * @return mixed
	 */
	public static function init( $post = null ) {
		if ( null === self::$instance ) {
			self::$instance = new static( $post );
		}

		return self::$instance;
	}
}