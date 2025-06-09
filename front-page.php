<?php
/**
 * The template for displaying the custom homepage.
 *
 * @package Allout_Travel
 */

get_header(); // Loads header.php
?>

<main id="main" class="site-main front-page-main">

    <?php // === INTRO TEXT SECTION === ?>
    <section class="intro-text-section text-center">
        <div class="container">
            <p class="intro-text">
                <?php echo esc_html_e( 'Tired of the same old tourist traps? This is your passport to extraordinary experiences and hidden gems around the globe. We’re all about ditching the crowds, embracing the unexpected, and discovering luxury that won’t break the bank. Get ready to explore more and elevate your travel game!', 'allout-travel' ); ?>
            </p>
        </div>
    </section>

    <?php // === LATEST POST FEATURE SECTION === ?>
    <section class="latest-post-feature-section">
        <div class="container">
            <?php
            $latest_post_args = array(
                'post_type'           => 'post',
                'posts_per_page'      => 1, // Only fetch the single latest post
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1, // You might want to set this to 0 if you use sticky posts for this spot
            );
            $latest_post_query = new WP_Query( $latest_post_args );

            if ( $latest_post_query->have_posts() ) :
                while ( $latest_post_query->have_posts() ) :
                    $latest_post_query->the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('featured-latest-post'); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-latest-post-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('allouttravel-hero-image'); // Using the large hero image size ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="featured-latest-post-content">
                            <header class="entry-header">
                                <?php the_title( sprintf( '<h2 class="entry-title section-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                               <div class="entry-meta">
    <span class="posted-on"><?php echo esc_html( get_the_date() ); ?></span>
</div></header><div class="entry-summary">
                                <?php
                                // Create a longer excerpt
                                $excerpt_length = 150; // Number of words for the longer excerpt
                                $post_content = get_the_content(null, false, get_the_ID()); // Get raw content
                                $trimmed_content = wp_trim_words( strip_shortcodes( strip_tags( $post_content ) ), $excerpt_length, '...' );
                                echo '<p>' . esc_html( $trimmed_content ) . '</p>';
                                ?>
                                <a href="<?php the_permalink(); ?>" class="read-more button-secondary"><?php esc_html_e( 'Continue Reading &rarr;', 'allout-travel' ); ?></a>
                            </div></div></article><?php
                endwhile;
                wp_reset_postdata(); // Important: Reset post data after a custom WP_Query
            else :
                ?>
                <p class="text-center"><?php esc_html_e( 'No recent posts available to feature.', 'allout-travel' ); ?></p>
                <?php
            endif;
            ?>
        </div>
    </section>

    <?php // === FEATURED YOUTUBE VIDEOS SECTION (DYNAMIC) === ?>
    <section id="featured-youtube" class="featured-youtube-section text-center">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html_e( 'Latest Adventures on YouTube', 'allout-travel' ); ?></h2>
            <?php
            $latest_videos = allouttravel_fetch_youtube_videos( 6 ); // Fetch 3 latest videos

            if ( ! empty( $latest_videos ) && is_array( $latest_videos ) ) :
            ?>
                <div class="youtube-videos-grid">
                    <?php foreach ( $latest_videos as $video ) : ?>
                        <div class="youtube-video-item">
                            <a href="https://www.youtube.com/watch?v=<?php echo esc_attr( $video['id'] ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $video['title'] ); ?>">
                                <?php if ( ! empty( $video['thumbnail_url'] ) ) : ?>
                                    <img src="<?php echo esc_url( $video['thumbnail_url'] ); ?>" alt="<?php echo esc_attr( $video['title'] ); ?>">
                                <?php else : ?>
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-video-thumb.jpg'); ?>" alt="Default video thumbnail">
                                <?php endif; ?>
                                <div class="youtube-video-item-content">
                                    <h3 class="video-item-title"><?php echo esc_html( wp_trim_words( $video['title'], 10, '...' ) ); ?></h3>
                                    <?php if ( ! empty( $video['published_at'] ) ) : ?>
                                        <div class="video-item-meta">
                                            <span class="posted-on"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $video['published_at'] ) ) ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $video['description'] ) ) : ?>
                                        <div class="video-item-excerpt">
                                            <p><?php echo esc_html( wp_trim_words( $video['description'], 15, '...' ) ); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ( defined('ALLOUTTRAVEL_YOUTUBE_API_KEY') && (ALLOUTTRAVEL_YOUTUBE_API_KEY === 'YOUR_NEW_SECURE_YOUTUBE_API_KEY_HERE' || !ALLOUTTRAVEL_YOUTUBE_API_KEY )) : ?>
                <p><?php esc_html_e( 'Please set up your YouTube API Key correctly in functions.php to display videos.', 'allout-travel' ); ?></p>
            <?php else : ?>
                <p><?php esc_html_e( 'No YouTube videos found at the moment, or there was an issue fetching them. Check back soon!', 'allout-travel' ); ?></p>
            <?php endif; ?>

            <p style="margin-top: 30px;">
                <a href="https://www.youtube.com/embed/YOUR_VIDEO_ID_HERE3" class="youtube-channel-link" target="_blank" rel="noopener noreferrer">
                    <?php esc_html_e( 'Watch More & Subscribe to @allout.travel', 'allout-travel' ); ?>
                </a>
            </p>
        </div>
    </section>

    <?php // === RECENT POSTS GRID SECTION === ?>
    <section id="recent-posts-section" class="recent-posts-grid-section posts-grid-section">
        <div class="container">
            <h2 class="section-title text-center"><?php echo esc_html_e( 'More Travel Stories', 'allout-travel' ); // Changed title slightly ?></h2>
            <?php
            // Arguments to fetch posts, EXCLUDING the one already featured above
            $allouttravel_more_posts_args = array(
                'post_type'           => 'post',
                'posts_per_page'      => 6,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'no_found_rows'       => true,
                'post__not_in'        => ( isset($latest_post_query) && $latest_post_query->have_posts() ) ? array($latest_post_query->posts[0]->ID) : array(), // Exclude the latest post
            );
            $allouttravel_more_posts = new WP_Query( $allouttravel_more_posts_args );

            if ( $allouttravel_more_posts->have_posts() ) :
                ?>
                <div class="posts-grid">
                    <?php
                    while ( $allouttravel_more_posts->have_posts() ) :
                        $allouttravel_more_posts->the_post();
                        // Using a template part for the post grid item would be ideal here for DRY principle
                        // For now, we'll repeat the structure.
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-grid-item'); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="featured-image-link">
                                    <div class="featured-image">
                                        <?php the_post_thumbnail('allouttravel-post-grid-thumbnail'); ?>
                                    </div>
                                </a>
                            <?php endif; ?>
                            <div class="entry-header">
                                <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
                               <div class="entry-meta">
    <span class="posted-on"><?php echo esc_html( get_the_date() ); ?></span>
</div>
                            </div>
                            <div class="entry-excerpt">
                                <?php the_excerpt(); // This will use the 20-word excerpt from functions.php ?>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div><?php
                wp_reset_postdata();
            else :
                ?>
                <p class="text-center"><?php esc_html_e( 'No more posts found.', 'allout-travel' ); ?></p>
                <?php
            endif;
            ?>
        </div>
    </section>

</main><?php
get_footer();
?>