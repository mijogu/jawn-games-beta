<?php
/**
 * The template for displaying the New Game page
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if (!is_user_logged_in()) {
    wp_redirect('/login/');
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

                <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                    <header class="entry-header">

                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                    </header><!-- .entry-header -->

                    <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

                    <div class="entry-content">

                        <?php the_content(); ?>

                        <?php //jawn_game_form(); ?>

                        <?php
                        // get user's active league
                        $values = array();
                        $redirect = '';
                        $exclude = array('leagues');
                        $submit = __("Update profile");
                        $args = array(
                            'submit_text' => $submit,
                            'redirect' => $redirect,
                            'exclude_fields' => $exclude,
                            'values' => $values,
                            'user' => 'current'
                        );
                        advanced_form('form_616f2ecbd3e3c', $args);


                        ?>
                        <div class="mt-5 text-center">
                            <a class="btn btn-secondary mr-3" href="/join-league">Join a league</a>
                            <a class="btn btn-secondary" href="/new-league">Start a new League</a>
                        </div>

                    </div><!-- .entry-content -->

                    <footer class="entry-footer">

                        <?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

                    </footer><!-- .entry-footer -->

                    </article><!-- #post-## -->

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
