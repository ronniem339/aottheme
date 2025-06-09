<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Allout_Travel
 */

get_header(); // Loads header.php
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : // Check if there are posts in this archive ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title entry-title-archive">', '</h1>' ); // Displays the archive title (e.g., "Category: Travel Tips")
				the_archive_description( '<div class="archive-description">', '</div>' ); // Displays the archive description (if set for categories/tags)
				?>
			</header><div class="posts-grid posts-grid-section"> <?php // Using classes from style.css for grid layout ?>
				<?php
				/* Start the Loop */
				while ( have_posts() ) : // Loop through each post in the archive
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('post-grid-item'); ?>>
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="featured-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('allouttravel-post-grid-thumbnail'); // Use our custom grid thumbnail size ?>
								</a>
							</div>
						<?php endif; ?>

						<header class="entry-header">
							<?php
							the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
							?>
							<?php if ( 'post' === get_post_type() ) : // You might want simpler meta on archives ?>
							<div class="entry-meta">
    <span class="posted-on"><?php echo esc_html( get_the_date() ); ?></span>
</div><?php endif; ?>
						</header><div class="entry-excerpt">
							<?php the_excerpt(); // Display the post excerpt ?>
						</div></article><?php
				endwhile; // End of the loop.
				?>
			</div><?php
			the_posts_navigation( // Display pagination
				array(
					'prev_text' => esc_html__( '&laquo; Older posts', 'allout-travel' ),
					'next_text' => esc_html__( 'Newer posts &raquo;', 'allout-travel' ),
				)
			);

		else : // If no posts are found in this archive

			// We'll include a "No posts found" message.
			// You could create a template-parts/content-none.php for this to keep it DRY.
			?>
			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title entry-title-archive"><?php esc_html_e( 'Nothing Found', 'allout-travel' ); ?></h1>
				</header><div class="page-content">
					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for in this archive. Perhaps searching can help.', 'allout-travel' ); ?></p>
					<?php get_search_form(); // Display the search form ?>
				</div></section><?php
		endif; // End of have_posts() check
		?>

	</main><?php
get_footer(); // Loads footer.php
?>