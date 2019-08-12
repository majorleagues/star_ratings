<?php

add_action('rest_api_init', 'star_rating_routes');

function star_rating_routes()
{
  register_rest_route('ratings/v2', 'manageRatings', array(
    'methods' => 'POST',
    'callback' => 'create_rating'
  ));

  register_rest_route('ratings/v2', 'manageRatings', array(
    'methods' => 'PUT',
    'callback' => 'update_rating'
  ));

  register_rest_route('ratings/v2', 'average', array(
    'methods' => 'GET',
    'callback' => 'get_post_average_rating'
  ));
}

add_action('rest_api_init', 'star_rating_routes');


function create_rating($data)
{
  $nonce = sanitize_text_field($data['check_nonce']);
  if(! wp_verify_nonce($nonce, 'wp_ajax_nonce')){
      return 'invalid nonce';
  }

  $post_id = sanitize_text_field($data['post_id']);
  $rating = sanitize_text_field($data['rating']);
  $user_id = sanitize_text_field($data['user_id']);
  $post_title = get_post_field('post_title', $post_id);

  return wp_insert_post(array(
    'post_type' => 'star_ratings',
    'post_author' => $user_id,
    'post_status' => 'publish',
    'post_title' => $post_title,
    'meta_input' => array(
      'rated_page' => $post_id,
      'rating' => $rating,
      'user_id' => $user_id
    )
  ));
}

function update_rating($data)
{
  $nonce = sanitize_text_field($data['check_nonce']);
  if(! wp_verify_nonce($nonce, 'wp_ajax_nonce')){
      return 'invalid nonce';
  }
  $post_id = sanitize_text_field($data['post_id']);
  $rating_id = sanitize_text_field($data['rating_id']);
  $rating = sanitize_text_field($data['rating']);
  $user_id = sanitize_text_field($data['user_id']);

  $update_args = array(
    'ID'           => $rating_id,
    'meta_input' => array(
      'rating' => $rating
    )
  );
  wp_update_post($update_args);
  return 'Congrats, rating updated';
}



function get_post_average_rating($data)
{
  $post_id = sanitize_text_field($data['post_id']);
  $average_rating = get_post_meta($post_id, 'average_rating', 1);
  $total_ratings = get_post_star_ratings_total($post_id);
  return wp_send_json(array(
    'total' => $total_ratings,
    'average' => $average_rating
  ));
}


add_action('added_post_meta', 'before_update_rating_average', 10, 4);
add_action('updated_post_meta', 'before_update_rating_average', 10, 4);
function before_update_rating_average($meta_id, $post_id, $meta_key, $meta_value)
{
  if ('rating' == $meta_key) {
    $rated_post = get_post_meta($post_id, 'rated_page', 1);
    update_rating_average($rated_post);
  }
}


function update_rating_average($post_id)
{
  $ratings = get_ratings_by_post_id($post_id);
  if (is_countable($ratings)) {
    $total_ratings = count($ratings);
  } else {
    $total_ratings = 1;
  }

  $total_ratings_sum = array_sum($ratings);
  $result = $total_ratings_sum / $total_ratings;
  $result = round($result, 1);
  return update_post_meta($post_id, 'average_rating', $result);
}


function get_ratings_by_post_id($post_id)
{
  $ratings_array = array();

  $args = array(
    'post_type'    => 'star_ratings',
    'meta_query' => array(
      array(
        'key' => 'rated_page',
        'compare' => '=',
        'value' => $post_id
      )
    )
  );

  $get_ratings = new WP_Query($args);

  if ($get_ratings->have_posts()) {
    while ($get_ratings->have_posts()) {
      $get_ratings->the_post();
      $rating_id = get_the_ID();
      $post_rating = get_post_meta($rating_id, 'rating', 1);
      $ratings_array[] = $post_rating;
    }
    wp_reset_postdata();
  }
  return $ratings_array;
}



function get_post_star_ratings_total($post_id)
{
  $ratings_query = new WP_Query(array(
    'post_type' => 'star_ratings',
    'meta_query' => array(
      array(
        'key' => 'rated_page',
        'compare' => '=',
        'value' => $post_id
      )
    )
  ));

  return $ratings_query->found_posts;
}


function get_user_rating_by_query($query)
{
  if (is_user_logged_in()) {
    if ($query->found_posts) {
      $post_id = $query->posts[0]->ID;
      return get_post_meta($post_id, 'rating', 1);
    }
  }
}
