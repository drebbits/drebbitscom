<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package drebbits
 */

?>

	</div><!-- .-inner-wrap -->
</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="site-info">
		&copy; Dreb Bits. <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'drebbits' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'drebbits' ), 'WordPress' ); ?></a>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
