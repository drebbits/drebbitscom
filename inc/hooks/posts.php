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
function invalidate_varnish_cache( $post_id ) {
	$status_single = wp_remote_request( esc_url( get_permalink( $post_id ) ), array( 'method' => 'PURGE' ) );
	$status_home   = wp_remote_request( get_bloginfo( 'url' ), array( 'method' => 'PURGE' ) );
	// Maybe use $status for logging later.
}
add_action( 'save_post', __NAMESPACE__ . '\invalidate_varnish_cache' );
