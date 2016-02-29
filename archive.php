<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package drebbits
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					printf( wp_kses_post( __( '<span class="archive-label">Category</span><h1 class="page-title">%s</h1>' ) ), single_cat_title( '', false ) );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				if ( ! get_post_format() ) :
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content-excerpt' );
				else :
					get_template_part( 'template-parts/content' );
				endif;

			endwhile; ?>

			<nav class="pagination" role="navigation">
				<?php echo wp_kses_post( paginate_links( array( 'type' => 'list' ) ) ); ?>
			</nav><!-- .navigation -->

		<?php
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
