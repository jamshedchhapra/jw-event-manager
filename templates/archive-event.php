<?php get_header(); ?>

<div class="container py-5">

<h1 class="mb-4">Events</h1>

<div class="row">

<?php
/**
 * Use main query for archive
 * Better performance + pagination support
 */
if (have_posts()) :
while (have_posts()) : the_post();
?>

while($events->have_posts()): $events->the_post();
?>

<div class="col-md-4 mb-4">

<div class="jwem-card">

<?php if(has_post_thumbnail()): ?>
<img src="<?php the_post_thumbnail_url('medium'); ?>" class="img-fluid">
<?php endif; ?>

<div class="p-3">

<h4><?php the_title(); ?></h4>

<div class="jwem-meta mb-2">
📅 <?php echo get_post_meta(get_the_ID(),'event_date',true); ?>
</div>

<a href="<?php the_permalink(); ?>" class="jwem-btn">View Event</a>

</div>

</div>

</div>

<?php endwhile; wp_reset_postdata(); ?>

</div>

</div>

<?php get_footer(); ?>