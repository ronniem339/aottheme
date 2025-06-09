<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Allout_Travel
 */

get_header(); // Loads header.php
?>

	<main id="main" class="site-main single-post">

		<?php
		// Start the WordPress Loop
		while ( have_posts() ) :
			the_post(); // Sets up the current post data
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    $featured_image_url = get_the_post_thumbnail_url( get_the_ID(), 'allouttravel-hero-image' ); // Get URL of large image
    // Fallback to a default color if no featured image exists
    $header_style = $featured_image_url ? 'style="background-image: url(' . esc_url($featured_image_url) . ');"' : 'style="background-color: #333;"';
    ?>
    <header class="single-post-hero" <?php echo $header_style; ?>>
        <div class="single-post-hero-overlay"></div>
        <div class="single-post-hero-content container">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            <div class="entry-meta">
                <span class="posted-on"><?php echo esc_html( get_the_date() ); ?></span>
            </div></div>
    </header><div class="entry-content">
        <div class="container"> 
					<?php
					the_content( // Display the full post content
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="sr-only"> "%s"</span>', 'allout-travel' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post( get_the_title() )
						)
					);

					wp_link_pages( // For posts split into multiple pages (using tag)
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'allout-travel' ),
							'after'  => '</div>',
						)
					);
					?>
				</div><footer class="entry-footer">
					<?php if ( has_tag() ) : // Check if the post has tags ?>
						<span class="tags-links"><?php esc_html_e( 'Tagged: ', 'allout-travel' ); ?><?php the_tags( '', ', ', '' ); // Display tags, separated by commas ?></span>
					<?php endif; ?>
				</footer></article><?php // Author Bio Section ?>
			<?php if ( get_the_author_meta( 'description' ) ) : // Only display if author has a description ?>
				<div class="author-bio">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), 90 ); // Display author avatar, 90px size ?>
					</div>
					<div class="author-bio-content">
						<h3 class="author-title"><?php printf( esc_html__( 'About %s', 'allout-travel' ), esc_html( get_the_author() ) ); ?></h3>
						<p class="author-description"><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
						<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
							<?php printf( esc_html__( 'View all posts by %s', 'allout-travel' ), esc_html( get_the_author() ) ); ?>
						</a>
					</div>
				</div>
			<?php endif; ?>


			<?php // Related Posts Section ?>
			<?php
			$allouttravel_related_args = array(
				'post_type'      => 'post',
				'posts_per_page' => 3, // Number of related posts to show
				'post__not_in'   => array( get_the_ID() ), // Exclude the current post
				'no_found_rows'  => true, // Optimization
				// Make it more relevant: posts from the same category
				'category__in'   => wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) ),
			);
			$allouttravel_related_query = new WP_Query( $allouttravel_related_args );

			if ( $allouttravel_related_query->have_posts() ) :
			?>
				<section class="related-posts">
    <div class="container">
        <h2 class="related-posts-title section-title"><?php esc_html_e( 'You Might Also Like', 'allout-travel' ); ?></h2>
        
        <div class="related-posts-list">
            <?php
            // The related posts query remains the same
            $allouttravel_related_args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post__not_in'   => array( get_the_ID() ),
                'no_found_rows'  => true,
                'category__in'   => wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) ),
            );
            $allouttravel_related_query = new WP_Query( $allouttravel_related_args );

            if ( $allouttravel_related_query->have_posts() ) :
                while ( $allouttravel_related_query->have_posts() ) : $allouttravel_related_query->the_post();
            ?>
                    <div class="related-post-list-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="related-post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php // Use the better-sized post grid thumbnail
                                    the_post_thumbnail('allouttravel-post-grid-thumbnail');
                                    ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="related-post-content">
                            <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
                            <div class="entry-excerpt">
                                <?php
                                // Create a custom, clean excerpt to avoid plugin-injected buttons
                                $excerpt = get_the_content(); // Get raw content
                                $excerpt = strip_tags($excerpt); // Remove HTML tags
                                $excerpt = strip_shortcodes($excerpt); // Remove shortcodes
                                echo '<p>' . esc_html( wp_trim_words( $excerpt, 44, '...' ) ) . '</p>'; // Trim to 44 words
                                ?>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div></div></section><?php
			endif;
			wp_reset_postdata(); // Important: Reset post data after a custom WP_Query
			?>

			<?php
			// If comments are open or there is at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template(); // This will load comments.php if it exists, or the default WordPress comments.
			endif;
			?>

		<?php
		endwhile; // End of the loop.
		?>

	</main><?php
get_footer(); // Loads footer.php
?>