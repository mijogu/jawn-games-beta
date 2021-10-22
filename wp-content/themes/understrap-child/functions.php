<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

/**
 * Hide admin bar from non-admins
 */
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

/**
 * Set hidden League field to User's Active League
 */
add_filter('acf/prepare_field/name=league', 'jg_load_league_value');
function jg_load_league_value( $field ) {
    // only do this on frontend form
    if (is_admin()) return $field;

    $active_id = jg_get_user_active_league();
    $field['value'] = $active_id;
    return $field;
}

/**
 * Load / Prefill League field
 *
 * Only fill choices for frontend.
 */
add_filter('acf/load_field/name=active_league', 'jg_load_league_field_choices');
// add_filter('acf/load_field/name=league', 'jg_load_league_field_choices');
function jg_load_league_field_choices( $field ) {
    global $post;
    global $current_user;

    $user_id = $current_user->ID;
    $league_ids = array();
    $force_value = true;
    $active_league = false;
    $field['choices'] = array();

    // if in admin, get author's leagues
    if (is_admin()) {
        if ($post->post_author) {
            $user_id = $post->post_author;
        }
        $force_value = false;
    }

    // get leagues for user in question
    $user_leagues = get_field('leagues', 'user_'.$user_id);

    if ($user_leagues) {
        // get leagues IDs
        $league_ids = array_map(function($league) {
            if ($league['league_id']) return $league['league_id'];
        }, $user_leagues);

        // get Active League
        if ($field['name'] != 'active_league') {
            $active_league = get_field('active_league', 'user_'.$user_id);
        }

        // get only current user's Leagues
        $leagues = get_posts(array(
            'post_type' => 'jg_league',
            'numberposts' => -1,
            'order' => 'ASC',
            'orderby' => 'title',
            'include' => $league_ids,
        ));
    }

    // set Leagues as field choices
    if ($leagues) {
        foreach($leagues as $league) {
            $field['choices'][ $league->ID ] = $league->post_title;
        }
    }

    // prefill selected with value
    // only on frontend
    if ($force_value && $active_league && !$field['value'] && $field['name'] != 'active_league') {
        $field['value'] = $active_league;
    } elseif ($field['name'] != 'active_league' && count($leagues) === 1) {
        $field['value'] = $leagues[0]->ID;
    }

    return $field;
}

// Load Active League players
add_filter('acf/load_field/name=players', 'jg_load_team_field_choices');
function jg_load_team_field_choices( $field ) {
    global $wpdb;

    // get user's active league
    $league_id = jg_get_user_active_league();

    // reset choices
    $field['choices'] = array();

    // get User IDs for all users in League
    $users = jg_get_users_in_league($league_id);

    // loop through array and add to field 'choices'
    if( $users ) {
        foreach( $users as $user ) {
            $field['choices'][ "user_$user->ID" ] = $user->display_name;
        }
    }

    // return the field
    return $field;
}

function jg_get_users_in_league($league_id) {
    global $wpdb;

    // custom sql to get the User IDs
    $sql =
        "SELECT distinct user_id FROM $wpdb->usermeta
        where meta_key like 'leagues_%_league_id'
        and meta_value = $league_id";

    $sql = $wpdb->prepare($sql);
    $user_ids = $wpdb->get_col($sql);

    // get User objects based on list of IDs
    $args = array(
        'include' => $user_ids,
    );
    $users = get_users($args);

    // return User objects
    return $users;
}

add_filter('acf/load_field/name=sport', 'jg_load_sport_field_choices');
function jg_load_sport_field_choices( $field ) {

    // reset choices
    $field['choices'] = array();

    // TODO filter sports to league
    // get sports
    $sports = get_posts(array(
        'post_type' => 'jg_sport',
        'numberposts' => -1,
        'category' => '5', // team
        'order' => 'ASC',
        'orderby' => 'title',
    ));

    // loop through array and add to field 'choices'
    if( $sports ) {
        foreach( $sports as $sport ) {
            $field['choices'][ $sport->ID ] = $sport->post_title;
        }
    }
    // return the field
    return $field;
}

/**
 * Show Win & Score fields in admin
 *
 * Removes the conditional_logic settings used in frontend.
 */
add_action('acf/load_field/name=win', 'jg_show_field_in_admin');
add_action('acf/load_field/name=score', 'jg_show_field_in_admin');
function jg_show_field_in_admin( $field ) {
    global $post;
    if (is_admin() && $post->post_type !== 'acf-field-group') {
        $field['conditional_logic'] = array();
        return $field;
    }
    return $field;
}

// add_filter('acf/pre_submit_form', 'jg_pre_submit_game_form', 10, 1);
// function jg_pre_submit_game_form( $form ) {
//     // Create post using $form['new_post'].
//     // Modify $form['redirect'].
//     if ($form['id'] == 'jawn_new_game') {

//     }

//     return $form;
// }


// function jg_hidden_field( $form, $args ) {
//     // The title can later be retrieved using $_POST['post_title'].
//     if ($args['post'] == 'new') {
//         echo sprintf( '<input type="text" name="next_state" value="%s">', 'in_progress' );
//     } elseif (is_int($args['post'])) {
//         echo sprintf( '<input type="text" name="next_state" value="%s">', 'in_progress' );
//     }
//     // echo $hidden;
// }
// add_action( 'af/form/hidden_fields/key=form_615deae16f142', 'jg_hidden_field', 10, 2 );



// add_filter('acf/prepare_field/name=game_state', 'jg_prepare_game_state_field');
// function jg_prepare_game_state_field( $field ) {
//     // Lock-in the value "Example".
//     if ($field['value'] === 'default' ) {
//         $field['value'] = 'choose_teams';
//     }
//     return $field;
// }


function jg_display_team_game_data() { ?>
    <p>[Team game data]</p>
<?php }

function jg_display_group_game_data() { ?>
    <p>[Group game data]</p>
<?php }


/**
 * Get User's Active League
 *
 * If user doesn't have an Active League
 * Set one.
 */
function jg_get_user_active_league($user_id = null) {
    global $current_user;
    if (!$user_id) $user_id = $current_user->ID;

    $active_league = get_field('active_league', 'user_'.$user_id);

    if ($active_league) return $active_league;

    $leagues = get_field('leagues', 'user_'.$user_id);
    if (!$leagues) return false;

    $new_active_league = $leagues[0]['league_id'];
    update_field('active_league', $new_active_league, 'user_'.$user_id);

    return $new_active_league;
}

/**
 * Get all Games from a League
 */
function jg_get_games_from_league($league_id = null) {
    global $current_user;

     // get User Active League
     if (!$league_id) {
        $league_id = jg_get_user_active_league();
    }

    $games = get_posts(array(
        'post_type' => 'jg_game',
        'numberposts' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'       => 'league',
                'compare'   => '=',
                'value'     => $league_id,
                // 'type'      => 'numeric',
            )
        )
    ));

    return $games;
}

/**
 * Display Scoreboard for Active League
 *
 */
function jg_display_scoreboard($league_id = null) {
    global $wpdb;
    global $current_user;

    // get User Active League
    if (!$league_id) {
        $league_id = jg_get_user_active_league();
    }

    $games = jg_get_games_from_league($league_id);
    // exit;

    // create lookup arrays from games array
    $user_lookup = array();
    $sport_lookup = array();
    $games_by_sport = array();

    foreach($games as $game) {
        $acf = get_fields($game->ID);
        $sport_id = $acf['sport'];
        $sport_name = get_the_title($sport_id) ? get_the_title($sport_id) : "(missing)";

        if (!isset($sport_lookup[$sport_id])) {
            $sport_lookup[$sport_id] = $sport_name;
        }
        $games_by_sport[$sport_id][] = $game;

        // TODO change team_sports to 'sports'

        // add to player lookup
        // loop thru teams
        foreach ($acf['teams'] as $key => $team) {
            // loop thru players
            foreach ($team['players'] as $player) {
                $player_id = str_replace('user_', '', $player);

                // set user's name if not already set
                if (!isset($user_lookup[$player_id]['name'])) {
                    $user_data = get_userdata($player_id);
                    $user_lookup[$player_id]['name'] = $user_data->display_name;
                }

                // add sport to list
                $user_lookup[$player_id]['team_sports'][] = $acf['sport'];

                // add game to list
                $user_lookup[$player_id]['team_games'][] = $game->ID;

                // if won, add to wins
                if ($team['win'] === true) {
                    $user_lookup[$player_id]['team_wins'][] = $game->ID;
                }

                foreach ($acf['teams'][$key]['players'] as $teammate) {
                    // don't add self as teammate
                    if ($player != $teammate) {
                        $user_lookup[$player_id]['team_mates'][] = str_replace('user_', '', $teammate);
                    }
                }
            }
        }

    }

    // Render User Leaderboard
    ?>
    <h2 class="">Leaderboard</h2>
    <table class="table table-striped table-bordered mb-5">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Goofball</th>
                <th scope="col">Sports</th>
                <th scope="col">Mates</th>
                <th scope="col">Games</th>
                <th scope="col">Wins</th>
                <th scope="col">Total Points</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $i = 1;
        foreach($user_lookup as $user) {
            $team_sports = count(array_unique($user['team_sports']));
            $team_mates = count(array_unique($user['team_mates']));
            $team_games = count($user['team_games']);
            $team_wins = count($user['team_wins']);
            $total = $team_sports + $team_mates + $team_games + $team_wins;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <th scope="row"><?php echo $user['name']; ?></th>
                <td><?php echo $team_sports; ?></td>
                <td><?php echo $team_mates; ?></td>
                <td><?php echo $team_games; ?></td>
                <td><?php echo $team_wins; ?></td>
                <td><?php echo $total; ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>

    <?php
    // Render Team Sport tables
    // foreach($games_by_sport as $id => $team_sport) {
    foreach($games_by_sport as $sport_id => $game_list) {
    ?>
    <h2 class=""><?php echo $sport_lookup[$sport_id]; ?></h2>
    <table class="table table-striped table-bordered mb-5">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Game ID</th>
                <th scope="col" colspan="3">Teams</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($game_list as $key => $game) {
            $acf = get_fields($game->ID);
            ?>
            <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $game->ID; ?></td>
            <?php
            foreach ($acf['teams'] as $team) {
                $td_class = $team['win'] ? 'bg-success' : '';
                $score = $team['score'] ? $team['score'] : '';
            ?>
                <td class="<?php echo $td_class; ?>">
                    <?php
                    if ($score) echo $score . '<br>';
                    foreach ($team['players'] as $pkey => $player_id) {
                        echo $pkey > 0 ? '<br>' : '';
                        $player_id = str_replace('user_', '', $player_id);
                        echo $user_lookup[$player_id]['name'];
                    }
                    ?>
                </td>
            <?php } ?>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    }
    /* highlight_string("<?php\n".var_export($user_lookup, true). ";\n?>"); */

    /* highlight_string("<?php\n".var_export($sport_lookup, true). ";\n?>"); */

    /* highlight_string("<?php\n".var_export($team_sport_games, true). ";\n?>"); */

    /* highlight_string("<?php\n".var_export($group_sport_games, true). ";\n?>"); */
    ?>
<?php }



// Add Sport column to Games table
add_filter('manage_jg_game_posts_columns', function($columns) {
	$date = $columns['date'];
    unset($columns['date']);

    $new_columns = array(
        'sport' => 'Sport',
        'team_1' => 'Team 1',
        'team_2' => 'Team 2',
        'date' => $date
    );

    return array_merge($columns, $new_columns);
});
// Add Sport content to Games table
add_action('manage_jg_game_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'sport') { // team sport
		$team_sport_id = get_field('team_sport', $post_id);
		$group_sport_id = get_field('group_sport', $post_id);
        $sport_id = get_field('sport', $post_id);
		if ($team_sport_id) {
			echo get_the_title($team_sport_id);
		} elseif ($group_sport_id) {
			echo get_the_title($group_sport_id);
		} elseif ($sport_id) {
			echo get_the_title($sport_id);
        }
	} elseif ($column_key == 'team_1') {
        $team_1 = get_field('team_1', $post_id);
        foreach($team_1 as $id => $user) {
            echo $user['label'] . '<br>';
        }
    } elseif ($column_key == 'team_2') {
        $team_1 = get_field('team_2', $post_id);
        foreach($team_1 as $id => $user) {
            echo $user['label'] . '<br>';
        }
    }
}, 10, 2);



function jg_display_game_summary($game_id) {
    $game = get_post($game_id);
    $acf = get_fields($game_id);

    // show league
    ?>
    <p><label>League:</label> <?php echo get_the_title($acf['league']); ?></p>
    <p><label>Sport:</label> <?php echo get_the_title($acf['sport']); ?></p>
    <?php
    // show sport

    // show teams

    // show scores
}

add_action( 'af/form/validate/key=form_616f468abb164', 'jg_validate_join_league_form', 10, 2 );
function jg_validate_join_league_form( $form, $args ) {
    $join_code = af_get_field('join_code');
    $league = get_posts(array(
        'post_type' => 'jg_league',
        'numberposts' => 1,
        'meta_key' => 'join_code',
        'meta_value' => $join_code,
    ));
    if (!$league) {
        af_add_error('join_code', 'That code doesn\'t do nothin\'.');
    }
}

/**
 * Validate New League form
 */
add_action( 'af/form/validate/key=form_615f415f11785', 'jg_validate_new_league_form', 10, 2 );
function jg_validate_new_league_form( $form, $args ) {
    $join_code = af_get_field('join_code');
    $leagues = get_posts(array(
        'post_type' => 'jg_league',
        'numberposts' => -1,
        'meta_key' => 'join_code',
        'meta_value' => $join_code,
    ));
    if ($leagues) {
        af_add_error('join_code', 'That join code is already taken. Be more original, son.');
    }
}

/**
 * Process New League form
 */
add_action( 'af/form/editing/post_created/key=form_615f415f11785', 'jg_process_new_league_form', 10, 3 );
function jg_process_new_league_form( $post, $form, $args ) {
    global $current_user;
    add_row('leagues', array('league_id' => $post->ID), 'user_'.$current_user->ID);
}

/**
 * Process Join League form
 */
add_action( 'af/form/submission', 'jg_process_join_league_form', 10, 3 );
function jg_process_join_league_form( $form, $fields, $args ) {
    global $current_user;

    // Join League form
    if ($form['key'] == 'form_616f468abb164') {

        $join_code = af_get_field('join_code');
        $league = get_posts(array(
            'post_type' => 'jg_league',
            'numberposts' => 1,
            'meta_key' => 'join_code',
            'meta_value' => $join_code,
        ));
        $league_id = $league[0]->ID;
        $user_leagues = get_field('leagues', 'user_'.$current_user->ID);
        $user_leagues_ids = array_map(function($league) {
            return $league['league_id'];
        }, $user_leagues);

        // add League to User's leagues
        if ($league_id && !in_array($league_id, $user_leagues_ids)) {
            add_row('leagues', array('league_id' => $league_id), 'user_'.$current_user->ID);
        }
    }
}

/**
 * Show League name in backend Edit User page
 */
add_action('acf/render_field/name=league_id', 'jg_render_league_id_field');
function jg_render_league_id_field( $field ) {
    if (!is_admin()) return;

    $league_id = $field['value'];
    $league_name = get_the_title($league_id);
    echo '<label>';
    echo ($league_name) ? $league_name : '(no name)';
    echo '</label>';
}



/**
 * Validate New Game form
 *
 * if 'scores' confirm all teams have a score
 * elseif 'winner' confirm exactly 1 winner
 *
 * confirm no repeat players
 */
add_action( 'af/form/validate/key=form_615deae16f142', 'jg_validate_new_game_form', 10, 2 );
function jg_validate_new_game_form( $form, $args ) {
    $scoring_type = af_get_field('choose_scoring_type');
    $teams = af_get_field('teams');
    $players = array();
    $scores = array();
    $winners = 0;

    if ($scoring_type == 'scores') { // if scoring type is "scores" - all score fields need value
        foreach ($teams as $key => $team) {
            if ($team['score'] == '') {
                af_add_error('teams', 'Enter a score for each team.');
                return;
            }
            $scores[$key] = $team['score'];
        }
    } else { // else scoring type is "winner" - check that 1 and only 1 has value
        foreach ($teams as $key => $team) {
            if ($team['win'] === true) {
                $winners++;
            }
        }
        if ($winners === 0) {
            af_add_error('teams', 'Choose the winning team.');
        } elseif ($winners > 1) {
            af_add_error('teams', 'Choose only one winner.');
        }
    }

    // get all players - confirm not double booked
    foreach($teams as $key => $team) {
        foreach($team['players'] as $player) {
            if (in_array($player, $players)) {
                af_add_error('teams', 'Players can only be on one team.');
            } else {
                $players[] = $player;
            }
        }
    }
}

/**
 * after New Game created
 *
 * If 'scores' - make sure the correct team has 'win'=true
 */
add_action( 'af/form/editing/post_created/key=form_615deae16f142', 'jg_new_game_created', 10, 3 );
function jg_new_game_created( $post, $form, $args ) {
    global $current_user;

    $scoring_type = get_field('choose_scoring_type', $post->ID);
    $teams = get_field('teams', $post->ID);
    $scores = array();
    $high_score = 0;

    // if 'scores', manually set the winning team
    if ($scoring_type == 'scores') {
        foreach($teams as $key => $team) {
            // save the score to array
            $scores[$key] = $team['score'];
            // check for new high score
            $high_score = ($team['score'] > $high_score) ? $team['score'] : $high_score;
        }
        // find the correct row
        $key = array_search($high_score, $scores);
        $row = $teams[$key];
        // set the winning team's 'win' field
        $row['win'] = true;
        update_row('teams', $key+1, $row, $post->ID);
    }

    // update $current_user's active league
    $active_league = get_field('active_league', 'user_'.$current_user->ID);
    $game_league = get_field('league', $post->ID);

    if ($active_league != $game_league) {
        update_field('active_league', $game_league, 'user_'.$current_user->ID);
    }

}

// add_filter('acf/prepare_field/type=button_group', 'jg_prepare_submit_button');
function jg_prepare_submit_button( $field ) {
    $field['class'] .= 'flex-wrap';
    return $field;
}
// add_filter('acf/prepare_field/type=checkbox', 'jg_prepare_checkbox_list');
function jg_prepare_checkbox_list( $field ) {
    $field['class'] .= 'flex-wrap d-flex';
    return $field;
}

/**
 * AF button
 */
add_filter('af/form/button_attributes', 'jg_submit_button_bootstrap_classes', 10, 3);
function jg_submit_button_bootstrap_classes($attributes, $form, $args)
{
    $attributes['class'] .= ' btn btn-primary';
    return $attributes;
}


/**
 * Convert ACF Checkboxes & Radios to Bootstrap buttons
 */
add_filter('acf/prepare_field/name=choose_scoring_type', 'jg_acf_bootstrap_buttons');
add_filter('acf/prepare_field/name=sport', 'jg_acf_bootstrap_buttons');
add_filter('acf/prepare_field/name=players', 'jg_acf_bootstrap_buttons');
function jg_acf_bootstrap_buttons( $field ) {
    // exit if it's the backend
    if (is_admin()) return $field;
    ?>
    <div class="acf-field <?php echo $field['wrapper']['class']; ?>">
        <?php if (strpos($field['parent'], 'field_') !== false) { ?>
        <div class="acf-label">
            <label for="<?php echo $field['id']; ?>">
                <?php echo $field['label']; ?>
                <?php if ($field['required']) { ?>
                    <span class="acf-required">*</span>
                <?php } ?>
            </label>
        </div>
        <?php } // endif ?>

        <input type="hidden" name="<?php echo $field['name'] ?>">
        <div class="btn-group-toggle jg-button-group" data-toggle="buttons">
            <?php foreach ($field['choices'] as $id => $choice) {
                $active = '';
                $checked = '';
                if (
                    (is_array($field['value']) && in_array($id, $field['value'])) ||
                    $field['value'] == $id
                ) {
                    $active = 'active';
                    $checked = 'checked="checked"';
                }
                $type = $field['type'];
                $name = ($type == 'checkbox') ? $field['name'].'[]' : $field['name'];
                $input_id = $field['id'] .'-'.$id;
                ?>
                <label class="btn btn-outline-primary <?php echo $active; ?>" data-choice="<?php echo $id; ?>">
                    <input
                        type="<?php echo $type; ?>"
                        id="<?php echo $input_id; ?>"
                        name="<?php echo $name; ?>"
                        value="<?php echo $id; ?>"
                        <?php echo $checked; ?>
                    >
                    <?php echo $choice; ?>
                </label>
            <?php } ?>
        </div>
    </div>
    <?php
    return false;
}
/*
<input type="hidden" name="acf[field_6169eadbbe96f][row-0][field_6169eb18be971]">
<input type="hidden" name="acf[field_6169eadbbe96f][row-0][field_616e152006168]">

<input type="checkbox" id="acf-field_6169eadbbe96f-row-0-field_6169eb18be971-user_12" name="acf[field_6169eadbbe96f][row-0][field_6169eb18be971]" value="user_12">
<input type="checkbox" id="acf-field_6169eadbbe96f-row-0-field_616e152006168-user_12" name="acf[field_6169eadbbe96f][row-0][field_616e152006168][]" value="user_12">



<div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn btn-secondary active">
    <input type="radio" name="options" id="option1" checked> Active
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="options" id="option2"> Radio
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="options" id="option3"> Radio
  </label>
</div>
*/
