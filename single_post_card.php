<div class="col-md-4 utility-border mr-2 mb-2">
	<div class="text-center utility-img"><img src="https://i.ibb.co/DW9YPjW/stagecoach.png"></div>
	<p class="utility-headline"><a href="<?php the_permalink(); ?>"><span class="yellow-highlight"><?php echo get_the_title(); ?></span></a></p>
	<hr class="utility-block-hr">
	<div class="utility-text">
		<p><?php echo get_field('post_short_description'); ?></p>
	</div>
	<hr class='utility-block-hr-bottom'>
	<p style="font-weight: bold; font-style: italic;"><?php echo get_post_type(); ?> <span style="float: right;">12/01</span></p>
</div>