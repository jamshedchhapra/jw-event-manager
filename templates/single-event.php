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
<img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" class="img-fluid w-100" alt="<?php echo esc_attr(get_the_title()); ?>">
<?php endif; ?>

<div class="p-5">

<h1 class="mb-3"><?php echo esc_html(get_the_title()); ?></h1>

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
<?php echo wp_kses_post(apply_filters('the_content', get_the_content())); ?>
</div>

<div class="mt-4">

<div class="mt-4">

    <!-- RSVP button -->
    <a href="#" class="jwem-btn jwem-rsvp-toggle"><?php esc_html_e('RSVP Now', 'jw-event-manager'); ?></a>

    <!-- Hidden RSVP form -->
    <div class="jwem-rsvp-form mt-3" style="display:none;">

        <?php echo do_shortcode('[jwem_rsvp]'); ?>

    </div>

</div>

</div>

</div>

</div>

</div>

</div>

<?php get_footer(); ?>
