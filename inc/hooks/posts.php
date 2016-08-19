<?php
/**
 * Hooks/Functions for posts/pages
 *
 * @package dbx
 */

namespace dbx\post;

/**
 * Purge Varnish cache on save
 *
 * @param int $post_id Post ID.
 */
function save_post( $post_id ) {
	$status = wp_remote_request( esc_url( get_permalink( $post_id ) ), array( 'method' => 'PURGE' ) );
	// Maybe use $status for logging later.
}
add_action( 'save_post', __NAMESPACE__ . '\save_post' );
