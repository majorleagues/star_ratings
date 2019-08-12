<?php
wp_head();
?>
<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Hello, world!</title>
  </head>
  <body>
  <div class="wrapper">
  <div class="container">
  <div class="col-md-12" style="margin-top: 25px;">

  <div class="text-center">
  <img class='utility-logo-image' src="https://i.ibb.co/mvphjCn/stagecoach-1.png" />
    </div>

<section class="utility-section">
  <div class="category">From the blogs</div>    
  <hr class="utility-hr">
    <div class="utility-flex">

    <?php
    $args = array(
        'post_type' => 'post'
    );

    $posts = new WP_Query($args);
    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            include('single_post_card.php');
        }
        wp_reset_postdata();
}

?>
    </section>

      
 
  
  <hr>
</div>
<footer class="footer">
        <p class="text-muted text-center">Thanks for stopping by!</p>
      </div>
    </footer>
    </div>

  </body>
</html>

<?php wp_footer(); ?>
