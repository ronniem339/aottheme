<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Allout_Travel
 */

get_header(); // Loads header.php
?>

	<main id="primary" class="site-main search-results-main">

		<?php if ( have_posts() ) : // Check if there are any posts matching the search query ?>

			<header class="page-header">
				<h1 class="page-title entry-title-archive">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'allout-travel' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><div class="posts-grid posts-grid-section"> <?php // Using classes from style.css for grid layout ?>
				<?php
				/* Start the Loop */
				while ( have_posts() ) : // Loop through each post found
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('post-grid-item'); ?>>
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="featured-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('allouttravel-post-grid-thumbnail'); ?>
								</a>
							</div>
						<?php endif; ?>

						<header class="entry-header">
							<?php
							the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
							?>
							<?php if ( 'post' === get_post_type() ) : ?>
							<div class="entry-meta">
								<span class="posted-on"><?php printf( esc_html__( '%s', 'allout-travel' ), get_the_date() ); ?></span>
							</div><?php endif; ?>
						</header><div class="entry-excerpt">
							<?php the_excerpt(); // Display the post excerpt ?>
						</div></article><?php
				endwhile; // End of the loop.
				?>
			</div><?php
			the_posts_navigation( // Display pagination if more than one page of search results
				array(
					'prev_text' => esc_html__( '&laquo; Older results', 'allout-travel' ),
					'next_text' => esc_html__( 'Newer results &raquo;', 'allout-travel' ),
				)
			);

		else : // If no posts are found matching the search query

			?>
			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title entry-title-archive"><?php esc_html_e( 'Nothing Found', 'allout-travel' ); ?></h1>
				</header><div class="page-content">
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'allout-travel' ); ?></p>
					<?php get_search_form(); // Display the search form again ?>
				</div></section><?php
		endif; // End of have_posts() check
		?>

	</main><?php
get_footer(); // Loads footer.php
?>