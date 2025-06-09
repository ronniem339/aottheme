<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists and a static front page is not set.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Allout_Travel
 */

get_header(); // Loads the header.php file
?>

	<main id="primary" class="site-main">

		<?php
		// Check if we are on the main blog page (when a static front page is set in Settings > Reading)
		if ( is_home() && ! is_front_page() ) :
			?>
			<header class="page-header">
				<h1 class="page-title entry-title-archive"><?php single_post_title(); // Displays the "Posts" page title ?></h1>
			</header>
		<?php endif; ?>

		<?php if ( have_posts() ) : // Checks if there are any posts to display ?>

			<div class="posts-grid posts-grid-section"> <?php // Using classes from style.css for grid layout ?>
				<?php
				/* Start the Loop */
				while ( have_posts() ) : // Loop through each post
					the_post();
					?>
					<article id="post-<?php the_ID(); // Outputs the post ID ?>" <?php post_class('post-grid-item'); // Outputs post classes and our custom class ?>>
						
						<?php if ( has_post_thumbnail() ) : // Check if the post has a Post Thumbnail (Featured Image) ?>
							<div class="featured-image">
								<a href="<?php the_permalink(); // Get the URL of the post ?>">
									<?php the_post_thumbnail('allouttravel-post-grid-thumbnail'); // Display the Post Thumbnail with our custom size ?>
								</a>
							</div>
						<?php endif; ?>

						<header class="entry-header">
							<?php
							// Display the post title, linked to the post
							the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
							?>

							<?php if ( 'post' === get_post_type() ) : // Check if it's a 'post' type ?>
							<div class="entry-meta">
								<span class="posted-on"><?php printf( esc_html__( 'Posted on %s', 'allout-travel' ), get_the_date() ); ?></span>
								<span class="byline"> <?php printf( esc_html__( 'by %s', 'allout-travel' ), esc_html( get_the_author() ) ); ?></span>
							</div><?php endif; ?>
						</header><div class="entry-excerpt">
							<?php the_excerpt(); // Display the post excerpt ?>
						</div></article><?php
				endwhile; // End of the loop.
				?>
			</div><?php
			// Display pagination if more than one page of posts exists
			the_posts_navigation(
				array(
					'prev_text' => esc_html__( '&laquo; Older posts', 'allout-travel' ),
					'next_text' => esc_html__( 'Newer posts &raquo;', 'allout-travel' ),
				)
			);

		else : // If no posts are found

			// If no content, include a "No posts found" message.
			// We might create a separate template part for this later (template-parts/content-none.php)
			?>
			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title entry-title-archive"><?php esc_html_e( 'Nothing Found', 'allout-travel' ); ?></h1>
				</header><div class="page-content">
					<?php
					if ( is_search() ) : // If it was a search that yielded no results
						?>
						<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'allout-travel' ); ?></p>
						<?php
						get_search_form(); // Display the search form

					else : // If it wasn't a search
						?>
						<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'allout-travel' ); ?></p>
						<?php
						get_search_form(); // Display the search form

					endif;
					?>
				</div></section><?php
		endif; // End of the have_posts() check
		?>

	</main><?php
get_footer(); // Loads the footer.php file
?>