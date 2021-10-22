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

                    <div class="entry-content text-center">

                        <?php the_content(); ?>

                        <?php //jawn_game_form(); ?>

                        <?php
                        $show_form = true;
                        $exclude = array();
                        $post = 'new';
                        $redirect = '';

                        if ($_GET['game'] == 'over') {
                            $show_form = false;

                            $post_id = AF()->submission['post'];
                            if ($post_id) {
                                update_field('game_state', 'complete', $post_id);
                            }
                            ?>

                            <p>Good game, bitch.</p>

                            <p>Game ID: <?php echo $post_id; ?></p>

                            <?php //jg_display_group_game_data();

                        } elseif (!AF()->submission) { // choose sport

                            $exclude = array(
                                // 'game_state',
                                'players',
                                'winners'
                            );
                            $submit = __("Choose players");

                        } else {

                            $post = AF()->submission['post'];
                            $players = af_get_field('players');
                            $group_sport = af_get_field('group_sport');

                            if ( $group_sport ) { // choose teams

                                $exclude = array(
                                    // 'game_state',
                                    'group_sport',
                                    'winners',
                                    // 'bonus_points'
                                );
                                $submit = __("Start game");

                            } elseif ( $players ) { // keep score

                                $exclude = array(
                                    // 'game_state',
                                    'group_sport',
                                    'players',
                                );
                                $submit = __("End game");
                                $redirect = '?game=over';

                            } else { // Edit everything

                                $submit = __("Save changes");

                            }
                        }

                        $args = array(
                            'post' => $post,
                            'submit_text' => $submit,
                            'redirect' => $redirect,
                            'exclude_fields' => $exclude,
                        );

                        if ($show_form) {
                            advanced_form('form_615f415f11785', $args);
                        }
                        ?>

                        <?php
                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
                                'after'  => '</div>',
                            )
                        );
                        ?>

                    </div><!-- .entry-content -->

                    <footer class="entry-footer">

                        <?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

                    </footer><!-- .entry-footer -->

                    </article><!-- #post-## -->
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
