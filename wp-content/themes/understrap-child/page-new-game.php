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
                        $show_form = true;
                        $exclude = array();
                        $values = array();
                        $post = 'new';
                        $redirect = '';

                        // if (AF()->submission)
                        if ($_GET['game'] == 'over') {
                            // $show_form = false;

                            $post_id = AF()->submission['post'];
                            if ($post_id) {
                                update_field('game_state', 'complete', $post_id);
                            }
                            ?>

                            <h2>Good game, bitch.</h2>

                            <p>Game ID: <?php echo $post_id; ?></p>

                            <?php //jg_display_team_game_data();

                        } else { // show New Game form
                            $exclude = array();
                            $submit = __("Save game");
                            $redirect = '?game=over';
                            $args = array(
                                'post' => $post,
                                'submit_text' => $submit,
                                'redirect' => $redirect,
                                'exclude_fields' => $exclude,
                                'values' => $values,
                            );
                            advanced_form('form_615deae16f142', $args);
                        }

                        ?>

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
