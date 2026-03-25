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
📅 <?php esc_html_e('Event Date:', 'jw-event-manager'); ?>
<strong>
<?php echo $event_date ? esc_html(date_i18n(get_option('date_format'), strtotime($event_date))) : esc_html__('To Be Announced', 'jw-event-manager'); ?>
</strong>
</div>

<div class="jwem-meta mb-2">
📍 <?php esc_html_e('Location:', 'jw-event-manager'); ?>
<strong>
<?php echo $location ? esc_html($location) : esc_html__('Not specified', 'jw-event-manager'); ?>
</strong>
</div>

<div class="jwem-meta mb-2">
👤 <?php esc_html_e('Organizer:', 'jw-event-manager'); ?>
<strong>
<?php echo $organizer ? esc_html($organizer) : esc_html__('TBA', 'jw-event-manager'); ?>
</strong>
</div>

<div class="jwem-meta mb-4">
🎟 <?php esc_html_e('RSVP Limit:', 'jw-event-manager'); ?>
<strong>
<?php echo $rsvp_limit ? esc_html($rsvp_limit) : esc_html__('Unlimited', 'jw-event-manager'); ?>
</strong>
</div>

<div class="mb-4">
<?php the_content(); ?>
</div>

<!-- ==========================================
     START RSVP BUTTON + FORM (FIXED)
========================================== -->

<div class="mt-4">

    <!-- ==========================================
     START RSVP SECTION
========================================== -->

<div class="mt-4">

    <!-- RSVP BUTTON -->
    <a href="#" class="jwem-btn jwem-rsvp-toggle"><?php esc_html_e('RSVP Now', 'jw-event-manager'); ?></a>

    <!-- HIDDEN FORM -->
    <div class="jwem-rsvp-form mt-3" style="display:none;">

        <?php echo do_shortcode('[jwem_rsvp]'); ?>

    </div>

</div>

<!-- ==========================================
     END RSVP SECTION
========================================== -->


</div>

</div>

</div>

</div>

</div>

<?php get_footer(); ?>
