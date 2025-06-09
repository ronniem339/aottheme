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
    define( 'ALLOUTTRAVEL_YOUTUBE_API_KEY', 'AIzaSyDoBEGGsF5Ag6NhJpJe0EsHAKiop9_sUX0' ); // <<< REPLACE THIS!!!
}
if ( ! defined( 'ALLOUTTRAVEL_YOUTUBE_CHANNEL_ID' ) ) {
    define( 'ALLOUTTRAVEL_YOUTUBE_CHANNEL_ID', 'UC-F6waR5jKim-64ZuL1raPg' ); // Your Channel ID
}
// ### END YOUTUBE API KEY AND CHANNEL ID ###

// --- DEBUGGING VERSION of YouTube Function ---
// This function will stop the page from loading and print the raw server response.
function allouttravel_fetch_youtube_videos( $count = 6 ) {
    // Double-check the key is set.
    if ( ! ALLOUTTRAVEL_YOUTUBE_API_KEY || ALLOUTTRAVEL_YOUTUBE_API_KEY === 'YOUR_NEW_SECURE_YOUTUBE_API_KEY_HERE' ) {
        wp_die('DEBUGGING MESSAGE: The YouTube API Key is missing or is still the placeholder text. Please set your new, secure key in the constant in functions.php');
    }

    // We are NOT using transients for this debug version, to force a live API call every time.

    $api_key = ALLOUTTRAVEL_YOUTUBE_API_KEY;
    $channel_id = ALLOUTTRAVEL_YOUTUBE_CHANNEL_ID;
    $uploads_playlist_id = 'UU' . substr($channel_id, 2);

    // API URL to get the video IDs from the uploads playlist
    $playlist_api_url = sprintf(
        'https://www.googleapis.com/youtube/v3/playlistItems?key=%s&playlistId=%s&part=snippet&maxResults=%d&order=date',
        urlencode( $api_key ),
        urlencode( $uploads_playlist_id ),
        15 // Fetch a few for testing
    );

    echo "DEBUG: Attempting to call the following URL:<br>";
    echo esc_url($playlist_api_url);
    echo "<br><br>";
    echo "DEBUG: The raw server response is:<br>";

    // Make the API call
    $playlist_response = wp_remote_get( $playlist_api_url, array('timeout' => 20) ); // Increased timeout for safety

    // Use var_dump() and wp_die() to stop execution and print the raw response
    var_dump($playlist_response);

    wp_die( '--- END OF DEBUG ---<br>Please copy everything from the first DEBUG message to this point and send it back.' );

    // The function will stop above this line. The code below is ignored during this test.
    return false;
}





/**
 * Helper function to clear the YouTube videos transient cache for testing.
 * To use: visit yoursite.com?clear_allouttravel_yt_cache=true while logged in as an admin.
 */
function allouttravel_clear_youtube_transient_action() {
    // Check if the user has permission and if the specific query parameter is set
    if ( isset( $_GET['clear_allouttravel_yt_cache'] ) && current_user_can( 'manage_options' ) ) {
        // Delete the specific transient we are using
        if ( delete_transient( 'allouttravel_youtube_videos_v3_nonshorts' ) ) {
            wp_die( 'Allout Travel YouTube videos cache (transient) has been cleared successfully.' );
        } else {
            wp_die( 'Allout Travel YouTube videos cache (transient) was not found or already cleared.' );
        }
    }
}
add_action( 'init', 'allouttravel_clear_youtube_transient_action' );

?>