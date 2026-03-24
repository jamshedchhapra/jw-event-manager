<?php get_header(); ?>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="jwem-card">

<?php if(has_post_thumbnail()): ?>
<img src="<?php the_post_thumbnail_url('large'); ?>" class="img-fluid">
<?php endif; ?>

<div class="p-4">

<h1><?php the_title(); ?></h1>

<div class="jwem-meta mb-3">
📅 Date: <?php echo get_post_meta(get_the_ID(),'event_date',true); ?>
</div>

<div class="mb-4">
<?php the_content(); ?>
</div>

<button class="jwem-btn">RSVP Now</button>

</div>

</div>

</div>

</div>

</div>

<?php get_footer(); ?>