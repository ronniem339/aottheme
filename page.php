<?php
/**
 * The template for displaying all static pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#page-display
 *
 * @package Allout_Travel
 */

get_header(); // Loads header.php
?>

	<main id="main" class="site-main page-main">

		<?php
		// Start the WordPress Loop
		while ( have_posts() ) :
			the_post(); // Sets up the current page data
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); // Adds relevant CSS classes to the article tag ?>>
				<header class="entry-header page-header"> <?php // Re-using .page-header for consistent title styling ?>
					<?php the_title( '<h1 class="entry-title page-title entry-title-archive">', '</h1>' ); // Display the page title ?>
				</header><?php if ( has_post_thumbnail() ) : // Check if the page has a Featured Image ?>
					<div class="featured-image-single page-featured-image">
						<?php the_post_thumbnail('large'); // Display the Featured Image ?>
					</div>
				<?php endif; ?>

				<div class="entry-content page-content">
					<?php
					the_content(); // Display the full page content

					wp_link_pages( // For pages split into multiple pages (using tag)
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'allout-travel' ),
							'after'  => '</div>',
						)
					);
					?>
				</div><?php if ( get_edit_post_link() ) : // Display an "Edit" link for logged-in users with permission ?>
					<footer class="entry-footer">
						<?php
						edit_post_link(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Edit <span class="sr-only">%s</span>', 'allout-travel' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								wp_kses_post( get_the_title() )
							),
							'<span class="edit-link">',
							'</span>'
						);
						?>
					</footer><?php endif; ?>
			</article><?php
			// If comments are open or there is at least one comment, load up the comment template.
			// Comments are not typically enabled on pages by default, but can be.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		<?php
		endwhile; // End of the loop.
		?>

	</main><?php
get_footer(); // Loads footer.php
?>