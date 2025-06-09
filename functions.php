<?php
/**
 * Allout Travel functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Allout_Travel
 */

if ( ! defined( 'ALLOUTTRAVEL_VERSION' ) ) {
	define( 'ALLOUTTRAVEL_VERSION', '1.0.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function allouttravel_setup() {
	load_theme_textdomain( 'allout-travel', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800, 600, true );
	add_image_size( 'allouttravel-hero-image', 1920, 1080, true );
	add_image_size( 'allouttravel-post-grid-thumbnail', 400, 250, true );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'allout-travel' ),
			'footer'  => esc_html__( 'Footer Menu', 'allout-travel' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'allouttravel_setup' );

/**
 * Enqueue scripts and styles.
 */
function allouttravel_scripts() {
	wp_enqueue_style( 'allouttravel-google-fonts', 'https://fonts.googleapis.com/css2?family=Archivo+Black&family=Montserrat:wght@400;700&display=swap', array(), null );
	wp_enqueue_style( 'allouttravel-style', get_stylesheet_uri(), array(), ALLOUTTRAVEL_VERSION );
	wp_enqueue_script( 'allouttravel-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), ALLOUTTRAVEL_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'allouttravel_scripts' );

/**
 * Custom excerpt length.
 */
function allouttravel_custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'allouttravel_custom_excerpt_length', 999 );

/**
 * Custom excerpt more string.
 */
function allouttravel_custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'allouttravel_custom_excerpt_more' );

// ### YOUTUBE API KEY AND CHANNEL ID CONSTANTS ###
// IMPORTANT: Replace the placeholder value with your new, secure API key.
// Storing keys in wp-config.php is recommended for live sites.
if ( ! defined( 'ALLOUTTRAVEL_YOUTUBE_API_KEY' ) ) {
    define( 'ALLOUTTRAVEL_YOUTUBE_API_KEY', '' ); // <<< REPLACE THIS!!!
}
if ( ! defined( 'ALLOUTTRAVEL_YOUTUBE_CHANNEL_ID' ) ) {
    define( 'ALLOUTTRAVEL_YOUTUBE_CHANNEL_ID', 'UC-F6waR5jKim-64ZuL1raPg' ); // Your Channel ID
}
// ### END YOUTUBE API KEY AND CHANNEL ID ###

/**
 * FINAL VERSION: Fetch latest NON-SHORT YouTube videos for a channel.
 */
function allouttravel_fetch_youtube_videos( $count = 6 ) {
    // Return early if the key is not set.
    if ( ! ALLOUTTRAVEL_YOUTUBE_API_KEY || ALLOUTTRAVEL_YOUTUBE_API_KEY === 'YOUR_NEW_SECURE_YOUTUBE_API_KEY_HERE' ) {
        error_log('YouTube API Key is not configured in functions.php');
        return array();
    }

    // Use a new transient name to ensure we get fresh data after this update.
    $transient_name = 'allouttravel_youtube_videos_v4_final';
    $cached_videos = get_transient( $transient_name );
    if ( false !== $cached_videos ) {
        return $cached_videos;
    }

    $api_key = ALLOUTTRAVEL_YOUTUBE_API_KEY;
    $channel_id = ALLOUTTRAVEL_YOUTUBE_CHANNEL_ID;
    $max_results_to_fetch = intval( $count ) + 50; // Fetch more to account for filtering Shorts.
    $uploads_playlist_id = 'UU' . substr($channel_id, 2);

    // Step 1: Get latest video IDs from the channel's uploads playlist.
    $playlist_api_url = sprintf(
        'https://www.googleapis.com/youtube/v3/playlistItems?key=%s&playlistId=%s&part=snippet&maxResults=%d&order=date',
        urlencode( $api_key ),
        urlencode( $uploads_playlist_id ),
        $max_results_to_fetch
    );
    $playlist_response = wp_remote_get( $playlist_api_url, array('timeout' => 15) );

    if ( is_wp_error( $playlist_response ) ) {
        error_log( 'YouTube Playlist API call failed: ' . $playlist_response->get_error_message() );
        return array();
    }
    
    $playlist_data = json_decode( wp_remote_retrieve_body( $playlist_response ) );
    if ( empty( $playlist_data->items ) ) {
        return array();
    }

    $video_ids = array_map( function($item) { return $item->snippet->resourceId->videoId; }, $playlist_data->items );
    if ( empty( $video_ids ) ) {
        return array();
    }

    // Step 2: Get the content details (including duration) for each of those videos.
    $videos_api_url = sprintf(
        'https://www.googleapis.com/youtube/v3/videos?key=%s&id=%s&part=snippet,contentDetails',
        urlencode( $api_key ),
        implode( ',', $video_ids )
    );
    $videos_response = wp_remote_get( $videos_api_url, array('timeout' => 15) );
    
    if ( is_wp_error( $videos_response ) ) {
        error_log( 'YouTube Videos API call failed: ' . $videos_response->get_error_message() );
        return array();
    }

    $videos_data = json_decode( wp_remote_retrieve_body( $videos_response ) );
    if ( empty( $videos_data->items ) ) {
        return array();
    }

    // Step 3: Process the final list, now with the Shorts filter re-enabled.
    $videos = array();
    foreach ( $videos_data->items as $item ) {
        // Stop once we have the desired number of videos.
        if ( count($videos) >= intval($count) ) {
            break;
        }

        try {
            $duration_iso = $item->contentDetails->duration;
            $interval = new DateInterval($duration_iso);
            $duration_seconds = $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->d * 86400);
        } catch (Exception $e) {
            $duration_seconds = 0; // Couldn't parse duration, assume it's not a long video.
        }

        // --- THE SHORTS FILTER IS NOW RE-ENABLED ---
        // Only include videos longer than 65 seconds.
        if ( $duration_seconds > 65 ) {
            $videos[] = array(
                'id'            => $item->id,
                'title'         => $item->snippet->title,
                'description'   => $item->snippet->description,
                'thumbnail_url' => isset($item->snippet->thumbnails->high->url) ? $item->snippet->thumbnails->high->url : $item->snippet->thumbnails->default->url, // <<< FIX IS HERE
                'published_at'  => $item->snippet->publishedAt,
            );
        }
    }

    // Cache the final, correct result for 3 hours.
    set_transient( $transient_name, $videos, 3 * HOUR_IN_SECONDS );
    
    return $videos;
}


/**
 * Helper function to clear the YouTube videos transient cache for testing.
 * To use: visit yoursite.com?clear_allouttravel_yt_cache=true while logged in as an admin.
 */
function allouttravel_clear_youtube_transient_action() {
    // Check if the user has permission and if the specific query parameter is set
    if ( isset( $_GET['clear_allouttravel_yt_cache'] ) && current_user_can( 'manage_options' ) ) {
        // Delete the specific transient we are using
        if ( delete_transient( 'allouttravel_youtube_videos_v5_final' ) ) {
            wp_die( 'Allout Travel YouTube videos cache (transient) has been cleared successfully.' );
        } else {
            wp_die( 'Allout Travel YouTube videos cache (transient) was not found or already cleared.' );
        }
    }
}
add_action( 'init', 'allouttravel_clear_youtube_transient_action' );

?>
