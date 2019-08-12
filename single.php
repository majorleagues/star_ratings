<?php

wp_head();
?>

<!doctype html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title><?php the_title(); ?></title>
</head>

<body <?php body_class(); ?>>

  <div class="wrapper">
    <div class="container">
      <div class="col-md-12" style="margin-top: 25px;">

        <div class="text-center">
          <h1><?php the_title(); ?></h1>
        </div>

        <section class="utility-section">
          <div class="category"><?php echo get_post_type(); ?></div>
          <hr class="utility-hr">
          <div class="article-content">
            <?php
            while (have_posts()) {
              the_post(); ?>
              <p><?php the_content(); ?></p>
            <?php }

            ?>

          </div>
        </section>

        <?php include(get_template_directory() . '/star_rating.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
       
        <?php
        wp_footer();


        ?>