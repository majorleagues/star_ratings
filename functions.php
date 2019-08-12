
<?php

require get_theme_file_path('/star_rating_functions.php');


function register_star_rating_post_type()
{

    register_post_type(
        'star_ratings',
        array(
            'supports' => array('title', 'author'),
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Star Ratings',
                'add_new_item' => 'Add Rating',
                'edit_item' => 'Edit Rating',
                'all_items' => 'All Ratings',
                'singular_name' => 'Star Ratings'

            ),
            'menu_icons' => 'dashicons-heart'
        )
    );
}
add_action('init', 'register_star_rating_post_type');

function mytheme_enqueue_style()
{
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
    wp_enqueue_style('fontAwesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css');
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_style');




function bl_rating_files()
{
    wp_deregister_script('jquery');
    wp_register_script('jquery', "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js", array(), '3.4.1');

    wp_enqueue_script('jquery');
    wp_register_script('bl_star_rating_js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0', true);
    wp_enqueue_script('bl_star_rating_js');


    wp_localize_script('bl_star_rating_js', 'blData', array(
        'ratingsRestURL' => get_rest_url(null, '/ratings/v2/manageRatings'),
        'averageRestURL' => get_rest_url(null, '/ratings/v2/average'),
        'nonce' => wp_create_nonce('wp_rest'),
        'ajax_nonce' => wp_create_nonce('wp_ajax_nonce'),
        'currentUser' => get_current_user_id()
    ));
}

add_action('wp_enqueue_scripts', 'bl_rating_files');




function wp_body_classes($classes)
{
    if (is_user_logged_in()) {
        $classes[] = 'logged-in';
    }


    return $classes;
}
add_filter('body_class', 'wp_body_classes');

?>
