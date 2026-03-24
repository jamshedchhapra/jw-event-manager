<?php get_header(); ?>

<?php 
$event_date = get_post_meta(get_the_ID(),'date',true);
$location   = get_post_meta(get_the_ID(),'loc',true);
$organizer  = get_post_meta(get_the_ID(),'organizer',true);
$rsvp_limit = get_post_meta(get_the_ID(),'rsvp_limit',true);
$published_date = get_the_date();
?>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="jwem-card bg-white">

<?php if (has_post_thumbnail()) : ?>
<img src="<?php the_post_thumbnail_url('large'); ?>" class="img-fluid w-100">
<?php endif; ?>

<div class="p-5">

<h1 class="mb-3"><?php the_title(); ?></h1>

<div class="jwem-meta mb-2">
📅 Event Date:
<strong>
<?php echo $event_date ? esc_html(date('F j, Y', strtotime($event_date))) : 'To Be Announced'; ?>
</strong>
</div>

<div class="jwem-meta mb-2">
📍 Location:
<strong>
<?php echo $location ? esc_html($location) : 'Not specified'; ?>
</strong>
</div>

<div class="jwem-meta mb-2">
👤 Organizer:
<strong>
<?php echo $organizer ? esc_html($organizer) : 'TBA'; ?>
</strong>
</div>

<div class="jwem-meta mb-4">
🎟 RSVP Limit:
<strong>
<?php echo $rsvp_limit ? esc_html($rsvp_limit) : 'Unlimited'; ?>
</strong>
</div>

<div class="mb-4">
<?php the_content(); ?>
</div>

<a href="#" class="jwem-btn">RSVP Now</a>

</div>

</div>

</div>

</div>

</div>

<?php get_footer(); ?>