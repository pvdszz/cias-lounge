<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>


    <div id="primary" class="content-area">
		<div class="cias-page-sidebar" style="">
			<?php if ( is_active_sidebar( 'page_sidebar' ) ) : ?>
            <?php dynamic_sidebar( 'page_sidebar' ); ?>
            <?php endif; ?>
		</div>
		<div class="cias-page-content" style="">
			<div class="header-navigation-wrapper">

				<?php
				if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
					?>

				<nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'twentytwenty' ); ?>"
					role="navigation">

					<ul class="primary-menu reset-list-style">

						<?php
				if ( has_nav_menu( 'primary' ) ) {

					wp_nav_menu(
						array(
							'container'  => '',
							'items_wrap' => '%3$s',
							'theme_location' => 'primary',
						)
					);

				} elseif ( ! has_nav_menu( 'expanded' ) ) {

					wp_list_pages(
						array(
							'match_menu_classes' => true,
							'show_sub_menu_icons' => true,
							'title_li' => false,
							'walker'   => new TwentyTwenty_Walker_Page(),
						)
					);

				}
				?>

					</ul>

				</nav><!-- .primary-menu-wrapper -->

				<?php
				}

				if ( true === $enable_header_search || has_nav_menu( 'expanded' ) ) {
					?>

				<div class="header-toggles hide-no-js">

					<?php
				if ( has_nav_menu( 'expanded' ) ) {
					?>

					<div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">

						<button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal"
							data-toggle-body-class="showing-menu-modal" aria-expanded="false"
							data-set-focus=".close-nav-toggle">
							<span class="toggle-inner">
								<span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span>
								<span class="toggle-icon">
									<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
								</span>
							</span>
						</button><!-- .nav-toggle -->

					</div><!-- .nav-toggle-wrapper -->

					<?php
				}

				if ( true === $enable_header_search ) {
					?>

					<div class="toggle-wrapper search-toggle-wrapper">

						<button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal"
							data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field"
							aria-expanded="false">
							<span class="toggle-inner">
								<?php twentytwenty_the_theme_svg( 'search' ); ?>
								<span class="toggle-text"><?php _e( 'Search', 'twentytwenty' ); ?></span>
							</span>
						</button><!-- .search-toggle -->

					</div>

					<?php
					}
					?>

					</div><!-- .header-toggles -->
					<?php
				}
				?>

			</div><!-- .header-navigation-wrapper -->
			<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End the loop.
			?>

			</main><!-- #main -->
		</div>
        
    </div><!-- #primary -->

<?php
get_footer();