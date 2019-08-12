<?php

function star_rating()
{


  $current_post_id = get_the_ID();
  $average_rating = get_post_meta($current_post_id, 'average_rating', 1);




  $rating_status = 'no';
  $rating_query = new WP_Query(array(
    'author' => get_current_user_id(),
    'post_type' => 'star_ratings',
    'meta_query' => array(
      array(
        'key' => 'rated_page',
        'compare' => '=',
        'value' => $current_post_id
      )
    )
  ));
  if ($rating_query->found_posts) {
    $rating_status = 'yes';
    $user_rating = (isset($rating_query) ? get_user_rating_by_query($rating_query) : null);
  }
  ?>
  <div class='article-content'>
    <div id='star-rating' data-rated="<?php if ($rating_status) {
                                        echo $rating_query->posts[0]->ID;
                                      } ?>" data-exists="<?php echo $rating_status; ?>" data-post="<?php echo $current_post_id; ?>" data-userid="<?php echo get_current_user_id(); ?>">
    </div>
    <form class='col-md-12' autocomplete="off">
      <fieldset class="rating" data-toggle="tooltip" data-placement="top" title="Only logged-in users can leave star ratings" <?php echo (is_user_logged_in() ? null : 'disabled') ?>>

        <?php
        for ($stars = 5; $stars > 0; $stars--) {
          $star = $stars;
          $default_rating_value = ceil($average_rating);
          $checked = ($star == $default_rating_value ? 'checked' : null);
          ?>
          <input type="radio" id="<?php echo $star; ?>" name="rating" value="<?php echo $star; ?>" <?php echo $checked; ?> /><label class="full" for="<?php echo $star; ?>"></label>

        <?php

        }
        ?>

      </fieldset>
      <span class='spinner'></span>
    </form>

    <div class='col-md-12 total-ratings text-muted'>
      <?php
      if ($average_rating > 0) {
        ?>
        <p>The average rating for this post is <span id='average-sum' class='font-weight-bold'><?php echo $average_rating; ?> </span> from <span id='ratings-sum' class='font-weight-bold'><?php echo get_post_star_ratings_total(get_the_ID()); ?></span> users</p>
      <?php
      } else {
        ?>
        <p id='no-user-ratings'> No users have rated this content</p>
      <?php
      }
      ?>

      <?php echo (isset($user_rating) ? "<p>You rated this content: <span id='user-rating' class='font-weight-bold'> $user_rating </span> </p>" : "<p id='no-results'></p>"); ?>
    </div>

  </div>

<?php
}

star_rating();

?>