<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Allout_Travel
 */

?>
		</div></div><footer id="colophon" class="site-footer">
		<div class="container">
            <div class="footer-content-wrapper"> <?php // Optional wrapper for multiple footer sections ?>

                <?php // Placeholder for Social Media Links - you can hardcode or use a widget/menu later ?>
                <div class="footer-social-links">
                    <ul>
                        <?php // Replace # with your actual social media URLs ?>
                        <li><a href="#" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Facebook', 'allout-travel'); ?></a></li>
                        <li><a href="#" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Instagram', 'allout-travel'); ?></a></li>
                        <li><a href="https://www.youtube.com/yourchannel" target="_blank" rel="noopener noreferrer"><?php esc_html_e('YouTube', 'allout-travel'); ?></a></li> <?php // Replace with your YouTube channel URL ?>
                        <li><a href="#" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Twitter', 'allout-travel'); ?></a></li>
                        <?php // You can add more or use SVG icons here eventually ?>
                    </ul>
                </div>

                <?php if ( has_nav_menu( 'footer' ) ) : ?>
                    <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'allout-travel' ); ?>">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer', // Matches location registered in functions.php
                                'menu_class'     => 'footer-menu',
                                'depth'          => 1, // Only top-level items for footer menu
                                'fallback_cb'    => false, // Don't display anything if menu not set
                            )
                        );
                        ?>
                    </nav><?php endif; ?>

              </div></div></footer></div><?php wp_footer(); // Critical WordPress hook - loads scripts, admin bar, and other footer elements ?>

</body>
</html>