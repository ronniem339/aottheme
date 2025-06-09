<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Allout_Travel
 */

get_header(); // Loads header.php
?>

	<main id="primary" class="site-main error-404-main">

		<section class="error-404 not-found text-center"> <?php // Added text-center class for centering content ?>
			<header class="page-header">
				<h1 class="page-title entry-title-archive"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'allout-travel' ); ?></h1>
			</header><div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'allout-travel' ); ?></p>

				<?php get_search_form(); // Display the search form ?>

				<div class="error-404-links" style="margin-top: 30px;">
					<h2 class="section-title" style="font-size: 1.5em;"><?php esc_html_e( 'Or try these helpful links:', 'allout-travel' ); ?></h2>
					<ul style="list-style: none; padding: 0;">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go to the Homepage', 'allout-travel' ); ?></a></li>
						<?php // You can add more links here, e.g., to your blog page or sitemap ?>
						<?php
							// Example: Link to blog page if a static front page is used
							$blog_page_url = get_permalink( get_option( 'page_for_posts' ) );
							if ( $blog_page_url ) {
								echo '<li><a href="' . esc_url( $blog_page_url ) . '">' . esc_html__( 'Visit Our Blog', 'allout-travel' ) . '</a></li>';
							}
						?>
					</ul>
				</div>

				<?php
				// Optional: Display recent posts as another way to help users find content
				/*
				$allouttravel_recent_posts_args = array(
					'posts_per_page' => 3,
					'post_status'    => 'publish',
					'ignore_sticky_posts' => 1,
					'no_found_rows' => true,
				);
				$allouttravel_recent_posts = new WP_Query( $allouttravel_recent_posts_args );

				if ( $allouttravel_recent_posts->have_posts() ) :
					echo '<div class="recent-posts-404" style="margin-top: 40px;">';
					echo '<h2 class="section-title" style="font-size: 1.5em;">' . esc_html__( 'Maybe check out our latest posts?', 'allout-travel' ) . '</h2>';
					echo '<ul style="list-style: none; padding: 0;">';
					while ( $allouttravel_recent_posts->have_posts() ) : $allouttravel_recent_posts->the_post();
						echo '<li><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></li>';
					endwhile;
					echo '</ul>';
					echo '</div>';
					wp_reset_postdata();
				endif;
				*/
				?>

			</div></section></main><?php
get_footer(); // Loads footer.php
?>let'